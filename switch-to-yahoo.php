<?php

/**
 * Script untuk Switch ke Yahoo Mail
 * Jalankan: php switch-to-yahoo.php
 */

echo "📧 Switch ke Yahoo Mail untuk medicalsettle\n";
echo "==========================================\n\n";

echo "Konfigurasi akan diupdate ke:\n";
echo "MAIL_HOST: smtp.mail.yahoo.com\n";
echo "MAIL_USERNAME: medicalsettle@yahoo.com\n";
echo "MAIL_PASSWORD: c3Nt!a060707\n\n";

$confirm = readline("Lanjutkan? (y/n): ");

if (strtolower($confirm) !== 'y') {
    echo "❌ Setup dibatalkan.\n";
    exit(0);
}

// Backup .env
$envFile = '.env';
$backupFile = '.env.backup.yahoo.' . date('Y-m-d-H-i-s');

if (file_exists($envFile)) {
    copy($envFile, $backupFile);
    echo "✅ Backup .env dibuat: $backupFile\n";
}

// Update .env
$envContent = file_get_contents($envFile);

$updates = [
    'MAIL_HOST=smtp.mail.yahoo.com',
    'MAIL_USERNAME=medicalsettle@yahoo.com',
    'MAIL_PASSWORD=c3Nt!a060707',
    'MAIL_FROM_ADDRESS="medicalsettle@yahoo.com"'
];

foreach ($updates as $update) {
    $key = explode('=', $update)[0];
    $pattern = '/^' . preg_quote($key, '/') . '=.*$/m';
    
    if (preg_match($pattern, $envContent)) {
        $envContent = preg_replace($pattern, $update, $envContent);
    } else {
        $envContent .= "\n$update";
    }
}

file_put_contents($envFile, $envContent);

echo "\n✅ Konfigurasi berhasil di-update ke Yahoo Mail!\n\n";

echo "📋 Konfigurasi yang di-update:\n";
foreach ($updates as $update) {
    echo "$update\n";
}

echo "\n🔄 Langkah selanjutnya:\n";
echo "1. Buat email Yahoo: medicalsettle@yahoo.com\n";
echo "2. Clear cache Laravel:\n";
echo "   php artisan config:clear\n";
echo "   php artisan cache:clear\n\n";
echo "3. Test email:\n";
echo "   php test-email-simple.php\n\n";

echo "🎯 Setup selesai! Email akan dikirim dari: medicalsettle@yahoo.com\n";


