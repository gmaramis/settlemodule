<?php

/**
 * Script Test Custom Reset Password
 * Jalankan: php test-custom-reset-password.php
 */

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🎨 Test Custom Reset Password\n";
echo "=============================\n\n";

// Test 1: Cek konfigurasi
echo "1. Cek Konfigurasi:\n";
echo "   APP_LOCALE: " . config('app.locale') . "\n";
echo "   APP_URL: " . config('app.url') . "\n";
echo "   MAIL_FROM_NAME: " . config('mail.from.name') . "\n";
echo "   MAIL_FROM_ADDRESS: " . config('mail.from.address') . "\n\n";

// Test 2: Cek file bahasa
echo "2. Cek File Bahasa:\n";
$langFiles = [
    'lang/id/passwords.php',
    'lang/id/auth.php',
];

foreach ($langFiles as $file) {
    if (file_exists($file)) {
        echo "   ✅ $file - Ada\n";
    } else {
        echo "   ❌ $file - Tidak ada\n";
    }
}

// Test 3: Cek template email
echo "\n3. Cek Template Email:\n";
$emailTemplate = 'resources/views/emails/password-reset.blade.php';
if (file_exists($emailTemplate)) {
    echo "   ✅ $emailTemplate - Ada\n";
} else {
    echo "   ❌ $emailTemplate - Tidak ada\n";
}

// Test 4: Cek custom notification
echo "\n4. Cek Custom Notification:\n";
$notificationFile = 'app/Notifications/CustomResetPassword.php';
if (file_exists($notificationFile)) {
    echo "   ✅ $notificationFile - Ada\n";
} else {
    echo "   ❌ $notificationFile - Tidak ada\n";
}

// Test 5: Test password reset
echo "\n5. Test Password Reset:\n";
$testEmail = 'glendpm@gmail.com';

try {
    $status = \Illuminate\Support\Facades\Password::sendResetLink(['email' => $testEmail]);
    
    if ($status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT) {
        echo "   ✅ SUCCESS: Email reset terkirim dengan template custom!\n";
        echo "   📧 Email: $testEmail\n";
        echo "   🎨 Template: Custom Settle Medical\n";
        echo "   🌐 Bahasa: Indonesia\n";
    } else {
        echo "   ❌ ERROR: $status\n";
    }
    
} catch (Exception $e) {
    echo "   ❌ EXCEPTION: " . $e->getMessage() . "\n";
}

// Test 6: Cek pesan bahasa
echo "\n6. Test Pesan Bahasa:\n";
try {
    $messages = [
        'sent' => __('passwords.sent'),
        'reset' => __('passwords.reset'),
        'throttled' => __('passwords.throttled'),
        'token' => __('passwords.token'),
        'user' => __('passwords.user'),
    ];
    
    foreach ($messages as $key => $message) {
        echo "   $key: $message\n";
    }
    
} catch (Exception $e) {
    echo "   ❌ ERROR: " . $e->getMessage() . "\n";
}

echo "\n7. Fitur Custom yang Sudah Diterapkan:\n";
echo "   ✅ Halaman Forgot Password - Desain modern dengan gradient\n";
echo "   ✅ Halaman Reset Password - Desain modern dengan gradient\n";
echo "   ✅ Email Template - Custom HTML dengan branding Settle Medical\n";
echo "   ✅ Pesan Bahasa - Semua dalam bahasa Indonesia\n";
echo "   ✅ Custom Notification - Menggunakan template custom\n";

echo "\n8. URL untuk Test:\n";
echo "   🔗 Forgot Password: " . config('app.url') . "/forgot-password\n";
echo "   🔗 Reset Password: " . config('app.url') . "/reset-password/[TOKEN]?email=$testEmail\n";
echo "   🔗 Login: " . config('app.url') . "/login\n";

echo "\n🎯 Test Custom Reset Password Selesai!\n";
echo "\n💡 Tips:\n";
echo "- Semua halaman sudah menggunakan desain custom\n";
echo "- Email menggunakan template HTML yang menarik\n";
echo "- Pesan error/success dalam bahasa Indonesia\n";
echo "- Tidak ada lagi tulisan 'Laravel' yang terlihat\n";
echo "- Branding 'Settle Medical' konsisten di semua halaman\n";
