<?php

namespace App\Console\Commands;

use App\Services\FonnteWhatsAppService;
use App\Models\Admin;
use Illuminate\Console\Command;

class TestWhatsAppNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:test {--admin-number=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test WhatsApp notification using Fonnte API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing WhatsApp notification...');

        // Get admin number from option or environment
        $adminNumber = $this->option('admin-number') ?: env('ADMIN_WHATSAPP_NUMBER');

        if (!$adminNumber) {
            $this->error('Admin WhatsApp number not configured. Please set ADMIN_WHATSAPP_NUMBER in .env or use --admin-number option.');
            return 1;
        }

        $this->info("Testing with admin number: {$adminNumber}");

        // Check if API token is configured
        $apiToken = env('FONNTE_API_TOKEN');
        if (!$apiToken || $apiToken === 'your_fonnte_api_token_here') {
            $this->error('Fonnte API token not configured. Please set FONNTE_API_TOKEN in .env file.');
            return 1;
        }

        $this->info("API Token: " . substr($apiToken, 0, 10) . "...");

        try {
            $whatsappService = new FonnteWhatsAppService();
            
            // Test connection
            $result = $whatsappService->testConnection();

            if ($result['success']) {
                $this->info('✅ WhatsApp notification test successful!');
                $this->info('Response: ' . json_encode($result['data'], JSON_PRETTY_PRINT));
            } else {
                $this->error('❌ WhatsApp notification test failed!');
                $this->error('Error: ' . $result['error']);
                return 1;
            }

        } catch (\Exception $e) {
            $this->error('❌ Exception occurred: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}