<?php

/**
 * Script Setup Email medicalsettle@gmail.com
 * Jalankan: php setup-medicalsettle-email.php
 */

echo "📧 Setup Email medicalsettle@gmail.com\n";
echo "=====================================\n\n";

echo "Email yang sudah dibuat: medicalsettle@gmail.com\n\n";

echo "Pilih metode setup:\n";
echo "1. Gmail dengan 2FA + App Password (Recommended)\n";
echo "2. Yahoo Mail tanpa 2FA (Cepat)\n";
echo "3. Outlook tanpa 2FA (Cepat)\n\n";

$choice = readline("Pilih (1/2/3): ");

switch ($choice) {
    case '1':
        setupGmailWith2FA();
        break;
    case '2':
        setupYahooMail();
        break;
    case '3':
        setupOutlook();
        break;
    default:
        echo "❌ Pilihan tidak valid!\n";
        exit(1);
}

function setupGmailWith2FA() {
    echo "\n🔐 Setup Gmail dengan 2FA\n";
    echo "========================\n\n";
    
    echo "Langkah-langkah:\n";
    echo "1. Buka: https://myaccount.google.com/security\n";
    echo "2. Aktifkan: 2-Step Verification\n";
    echo "3. Generate: App Password untuk 'Mail'\n";
    echo "4. Copy: 16-character App Password\n\n";
    
    $appPassword = readline("Masukkan App Password (16 karakter): ");
    
    if (strlen(str_replace(' ', '', $appPassword)) !== 16) {
        echo "❌ App Password harus 16 karakter!\n";
        exit(1);
    }
    
    updateEnvConfig('smtp.gmail.com', 587, 'medicalsettle@gmail.com', $appPassword, 'tls');
    
    echo "\n✅ Setup Gmail dengan 2FA selesai!\n";
    echo "📧 Email akan dikirim dari: medicalsettle@gmail.com\n";
}

function setupYahooMail() {
    echo "\n📧 Setup Yahoo Mail (Tanpa 2FA)\n";
    echo "==============================\n\n";
    
    echo "Langkah-langkah:\n";
    echo "1. Buka: https://mail.yahoo.com\n";
    echo "2. Buat akun: medicalsettle@yahoo.com\n";
    echo "3. Gunakan password biasa (tidak perlu 2FA)\n\n";
    
    $password = readline("Masukkan password Yahoo Mail: ");
    
    if (empty($password)) {
        echo "❌ Password tidak boleh kosong!\n";
        exit(1);
    }
    
    updateEnvConfig('smtp.mail.yahoo.com', 587, 'medicalsettle@yahoo.com', $password, 'tls');
    
    echo "\n✅ Setup Yahoo Mail selesai!\n";
    echo "📧 Email akan dikirim dari: medicalsettle@yahoo.com\n";
}

function setupOutlook() {
    echo "\n📧 Setup Outlook (Tanpa 2FA)\n";
    echo "===========================\n\n";
    
    echo "Langkah-langkah:\n";
    echo "1. Buka: https://outlook.com\n";
    echo "2. Buat akun: medicalsettle@outlook.com\n";
    echo "3. Gunakan password biasa (tidak perlu 2FA)\n\n";
    
    $password = readline("Masukkan password Outlook: ");
    
    if (empty($password)) {
        echo "❌ Password tidak boleh kosong!\n";
        exit(1);
    }
    
    updateEnvConfig('smtp-mail.outlook.com', 587, 'medicalsettle@outlook.com', $password, 'tls');
    
    echo "\n✅ Setup Outlook selesai!\n";
    echo "📧 Email akan dikirim dari: medicalsettle@outlook.com\n";
}

function updateEnvConfig($host, $port, $username, $password, $encryption) {
    $envFile = '.env';
    $backupFile = '.env.backup.' . date('Y-m-d-H-i-s');
    
    // Backup .env
    if (file_exists($envFile)) {
        copy($envFile, $backupFile);
        echo "✅ Backup .env dibuat: $backupFile\n";
    }
    
    // Update .env
    $envContent = file_get_contents($envFile);
    
    $configs = [
        'MAIL_MAILER' => 'smtp',
        'MAIL_HOST' => $host,
        'MAIL_PORT' => $port,
        'MAIL_USERNAME' => $username,
        'MAIL_PASSWORD' => $password,
        'MAIL_ENCRYPTION' => $encryption,
        'MAIL_FROM_ADDRESS' => "\"$username\"",
        'MAIL_FROM_NAME' => '"Settle Medical"'
    ];
    
    foreach ($configs as $key => $value) {
        $pattern = '/^' . preg_quote($key, '/') . '=.*$/m';
        $replacement = "$key=$value";
        
        if (preg_match($pattern, $envContent)) {
            $envContent = preg_replace($pattern, $replacement, $envContent);
        } else {
            $envContent .= "\n$key=$value";
        }
    }
    
    file_put_contents($envFile, $envContent);
    
    echo "\n📋 Konfigurasi yang di-update:\n";
    foreach ($configs as $key => $value) {
        echo "$key=$value\n";
    }
    
    echo "\n🔄 Langkah selanjutnya:\n";
    echo "1. Clear cache Laravel:\n";
    echo "   php artisan config:clear\n";
    echo "   php artisan cache:clear\n\n";
    
    echo "2. Test email:\n";
    echo "   php test-email-simple.php\n\n";
    
    echo "3. Test password reset:\n";
    echo "   Buka http://127.0.0.1:8000/login\n";
    echo "   Klik 'Forgot your password?'\n";
    echo "   Masukkan email yang valid\n\n";
}

echo "\n🎯 Setup selesai! Email akan dikirim dari: $username\n";

