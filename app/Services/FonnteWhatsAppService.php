<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class FonnteWhatsAppService
{
    protected $client;
    protected $apiToken;
    protected $apiUrl;
    protected $rateLimiter;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiToken = config('services.fonnte.token', env('FONNTE_API_TOKEN'));
        $this->apiUrl = config('services.fonnte.url', env('FONNTE_API_URL', 'https://api.fonnte.com/send'));
        $this->rateLimiter = app(WhatsAppRateLimiter::class);
    }

    /**
     * Send WhatsApp message with retry mechanism
     *
     * @param string $phoneNumber Phone number in international format (6281234567890)
     * @param string $message Message content
     * @param int $maxRetries Maximum number of retries
     * @return array
     */
    public function sendMessage(string $phoneNumber, string $message, ?int $maxRetries = null): array
    {
        // Use configured max retries if not provided
        if ($maxRetries === null) {
            $maxRetries = config('services.whatsapp.retry.max_attempts', 3);
        }

        // Validate inputs
        if (!$this->validatePhoneNumber($phoneNumber)) {
            return [
                'success' => false,
                'error' => 'Invalid phone number format',
                'code' => 'INVALID_PHONE'
            ];
        }

        if (empty(trim($message))) {
            return [
                'success' => false,
                'error' => 'Message cannot be empty',
                'code' => 'EMPTY_MESSAGE'
            ];
        }

        // Check rate limits
        $rateLimitCheck = $this->rateLimiter->canSendMessage($phoneNumber);
        if (!$rateLimitCheck['can_send']) {
            Log::warning('WhatsApp message blocked by rate limit', [
                'phone_number' => $this->maskPhoneNumber($phoneNumber),
                'reason' => $rateLimitCheck['reason'],
                'limit' => $rateLimitCheck['limit'],
                'current' => $rateLimitCheck['current'],
                'reset_at' => $rateLimitCheck['reset_at']->toISOString()
            ]);

            return [
                'success' => false,
                'error' => 'Rate limit exceeded',
                'code' => strtoupper($rateLimitCheck['reason']),
                'limit' => $rateLimitCheck['limit'],
                'current' => $rateLimitCheck['current'],
                'reset_at' => $rateLimitCheck['reset_at']
            ];
        }

        $attempt = 0;
        $lastError = null;

        while ($attempt < $maxRetries) {
            $attempt++;
            
            try {
                $response = $this->client->post($this->apiUrl, [
                    'headers' => [
                        'Authorization' => $this->apiToken,
                        'Content-Type' => 'application/json',
                    ],
                    'json' => [
                        'target' => $phoneNumber,
                        'message' => $this->addSignature($message),
                        'delay' => '2-5'
                    ],
                    'timeout' => 30,
                    'connect_timeout' => 10
                ]);

                $responseBody = json_decode($response->getBody()->getContents(), true);
                
                // Check if response indicates success
                if (isset($responseBody['status']) && $responseBody['status'] === true) {
                    // Record successful message in rate limiter
                    $this->rateLimiter->recordMessageSent($phoneNumber);

                    Log::info('Fonnte WhatsApp API Success', [
                        'phone_number' => $this->maskPhoneNumber($phoneNumber),
                        'attempt' => $attempt,
                        'message_length' => strlen($message),
                        'response' => $responseBody
                    ]);

                    return [
                        'success' => true,
                        'data' => $responseBody,
                        'attempt' => $attempt
                    ];
                } else {
                    $errorMessage = $responseBody['detail'] ?? 'Unknown API error';
                    throw new \Exception($errorMessage);
                }

            } catch (GuzzleException $e) {
                $lastError = $e;
                
                Log::warning('Fonnte WhatsApp API Retry', [
                    'phone_number' => $this->maskPhoneNumber($phoneNumber),
                    'attempt' => $attempt,
                    'max_retries' => $maxRetries,
                    'error' => $e->getMessage(),
                    'code' => $e->getCode()
                ]);

                // Don't retry for certain error types
                if ($this->shouldNotRetry($e)) {
                    break;
                }

                // Wait before retry (exponential backoff)
                if ($attempt < $maxRetries) {
                    $delay = pow(2, $attempt) * 1000; // 2s, 4s, 8s...
                    usleep($delay * 1000); // Convert to microseconds
                }
            }
        }

        // All retries failed
        Log::error('Fonnte WhatsApp API Failed After Retries', [
            'phone_number' => $this->maskPhoneNumber($phoneNumber),
            'total_attempts' => $attempt,
            'error' => $lastError ? $lastError->getMessage() : 'Unknown error',
            'code' => $lastError ? $lastError->getCode() : 'UNKNOWN'
        ]);

        return [
            'success' => false,
            'error' => $lastError ? $lastError->getMessage() : 'Failed after all retries',
            'code' => $lastError ? $lastError->getCode() : 'RETRY_FAILED',
            'attempts' => $attempt
        ];
    }

    /**
     * Send incident report notification to admin
     *
     * @param array $incidentData
     * @return array
     */
    public function sendIncidentNotification(array $incidentData): array
    {
        $adminNumber = config('services.fonnte.admin_number', env('ADMIN_WHATSAPP_NUMBER'));
        
        $message = $this->formatIncidentMessage($incidentData);
        
        return $this->sendMessage($adminNumber, $message);
    }

    /**
     * Send weekly reflection notification to admin
     *
     * @param array $reflectionData
     * @return array
     */
    public function sendReflectionNotification(array $reflectionData): array
    {
        $adminNumber = config('services.fonnte.admin_number', env('ADMIN_WHATSAPP_NUMBER'));
        
        $message = $this->formatReflectionMessage($reflectionData);
        
        return $this->sendMessage($adminNumber, $message);
    }

    /**
     * Send learning log notification to admin
     *
     * @param array $learningLogData
     * @return array
     */
    public function sendLearningLogNotification(array $learningLogData): array
    {
        $adminNumber = config('services.fonnte.admin_number', env('ADMIN_WHATSAPP_NUMBER'));
        
        $message = $this->formatLearningLogMessage($learningLogData);
        
        return $this->sendMessage($adminNumber, $message);
    }

    /**
     * Format incident message for WhatsApp
     *
     * @param array $incidentData
     * @return string
     */
    protected function formatIncidentMessage(array $incidentData): string
    {
        return WhatsAppMessageTemplate::incidentReport($incidentData);
    }

    /**
     * Format reflection message for WhatsApp
     *
     * @param array $reflectionData
     * @return string
     */
    protected function formatReflectionMessage(array $reflectionData): string
    {
        return WhatsAppMessageTemplate::weeklyReflection($reflectionData);
    }

    /**
     * Format learning log message for WhatsApp
     *
     * @param array $learningLogData
     * @return string
     */
    protected function formatLearningLogMessage(array $learningLogData): string
    {
        return WhatsAppMessageTemplate::learningLog($learningLogData);
    }

    /**
     * Test WhatsApp connection
     *
     * @return array
     */
    public function testConnection(): array
    {
        $adminNumber = config('services.fonnte.admin_number', env('ADMIN_WHATSAPP_NUMBER'));
        $message = WhatsAppMessageTemplate::testConnection();

        return $this->sendMessage($adminNumber, $message);
    }

    /**
     * Send system alert
     *
     * @param string $alertType
     * @param string $message
     * @param array $data
     * @return array
     */
    public function sendSystemAlert(string $alertType, string $message, array $data = []): array
    {
        $adminNumber = config('services.fonnte.admin_number', env('ADMIN_WHATSAPP_NUMBER'));
        $alertMessage = WhatsAppMessageTemplate::systemAlert($alertType, $message, $data);

        return $this->sendMessage($adminNumber, $alertMessage);
    }

    /**
     * Send quota alert
     *
     * @param array $quotaData
     * @return array
     */
    public function sendQuotaAlert(array $quotaData): array
    {
        $adminNumber = config('services.fonnte.admin_number', env('ADMIN_WHATSAPP_NUMBER'));
        $message = WhatsAppMessageTemplate::quotaAlert($quotaData);

        return $this->sendMessage($adminNumber, $message);
    }

    /**
     * Validate phone number format
     *
     * @param string $phoneNumber
     * @return bool
     */
    protected function validatePhoneNumber(string $phoneNumber): bool
    {
        // Indonesian phone number format: 6281234567890
        return preg_match('/^62\d{9,13}$/', $phoneNumber);
    }

    /**
     * Mask phone number for logging (privacy)
     *
     * @param string $phoneNumber
     * @return string
     */
    protected function maskPhoneNumber(string $phoneNumber): string
    {
        if (strlen($phoneNumber) <= 8) {
            return str_repeat('*', strlen($phoneNumber));
        }
        
        return substr($phoneNumber, 0, 4) . str_repeat('*', strlen($phoneNumber) - 8) . substr($phoneNumber, -4);
    }

    /**
     * Check if error should not be retried
     *
     * @param \Throwable $e
     * @return bool
     */
    protected function shouldNotRetry(\Throwable $e): bool
    {
        $noRetryCodes = [
            400, // Bad Request
            401, // Unauthorized
            403, // Forbidden
            404, // Not Found
            422, // Unprocessable Entity
        ];

        // Check for HTTP status codes if available
        if ($e instanceof GuzzleException && method_exists($e, 'getCode')) {
            return in_array($e->getCode(), $noRetryCodes);
        }

        // Don't retry for certain error messages
        $noRetryMessages = [
            'invalid phone number',
            'phone number not found',
            'insufficient quota',
            'invalid api token',
        ];

        foreach ($noRetryMessages as $message) {
            if (stripos($e->getMessage(), $message) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get API quota information
     *
     * @return array
     */
    public function getQuotaInfo(): array
    {
        try {
            $response = $this->client->get('https://api.fonnte.com/validate', [
                'headers' => [
                    'Authorization' => $this->apiToken,
                ],
                'timeout' => 10
            ]);

            $responseBody = json_decode($response->getBody()->getContents(), true);
            
            return [
                'success' => true,
                'data' => $responseBody
            ];

        } catch (GuzzleException $e) {
            Log::error('Failed to get quota info', [
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Check if API is healthy
     *
     * @return bool
     */
    public function isHealthy(): bool
    {
        $quotaInfo = $this->getQuotaInfo();
        
        if (!$quotaInfo['success']) {
            return false;
        }

        // Check if we have remaining quota
        $data = $quotaInfo['data'] ?? [];
        $quota = $data['quota'] ?? [];
        
        foreach ($quota as $phone => $info) {
            if (isset($info['remaining']) && $info['remaining'] <= 0) {
                return false;
            }
        }

        return true;
    }

    /**
     * Add signature to message
     *
     * @param string $message
     * @return string
     */
    protected function addSignature(string $message): string
    {
        $signature = "\n\n---\nAdmin Settle";
        
        // Check if signature already exists to avoid duplication
        if (strpos($message, 'Admin Settle') !== false) {
            return $message;
        }
        
        return $message . $signature;
    }

}
