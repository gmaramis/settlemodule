<?php

/**
 * Script untuk Update Konfigurasi Email Gmail Settle
 * Jalankan: php update-email-config.php
 */

echo "📧 Update Konfigurasi Email Gmail Settle\n";
echo "========================================\n\n";

// Input dari user
echo "Masukkan email Gmail Settle yang sudah dibuat:\n";
echo "Contoh: settle.medical@gmail.com\n";
$email = readline("Email: ");

echo "\nMasukkan App Password (16 karakter):\n";
echo "Contoh: abcd efgh ijkl mnop\n";
$password = readline("App Password: ");

// Validasi input
if (empty($email) || empty($password)) {
    echo "❌ Email dan App Password tidak boleh kosong!\n";
    exit(1);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "❌ Format email tidak valid!\n";
    exit(1);
}

// Backup .env file
$envFile = '.env';
$backupFile = '.env.backup.' . date('Y-m-d-H-i-s');

if (file_exists($envFile)) {
    copy($envFile, $backupFile);
    echo "✅ Backup .env dibuat: $backupFile\n";
}

// Update .env file
$envContent = file_get_contents($envFile);

// Replace mail configuration
$newConfig = [
    'MAIL_MAILER=smtp',
    'MAIL_SCHEME=null',
    'MAIL_HOST=smtp.gmail.com',
    'MAIL_PORT=587',
    'MAIL_USERNAME=' . $email,
    'MAIL_PASSWORD=' . $password,
    'MAIL_ENCRYPTION=tls',
    'MAIL_FROM_ADDRESS="' . $email . '"',
    'MAIL_FROM_NAME="Settle Medical"'
];

// Update each line
foreach ($newConfig as $config) {
    $key = explode('=', $config)[0];
    $pattern = '/^' . preg_quote($key, '/') . '=.*$/m';
    $replacement = $config;
    
    if (preg_match($pattern, $envContent)) {
        $envContent = preg_replace($pattern, $replacement, $envContent);
    } else {
        $envContent .= "\n" . $config;
    }
}

// Write updated content
file_put_contents($envFile, $envContent);

echo "✅ Konfigurasi email berhasil di-update!\n\n";

// Show updated configuration
echo "📋 Konfigurasi yang di-update:\n";
echo "MAIL_MAILER=smtp\n";
echo "MAIL_HOST=smtp.gmail.com\n";
echo "MAIL_PORT=587\n";
echo "MAIL_USERNAME=$email\n";
echo "MAIL_PASSWORD=$password\n";
echo "MAIL_ENCRYPTION=tls\n";
echo "MAIL_FROM_ADDRESS=\"$email\"\n";
echo "MAIL_FROM_NAME=\"Settle Medical\"\n\n";

echo "🔄 Langkah selanjutnya:\n";
echo "1. Clear cache Laravel:\n";
echo "   php artisan config:clear\n";
echo "   php artisan cache:clear\n\n";

echo "2. Test email:\n";
echo "   php test-email-simple.php\n\n";

echo "3. Test password reset:\n";
echo "   Buka http://127.0.0.1:8000/login\n";
echo "   Klik 'Forgot your password?'\n";
echo "   Masukkan email yang valid\n\n";

echo "🎯 Setup selesai! Email akan dikirim dari: $email\n";

