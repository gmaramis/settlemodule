<?php

/**
 * Script untuk test email SMTP
 * Jalankan dengan: php test-email.php
 */

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

// Load Laravel environment
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🧪 Testing Email Configuration...\n\n";

// Test 1: Check mail configuration
echo "📧 Mail Configuration:\n";
echo "MAIL_MAILER: " . env('MAIL_MAILER', 'not set') . "\n";
echo "MAIL_HOST: " . env('MAIL_HOST', 'not set') . "\n";
echo "MAIL_PORT: " . env('MAIL_PORT', 'not set') . "\n";
echo "MAIL_USERNAME: " . env('MAIL_USERNAME', 'not set') . "\n";
echo "MAIL_ENCRYPTION: " . env('MAIL_ENCRYPTION', 'not set') . "\n";
echo "MAIL_FROM_ADDRESS: " . env('MAIL_FROM_ADDRESS', 'not set') . "\n";
echo "MAIL_FROM_NAME: " . env('MAIL_FROM_NAME', 'not set') . "\n\n";

// Test 2: Send test email
echo "📤 Sending test email...\n";

try {
    $toEmail = 'test@example.com'; // Ganti dengan email yang valid
    $subject = 'Test Email from Settle';
    $message = 'This is a test email to verify SMTP configuration.';
    
    Mail::raw($message, function ($mail) use ($toEmail, $subject) {
        $mail->to($toEmail)
             ->subject($subject);
    });
    
    echo "✅ Email sent successfully to: $toEmail\n";
    echo "📬 Check your email inbox (and spam folder)\n\n";
    
} catch (Exception $e) {
    echo "❌ Error sending email: " . $e->getMessage() . "\n\n";
}

// Test 3: Test password reset email
echo "🔐 Testing password reset email...\n";

try {
    $user = \App\Models\User::first();
    if ($user) {
        $token = \Illuminate\Support\Str::random(64);
        
        // Simulate password reset
        \Illuminate\Support\Facades\Password::sendResetLink(
            ['email' => $user->email]
        );
        
        echo "✅ Password reset email sent to: " . $user->email . "\n";
    } else {
        echo "⚠️  No users found in database. Create a user first.\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error sending password reset email: " . $e->getMessage() . "\n";
}

echo "\n🎯 Email configuration test completed!\n";
echo "💡 If you see errors, check your .env file configuration.\n";
