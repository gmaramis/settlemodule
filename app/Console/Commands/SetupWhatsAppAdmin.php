<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;

class SetupWhatsAppAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:setup-admin {--name=} {--email=} {--phone=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup WhatsApp admin for notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Setting up WhatsApp admin...');

        $name = $this->option('name') ?: $this->ask('Admin name', 'Admin Settle Medical');
        $email = $this->option('email') ?: $this->ask('Admin email', 'admin@settlemedical.com');
        $phone = $this->option('phone') ?: $this->ask('Admin WhatsApp number (format: 6281234567890)');

        // Validate phone number format
        if (!$this->validatePhoneNumber($phone)) {
            $this->error('Invalid phone number format. Please use format: 6281234567890');
            return 1;
        }

        try {
            // Check if admin already exists
            $existingAdmin = Admin::where('whatsapp_number', $phone)->first();
            
            if ($existingAdmin) {
                $this->info('Admin with this WhatsApp number already exists. Updating...');
                $existingAdmin->update([
                    'name' => $name,
                    'email' => $email,
                    'is_active' => true,
                ]);
                $admin = $existingAdmin;
            } else {
                $admin = Admin::create([
                    'name' => $name,
                    'email' => $email,
                    'whatsapp_number' => $phone,
                    'is_active' => true,
                ]);
            }

            $this->info('✅ WhatsApp admin setup successful!');
            $this->table(
                ['Field', 'Value'],
                [
                    ['ID', $admin->id],
                    ['Name', $admin->name],
                    ['Email', $admin->email],
                    ['WhatsApp Number', $admin->whatsapp_number],
                    ['Active', $admin->is_active ? 'Yes' : 'No'],
                ]
            );

            // Update .env file
            $this->updateEnvFile($phone);

        } catch (\Exception $e) {
            $this->error('❌ Failed to setup WhatsApp admin: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }

    /**
     * Validate phone number format
     */
    private function validatePhoneNumber($phone)
    {
        // Indonesian phone number format: 6281234567890
        return preg_match('/^62\d{9,13}$/', $phone);
    }

    /**
     * Update .env file with admin phone number
     */
    private function updateEnvFile($phone)
    {
        $envFile = base_path('.env');
        
        if (file_exists($envFile)) {
            $envContent = file_get_contents($envFile);
            
            // Update or add ADMIN_WHATSAPP_NUMBER
            if (strpos($envContent, 'ADMIN_WHATSAPP_NUMBER=') !== false) {
                $envContent = preg_replace(
                    '/ADMIN_WHATSAPP_NUMBER=.*/',
                    "ADMIN_WHATSAPP_NUMBER={$phone}",
                    $envContent
                );
            } else {
                $envContent .= "\nADMIN_WHATSAPP_NUMBER={$phone}\n";
            }
            
            file_put_contents($envFile, $envContent);
            $this->info('✅ Updated .env file with admin WhatsApp number');
        }
    }
}