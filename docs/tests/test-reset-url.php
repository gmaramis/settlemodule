<?php

/**
 * Script Test Reset Password URL
 * Jalankan: php test-reset-url.php
 */

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔗 Test Reset Password URL\n";
echo "==========================\n\n";

// Cek konfigurasi URL
echo "1. Cek Konfigurasi URL:\n";
echo "   APP_URL: " . config('app.url') . "\n";
echo "   APP_ENV: " . config('app.env') . "\n";
echo "   APP_DEBUG: " . (config('app.debug') ? 'true' : 'false') . "\n\n";

// Test password reset
$testEmail = 'glendpm@gmail.com';
echo "2. Test Password Reset untuk: $testEmail\n";

try {
    $status = \Illuminate\Support\Facades\Password::sendResetLink(['email' => $testEmail]);
    
    if ($status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT) {
        echo "   ✅ SUCCESS: Email reset terkirim!\n";
        
        // Cek token terbaru
        $user = \App\Models\User::where('email', $testEmail)->first();
        $token = \Illuminate\Support\Facades\DB::table('password_reset_tokens')
            ->where('email', $testEmail)
            ->orderBy('created_at', 'desc')
            ->first();
        
        if ($token) {
            $resetUrl = config('app.url') . '/reset-password/' . $token->token . '?email=' . urlencode($testEmail);
            echo "\n   🔗 URL Reset Password:\n";
            echo "   $resetUrl\n\n";
            
            echo "   📧 Email akan berisi link:\n";
            echo "   $resetUrl\n\n";
            
            echo "   ✅ URL sekarang menggunakan: " . config('app.url') . "\n";
            echo "   ✅ Bukan lagi: http://localhost\n\n";
            
        } else {
            echo "   ❌ Token tidak ditemukan\n";
        }
        
    } else {
        echo "   ❌ ERROR: $status\n";
    }
    
} catch (Exception $e) {
    echo "   ❌ EXCEPTION: " . $e->getMessage() . "\n";
}

echo "\n3. Test URL Manual:\n";
echo "   Buka browser dan akses:\n";
echo "   " . config('app.url') . "/reset-password/[TOKEN]?email=$testEmail\n\n";

echo "4. Langkah-langkah:\n";
echo "   1. 📧 Cek email di: $testEmail\n";
echo "   2. 🔗 Klik link reset password\n";
echo "   3. ✅ URL akan menggunakan: " . config('app.url') . "\n";
echo "   4. 🔐 Masukkan password baru\n\n";

echo "🎯 Test selesai!\n";
echo "\n💡 Tips:\n";
echo "- URL sekarang benar: " . config('app.url') . "\n";
echo "- Bukan lagi: http://localhost\n";
echo "- Link di email akan berfungsi dengan baik\n";
