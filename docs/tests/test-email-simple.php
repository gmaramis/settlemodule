<?php

/**
 * Script Test Email Sederhana
 * Jalankan: php test-email-simple.php
 */

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🧪 Testing Email Configuration\n";
echo "================================\n\n";

// Check current configuration
echo "📧 Current Mail Configuration:\n";
echo "MAIL_MAILER: " . env('MAIL_MAILER', 'not set') . "\n";
echo "MAIL_HOST: " . env('MAIL_HOST', 'not set') . "\n";
echo "MAIL_PORT: " . env('MAIL_PORT', 'not set') . "\n";
echo "MAIL_USERNAME: " . env('MAIL_USERNAME', 'not set') . "\n";
echo "MAIL_FROM_ADDRESS: " . env('MAIL_FROM_ADDRESS', 'not set') . "\n\n";

// Test email
echo "📤 Sending test email...\n";

try {
    $toEmail = 'test@example.com'; // Ganti dengan email Anda
    $subject = 'Test Email from Settle';
    $message = 'This is a test email to verify SMTP configuration.';
    
    \Illuminate\Support\Facades\Mail::raw($message, function ($mail) use ($toEmail, $subject) {
        $mail->to($toEmail)
             ->subject($subject);
    });
    
    echo "✅ Email sent successfully!\n";
    
    if (env('MAIL_MAILER') === 'log') {
        echo "📝 Note: Using LOG driver - email saved to storage/logs/laravel.log\n";
        echo "💡 To send real emails, configure SMTP in .env file\n";
    } else {
        echo "📬 Check your email inbox (and spam folder)\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n🎯 Test completed!\n";
