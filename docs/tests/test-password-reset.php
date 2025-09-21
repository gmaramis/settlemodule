<?php

/**
 * Script Test Password Reset Email
 * Jalankan: php test-password-reset.php
 */

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔐 Test Password Reset Email\n";
echo "============================\n\n";

// Get all users
$users = \App\Models\User::all(['email', 'name']);

echo "📋 Users yang tersedia:\n";
foreach ($users as $index => $user) {
    echo ($index + 1) . ". Email: {$user->email} | Name: {$user->name}\n";
}

echo "\nMasukkan email untuk test password reset:\n";
$testEmail = readline("Email: ");

if (empty($testEmail)) {
    echo "❌ Email tidak boleh kosong!\n";
    exit(1);
}

// Check if user exists
$user = \App\Models\User::where('email', $testEmail)->first();

if (!$user) {
    echo "❌ User dengan email '$testEmail' tidak ditemukan!\n";
    echo "💡 Gunakan salah satu email yang tersedia di atas.\n";
    exit(1);
}

echo "\n✅ User ditemukan: {$user->name} ({$user->email})\n";

// Test password reset
echo "\n📤 Mengirim email reset password...\n";

try {
    $status = \Illuminate\Support\Facades\Password::sendResetLink(['email' => $testEmail]);
    
    if ($status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT) {
        echo "✅ SUCCESS: Email reset password terkirim!\n";
        echo "📬 Cek inbox email: $testEmail\n";
        echo "📧 Email dikirim dari: Settle Medical <medicalsettle@gmail.com>\n";
        echo "📝 Subject: Reset Password Notification\n\n";
        
        echo "💡 Tips:\n";
        echo "- Cek folder spam/junk jika tidak ada di inbox\n";
        echo "- Link reset berlaku 60 menit\n";
        echo "- Klik link di email untuk reset password\n";
        
    } else {
        echo "❌ ERROR: Gagal mengirim email\n";
        echo "Status: $status\n";
    }
    
} catch (Exception $e) {
    echo "❌ EXCEPTION: " . $e->getMessage() . "\n";
}

echo "\n🧪 Test email langsung (opsional):\n";
$sendTest = readline("Kirim test email langsung? (y/n): ");

if (strtolower($sendTest) === 'y') {
    try {
        \Illuminate\Support\Facades\Mail::raw('Test email langsung dari Settle Medical System', function ($message) use ($testEmail) {
            $message->to($testEmail)
                   ->subject('Test Email dari Settle Medical');
        });
        
        echo "✅ Test email langsung terkirim!\n";
        
    } catch (Exception $e) {
        echo "❌ ERROR test email: " . $e->getMessage() . "\n";
    }
}

echo "\n🎯 Test selesai!\n";
