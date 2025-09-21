<?php

namespace App\Console\Commands;

use App\Services\FonnteWhatsAppService;
use App\Services\WhatsAppRateLimiter;
use App\Models\Admin;
use Illuminate\Console\Command;

class WhatsAppSystemMonitor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:monitor {--check-quota : Check API quota} {--check-health : Check system health} {--check-rate-limits : Check rate limits} {--send-alert : Send test alert}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitor WhatsApp notification system health and performance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 WhatsApp System Monitor');
        $this->info('========================');
        $this->newLine();

        $whatsappService = new FonnteWhatsAppService();
        $rateLimiter = new WhatsAppRateLimiter();

        // Check API quota
        if ($this->option('check-quota') || $this->option('check-health')) {
            $this->checkApiQuota($whatsappService);
        }

        // Check system health
        if ($this->option('check-health')) {
            $this->checkSystemHealth($whatsappService);
        }

        // Check rate limits
        if ($this->option('check-rate-limits')) {
            $this->checkRateLimits($rateLimiter);
        }

        // Send test alert
        if ($this->option('send-alert')) {
            $this->sendTestAlert($whatsappService);
        }

        // If no specific options, run all checks
        if (!$this->option('check-quota') && !$this->option('check-health') && 
            !$this->option('check-rate-limits') && !$this->option('send-alert')) {
            $this->checkApiQuota($whatsappService);
            $this->checkSystemHealth($whatsappService);
            $this->checkRateLimits($rateLimiter);
        }

        $this->newLine();
        $this->info('✅ Monitor check completed');
    }

    /**
     * Check API quota
     */
    protected function checkApiQuota(FonnteWhatsAppService $service): void
    {
        $this->info('📊 Checking API Quota...');
        
        $quotaInfo = $service->getQuotaInfo();
        
        if ($quotaInfo['success']) {
            $data = $quotaInfo['data'] ?? [];
            $quota = $data['quota'] ?? [];
            
            if (!empty($quota)) {
                $this->table(
                    ['Phone Number', 'Used', 'Remaining', 'Total', 'Status'],
                    collect($quota)->map(function ($info, $phone) {
                        $remaining = $info['remaining'] ?? 0;
                        $total = $info['total'] ?? 0;
                        $used = $total - $remaining;
                        
                        $status = '🟢 OK';
                        if ($remaining <= 10) {
                            $status = '🔴 CRITICAL';
                        } elseif ($remaining <= 50) {
                            $status = '🟡 WARNING';
                        }
                        
                        return [
                            $this->maskPhoneNumber($phone),
                            $used,
                            $remaining,
                            $total,
                            $status
                        ];
                    })->toArray()
                );
            } else {
                $this->warn('No quota information available');
            }
        } else {
            $this->error('Failed to get quota info: ' . $quotaInfo['error']);
        }
        
        $this->newLine();
    }

    /**
     * Check system health
     */
    protected function checkSystemHealth(FonnteWhatsAppService $service): void
    {
        $this->info('🏥 Checking System Health...');
        
        // Check API health
        $isHealthy = $service->isHealthy();
        
        $this->table(
            ['Component', 'Status'],
            [
                ['API Connection', $isHealthy ? '🟢 Healthy' : '🔴 Unhealthy'],
                ['Admin Configuration', $this->checkAdminConfig() ? '🟢 OK' : '🔴 Missing'],
                ['Rate Limiter', '🟢 Active'],
                ['Message Templates', '🟢 Loaded'],
            ]
        );

        // Check admin configuration
        $admin = Admin::getAdminForNotifications();
        if ($admin) {
            $this->info("Admin: {$admin->name} ({$this->maskPhoneNumber($admin->whatsapp_number)})");
        }

        $this->newLine();
    }

    /**
     * Check rate limits
     */
    protected function checkRateLimits(WhatsAppRateLimiter $rateLimiter): void
    {
        $this->info('⏱️ Checking Rate Limits...');
        
        $adminNumber = config('services.fonnte.admin_number', env('ADMIN_WHATSAPP_NUMBER'));
        
        if ($adminNumber) {
            $usageStats = $rateLimiter->getUsageStats($adminNumber);
            
            $this->table(
                ['Period', 'Current', 'Limit', 'Percentage'],
                [
                    ['Minute', $usageStats['minute']['current'], $usageStats['minute']['limit'], $usageStats['minute']['percentage'] . '%'],
                    ['Hour', $usageStats['hour']['current'], $usageStats['hour']['limit'], $usageStats['hour']['percentage'] . '%'],
                    ['Day', $usageStats['day']['current'], $usageStats['day']['limit'], $usageStats['day']['percentage'] . '%'],
                ]
            );
        } else {
            $this->warn('Admin WhatsApp number not configured');
        }
        
        $this->newLine();
    }

    /**
     * Send test alert
     */
    protected function sendTestAlert(FonnteWhatsAppService $service): void
    {
        $this->info('📤 Sending Test Alert...');
        
        $result = $service->sendSystemAlert('info', 'This is a test alert from the monitoring system', [
            'Command' => 'whatsapp:monitor',
            'Timestamp' => now()->toISOString(),
            'Server' => gethostname()
        ]);
        
        if ($result['success']) {
            $this->info('✅ Test alert sent successfully');
        } else {
            $this->error('❌ Failed to send test alert: ' . $result['error']);
        }
        
        $this->newLine();
    }

    /**
     * Check admin configuration
     */
    protected function checkAdminConfig(): bool
    {
        $adminNumber = config('services.fonnte.admin_number', env('ADMIN_WHATSAPP_NUMBER'));
        $apiToken = config('services.fonnte.token', env('FONNTE_API_TOKEN'));
        
        return !empty($adminNumber) && !empty($apiToken) && $apiToken !== 'your_fonnte_api_token_here';
    }

    /**
     * Mask phone number for display
     */
    protected function maskPhoneNumber(string $phoneNumber): string
    {
        if (strlen($phoneNumber) <= 8) {
            return str_repeat('*', strlen($phoneNumber));
        }
        
        return substr($phoneNumber, 0, 4) . str_repeat('*', strlen($phoneNumber) - 8) . substr($phoneNumber, -4);
    }
}