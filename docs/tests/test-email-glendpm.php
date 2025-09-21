<?php

/**
 * Script Test Email untuk glendpm@gmail.com
 * Jalankan: php test-email-glendpm.php
 */

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "📧 Test Email untuk glendpm@gmail.com\n";
echo "=====================================\n\n";

$testEmail = 'glendpm@gmail.com';

// Test 1: Email langsung
echo "1. Test Email Langsung:\n";
echo "   Mengirim test email ke: $testEmail\n";

try {
    \Illuminate\Support\Facades\Mail::raw('Test email langsung dari Settle Medical System', function ($message) use ($testEmail) {
        $message->to($testEmail)
               ->subject('Test Email Langsung dari Settle Medical');
    });
    
    echo "   ✅ SUCCESS: Email langsung terkirim!\n";
    
} catch (Exception $e) {
    echo "   ❌ ERROR: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 2: Password Reset
echo "2. Test Password Reset:\n";
echo "   Mengirim password reset ke: $testEmail\n";

try {
    $status = \Illuminate\Support\Facades\Password::sendResetLink(['email' => $testEmail]);
    
    if ($status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT) {
        echo "   ✅ SUCCESS: Email password reset terkirim!\n";
    } else {
        echo "   ❌ ERROR: Status - $status\n";
    }
    
} catch (Exception $e) {
    echo "   ❌ ERROR: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 3: Email dengan HTML
echo "3. Test Email dengan HTML:\n";
echo "   Mengirim email HTML ke: $testEmail\n";

try {
    \Illuminate\Support\Facades\Mail::send([], [], function ($message) use ($testEmail) {
        $message->to($testEmail)
               ->subject('Test Email HTML dari Settle Medical')
               ->html('<h1>Test Email HTML</h1><p>Ini adalah test email HTML dari Settle Medical System.</p><p>Jika Anda menerima email ini, berarti konfigurasi email berfungsi dengan baik.</p>');
    });
    
    echo "   ✅ SUCCESS: Email HTML terkirim!\n";
    
} catch (Exception $e) {
    echo "   ❌ ERROR: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 4: Cek user
echo "4. Cek User di Database:\n";
$user = \App\Models\User::where('email', $testEmail)->first();

if ($user) {
    echo "   ✅ User ditemukan: {$user->name}\n";
    echo "   📧 Email: {$user->email}\n";
    echo "   👤 Role: {$user->role}\n";
    echo "   📅 Created: {$user->created_at}\n";
} else {
    echo "   ❌ User tidak ditemukan!\n";
}

echo "\n";

// Test 5: Cek konfigurasi
echo "5. Cek Konfigurasi Email:\n";
echo "   MAIL_MAILER: " . config('mail.default') . "\n";
echo "   MAIL_HOST: " . config('mail.mailers.smtp.host') . "\n";
echo "   MAIL_PORT: " . config('mail.mailers.smtp.port') . "\n";
echo "   MAIL_USERNAME: " . config('mail.mailers.smtp.username') . "\n";
echo "   MAIL_FROM_ADDRESS: " . config('mail.from.address') . "\n";
echo "   MAIL_FROM_NAME: " . config('mail.from.name') . "\n";

echo "\n";

// Test 6: Cek log
echo "6. Cek Log Terbaru:\n";
$logFile = storage_path('logs/laravel.log');
if (file_exists($logFile)) {
    $logs = tail($logFile, 10);
    echo "   Log terbaru:\n";
    foreach ($logs as $log) {
        if (strpos($log, 'glendpm') !== false || strpos($log, 'medicalsettle') !== false || strpos($log, 'reset') !== false) {
            echo "   📝 " . $log . "\n";
        }
    }
} else {
    echo "   ❌ Log file tidak ditemukan\n";
}

echo "\n🎯 Test selesai!\n";
echo "\n💡 Tips:\n";
echo "- Cek inbox email: $testEmail\n";
echo "- Cek folder spam/junk\n";
echo "- Cek All Mail di Gmail\n";
echo "- Email dikirim dari: medicalsettle@gmail.com\n";

function tail($filename, $lines = 10) {
    $file = file($filename);
    return array_slice($file, -$lines);
}
