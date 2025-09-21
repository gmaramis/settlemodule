<?php

namespace App\Services;

use App\Models\BroadcastMessage;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\DB;

class BroadcastService
{
    protected $whatsappService;
    protected $loggingService;

    public function __construct(
        FonnteWhatsAppService $whatsappService,
        LoggingService $loggingService
    ) {
        $this->whatsappService = $whatsappService;
        $this->loggingService = $loggingService;
    }

    /**
     * Kirim broadcast message ke semua mahasiswa
     *
     * @param BroadcastMessage $broadcastMessage
     * @param array $options
     * @return array
     */
    public function sendBroadcast(BroadcastMessage $broadcastMessage, array $options = []): array
    {
        try {
            // Tandai sebagai sedang dikirim
            $broadcastMessage->markAsSending();

            // Dapatkan daftar target penerima
            $recipients = $this->getRecipients($broadcastMessage->target_criteria ?? []);
            
            if ($recipients->isEmpty()) {
                $broadcastMessage->markAsFailed('Tidak ada penerima yang ditemukan');
                return [
                    'success' => false,
                    'message' => 'Tidak ada mahasiswa yang memenuhi kriteria target',
                    'recipients_count' => 0
                ];
            }

            // Update total recipients
            $broadcastMessage->update(['total_recipients' => $recipients->count()]);

            // Log aktivitas
            $this->loggingService->logSystem(
                'broadcast_started',
                "Broadcast message '{$broadcastMessage->title}' mulai dikirim ke {$recipients->count()} mahasiswa",
                [
                    'broadcast_id' => $broadcastMessage->id,
                    'recipients_count' => $recipients->count(),
                    'created_by' => $broadcastMessage->created_by
                ]
            );

            // Kirim pesan secara batch
            $result = $this->sendBatchMessages($broadcastMessage, $recipients, $options);

            // Update status berdasarkan hasil
            if ($result['success']) {
                $broadcastMessage->markAsSent($result['sent_count'], $result['failed_count']);
                
                $this->loggingService->logSystem(
                    'broadcast_completed',
                    "Broadcast message '{$broadcastMessage->title}' selesai dikirim",
                    [
                        'broadcast_id' => $broadcastMessage->id,
                        'sent_count' => $result['sent_count'],
                        'failed_count' => $result['failed_count']
                    ]
                );
            } else {
                $broadcastMessage->markAsFailed($result['error'] ?? 'Gagal mengirim broadcast');
            }

            return $result;

        } catch (\Exception $e) {
            Log::error('Broadcast service error', [
                'broadcast_id' => $broadcastMessage->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $broadcastMessage->markAsFailed($e->getMessage());

            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengirim broadcast: ' . $e->getMessage(),
                'recipients_count' => 0
            ];
        }
    }

    /**
     * Dapatkan daftar penerima berdasarkan kriteria
     *
     * @param array $criteria
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getRecipients(array $criteria = []): \Illuminate\Database\Eloquent\Collection
    {
        if (isset($criteria['target_type']) && $criteria['target_type'] === 'specific') {
            // Get specific students
            $selectedStudents = $criteria['selected_students'] ?? [];
            $studentIds = array_column($selectedStudents, 'id');
            
            // If no students selected, return empty Eloquent collection
            if (empty($studentIds)) {
                return User::whereRaw('1 = 0')->get();
            }
            
            return User::whereIn('id', $studentIds)
                ->where('is_active', true)
                ->whereNotNull('phone')
                ->where('phone', '!=', '')
                ->get();
        } else {
            // Get all students
            return User::where('is_active', true)
                ->where('role', 'student')
                ->whereNotNull('phone')
                ->where('phone', '!=', '')
                ->get();
        }
    }

    /**
     * Kirim pesan secara batch
     *
     * @param BroadcastMessage $broadcastMessage
     * @param \Illuminate\Database\Eloquent\Collection $recipients
     * @param array $options
     * @return array
     */
    protected function sendBatchMessages(
        BroadcastMessage $broadcastMessage, 
        \Illuminate\Database\Eloquent\Collection $recipients, 
        array $options = []
    ): array {
        $sentCount = 0;
        $failedCount = 0;
        $deliveryLog = [];
        $batchSize = $options['batch_size'] ?? 10; // Kirim 10 pesan per batch
        $delayBetweenBatches = $options['delay_between_batches'] ?? 2; // Delay 2 detik antar batch

        $batches = $recipients->chunk($batchSize);
        $totalBatches = $batches->count();

        Log::info("Starting broadcast in {$totalBatches} batches", [
            'broadcast_id' => $broadcastMessage->id,
            'total_recipients' => $recipients->count(),
            'batch_size' => $batchSize
        ]);

        foreach ($batches as $batchIndex => $batch) {
            $batchNumber = $batchIndex + 1;
            
            Log::info("Processing batch {$batchNumber}/{$totalBatches}", [
                'broadcast_id' => $broadcastMessage->id,
                'batch_size' => $batch->count()
            ]);

            foreach ($batch as $recipient) {
                try {
                    $result = $this->whatsappService->sendMessage(
                        $recipient->phone,
                        $broadcastMessage->message
                    );

                    if ($result['success']) {
                        $sentCount++;
                        $deliveryLog[] = [
                            'user_id' => $recipient->id,
                            'phone' => $this->maskPhoneNumber($recipient->phone),
                            'status' => 'success',
                            'timestamp' => now()->format('Y-m-d H:i:s')
                        ];
                    } else {
                        $failedCount++;
                        $deliveryLog[] = [
                            'user_id' => $recipient->id,
                            'phone' => $this->maskPhoneNumber($recipient->phone),
                            'status' => 'failed',
                            'error' => $result['error'] ?? 'Unknown error',
                            'timestamp' => now()->format('Y-m-d H:i:s')
                        ];
                    }

                } catch (\Exception $e) {
                    $failedCount++;
                    $deliveryLog[] = [
                        'user_id' => $recipient->id,
                        'phone' => $this->maskPhoneNumber($recipient->phone),
                        'status' => 'failed',
                        'error' => $e->getMessage(),
                        'timestamp' => now()->format('Y-m-d H:i:s')
                    ];

                    Log::error("Failed to send broadcast to user {$recipient->id}", [
                        'broadcast_id' => $broadcastMessage->id,
                        'user_id' => $recipient->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            // Update progress di database
            $broadcastMessage->update([
                'sent_count' => $sentCount,
                'failed_count' => $failedCount,
                'delivery_log' => $deliveryLog
            ]);

            // Delay antar batch untuk menghindari rate limiting
            if ($batchNumber < $totalBatches) {
                sleep($delayBetweenBatches);
            }
        }

        return [
            'success' => true,
            'sent_count' => $sentCount,
            'failed_count' => $failedCount,
            'total_recipients' => $recipients->count(),
            'delivery_log' => $deliveryLog
        ];
    }


    /**
     * Dapatkan statistik broadcast
     *
     * @return array
     */
    public function getBroadcastStats(): array
    {
        return [
            'total_broadcasts' => BroadcastMessage::count(),
            'draft_broadcasts' => BroadcastMessage::draft()->count(),
            'sent_broadcasts' => BroadcastMessage::sent()->count(),
            'failed_broadcasts' => BroadcastMessage::failed()->count(),
            'scheduled_broadcasts' => BroadcastMessage::scheduled()->count(),
            'total_recipients' => BroadcastMessage::sent()->sum('total_recipients'),
            'total_sent_messages' => BroadcastMessage::sent()->sum('sent_count'),
            'total_failed_messages' => BroadcastMessage::sent()->sum('failed_count'),
        ];
    }

    /**
     * Mask phone number untuk logging
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
     * Test broadcast dengan satu penerima
     *
     * @param BroadcastMessage $broadcastMessage
     * @param string $testPhoneNumber
     * @return array
     */
    public function testBroadcast(BroadcastMessage $broadcastMessage, string $testPhoneNumber): array
    {
        try {
            $result = $this->whatsappService->sendMessage($testPhoneNumber, $broadcastMessage->message);
            
            $this->loggingService->logSystem(
                'broadcast_test',
                "Test broadcast message '{$broadcastMessage->title}' dikirim ke {$testPhoneNumber}",
                [
                    'broadcast_id' => $broadcastMessage->id,
                    'test_phone' => $this->maskPhoneNumber($testPhoneNumber),
                    'success' => $result['success']
                ]
            );

            return $result;

        } catch (\Exception $e) {
            Log::error('Broadcast test failed', [
                'broadcast_id' => $broadcastMessage->id,
                'test_phone' => $this->maskPhoneNumber($testPhoneNumber),
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Jadwalkan broadcast message untuk dikirim di waktu yang ditentukan
     *
     * @param BroadcastMessage $broadcastMessage
     * @param \DateTime $scheduledAt
     * @return array
     */
    public function scheduleBroadcast(BroadcastMessage $broadcastMessage, \DateTime $scheduledAt): array
    {
        try {
            // Update status broadcast menjadi scheduled
            $broadcastMessage->update([
                'status' => 'scheduled',
                'scheduled_at' => $scheduledAt
            ]);

            // Log aktivitas scheduling
            $this->loggingService->logSystem(
                'broadcast_scheduled',
                "Broadcast message '{$broadcastMessage->title}' dijadwalkan untuk {$scheduledAt->format('Y-m-d H:i:s')}",
                [
                    'broadcast_id' => $broadcastMessage->id,
                    'scheduled_at' => $scheduledAt->format('Y-m-d H:i:s'),
                    'created_by' => $broadcastMessage->created_by
                ]
            );

            // TODO: Implementasi job queue untuk scheduled broadcast
            // Untuk sementara, kita hanya menyimpan jadwal di database
            // Di implementasi lengkap, ini akan menggunakan Laravel's job queue system

            return [
                'success' => true,
                'message' => 'Broadcast berhasil dijadwalkan',
                'scheduled_at' => $scheduledAt->format('Y-m-d H:i:s')
            ];

        } catch (\Exception $e) {
            Log::error('Broadcast scheduling failed', [
                'broadcast_id' => $broadcastMessage->id,
                'scheduled_at' => $scheduledAt->format('Y-m-d H:i:s'),
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => 'Gagal menjadwalkan broadcast: ' . $e->getMessage()
            ];
        }
    }
}
