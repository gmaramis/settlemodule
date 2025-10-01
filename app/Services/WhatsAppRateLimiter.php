<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class WhatsAppRateLimiter
{
    protected $maxMessagesPerMinute;
    protected $maxMessagesPerHour;
    protected $maxMessagesPerDay;

    public function __construct()
    {
        $this->maxMessagesPerMinute = config('services.whatsapp.rate_limit.per_minute', 10);
        $this->maxMessagesPerHour = config('services.whatsapp.rate_limit.per_hour', 100);
        $this->maxMessagesPerDay = config('services.whatsapp.rate_limit.per_day', 500);
    }

    /**
     * Check if we can send a message based on rate limits
     *
     * @param string $phoneNumber
     * @return array
     */
    public function canSendMessage(string $phoneNumber): array
    {
        $now = now();
        
        // Check minute limit
        $minuteKey = "whatsapp_minute_{$phoneNumber}_{$now->format('Y-m-d-H-i')}";
        $minuteCount = Cache::get($minuteKey, 0);
        
        if ($minuteCount >= $this->maxMessagesPerMinute) {
            return [
                'can_send' => false,
                'reason' => 'minute_limit_exceeded',
                'limit' => $this->maxMessagesPerMinute,
                'current' => $minuteCount,
                'reset_at' => $now->addMinute()->startOfMinute()
            ];
        }

        // Check hour limit
        $hourKey = "whatsapp_hour_{$phoneNumber}_{$now->format('Y-m-d-H')}";
        $hourCount = Cache::get($hourKey, 0);
        
        if ($hourCount >= $this->maxMessagesPerHour) {
            return [
                'can_send' => false,
                'reason' => 'hour_limit_exceeded',
                'limit' => $this->maxMessagesPerHour,
                'current' => $hourCount,
                'reset_at' => $now->addHour()->startOfHour()
            ];
        }

        // Check day limit
        $dayKey = "whatsapp_day_{$phoneNumber}_{$now->format('Y-m-d')}";
        $dayCount = Cache::get($dayKey, 0);
        
        if ($dayCount >= $this->maxMessagesPerDay) {
            return [
                'can_send' => false,
                'reason' => 'day_limit_exceeded',
                'limit' => $this->maxMessagesPerDay,
                'current' => $dayCount,
                'reset_at' => $now->addDay()->startOfDay()
            ];
        }

        return [
            'can_send' => true,
            'limits' => [
                'minute' => ['current' => $minuteCount, 'limit' => $this->maxMessagesPerMinute],
                'hour' => ['current' => $hourCount, 'limit' => $this->maxMessagesPerHour],
                'day' => ['current' => $dayCount, 'limit' => $this->maxMessagesPerDay],
            ]
        ];
    }

    /**
     * Record a message sent
     *
     * @param string $phoneNumber
     * @return void
     */
    public function recordMessageSent(string $phoneNumber): void
    {
        $now = now();
        
        // Increment counters
        $minuteKey = "whatsapp_minute_{$phoneNumber}_{$now->format('Y-m-d-H-i')}";
        $hourKey = "whatsapp_hour_{$phoneNumber}_{$now->format('Y-m-d-H')}";
        $dayKey = "whatsapp_day_{$phoneNumber}_{$now->format('Y-m-d')}";

        Cache::increment($minuteKey, 1);
        Cache::increment($hourKey, 1);
        Cache::increment($dayKey, 1);

        // Set expiration times
        Cache::put($minuteKey, Cache::get($minuteKey), now()->addMinutes(2));
        Cache::put($hourKey, Cache::get($hourKey), now()->addHours(2));
        Cache::put($dayKey, Cache::get($dayKey), now()->addDays(2));

        Log::info('WhatsApp rate limiter recorded message', [
            'phone_number' => $this->maskPhoneNumber($phoneNumber),
            'timestamp' => $now->toISOString()
        ]);
    }

    /**
     * Get current usage statistics
     *
     * @param string $phoneNumber
     * @return array
     */
    public function getUsageStats(string $phoneNumber): array
    {
        $now = now();
        
        $minuteKey = "whatsapp_minute_{$phoneNumber}_{$now->format('Y-m-d-H-i')}";
        $hourKey = "whatsapp_hour_{$phoneNumber}_{$now->format('Y-m-d-H')}";
        $dayKey = "whatsapp_day_{$phoneNumber}_{$now->format('Y-m-d')}";

        return [
            'minute' => [
                'current' => Cache::get($minuteKey, 0),
                'limit' => $this->maxMessagesPerMinute,
                'percentage' => round((Cache::get($minuteKey, 0) / $this->maxMessagesPerMinute) * 100, 2)
            ],
            'hour' => [
                'current' => Cache::get($hourKey, 0),
                'limit' => $this->maxMessagesPerHour,
                'percentage' => round((Cache::get($hourKey, 0) / $this->maxMessagesPerHour) * 100, 2)
            ],
            'day' => [
                'current' => Cache::get($dayKey, 0),
                'limit' => $this->maxMessagesPerDay,
                'percentage' => round((Cache::get($dayKey, 0) / $this->maxMessagesPerDay) * 100, 2)
            ]
        ];
    }

    /**
     * Reset rate limits for a phone number
     *
     * @param string $phoneNumber
     * @return void
     */
    public function resetLimits(string $phoneNumber): void
    {
        $now = now();
        
        $keys = [
            "whatsapp_minute_{$phoneNumber}_{$now->format('Y-m-d-H-i')}",
            "whatsapp_hour_{$phoneNumber}_{$now->format('Y-m-d-H')}",
            "whatsapp_day_{$phoneNumber}_{$now->format('Y-m-d')}",
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }

        Log::info('WhatsApp rate limits reset', [
            'phone_number' => $this->maskPhoneNumber($phoneNumber)
        ]);
    }

    /**
     * Mask phone number for logging
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
}




