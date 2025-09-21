<?php

/**
 * Script Reset Password User
 * Jalankan: php reset-user-password.php
 */

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔐 Reset Password User\n";
echo "=====================\n\n";

// Get all users
$users = \App\Models\User::all(['email', 'name']);

echo "📋 Users yang tersedia:\n";
foreach ($users as $index => $user) {
    echo ($index + 1) . ". Email: {$user->email} | Name: {$user->name}\n";
}

echo "\nMasukkan email untuk reset password:\n";
$email = readline("Email: ");

if (empty($email)) {
    echo "❌ Email tidak boleh kosong!\n";
    exit(1);
}

// Check if user exists
$user = \App\Models\User::where('email', $email)->first();

if (!$user) {
    echo "❌ User dengan email '$email' tidak ditemukan!\n";
    echo "💡 Gunakan salah satu email yang tersedia di atas.\n";
    exit(1);
}

echo "\n✅ User ditemukan: {$user->name} ({$user->email})\n";

// Get new password
echo "\nMasukkan password baru:\n";
$newPassword = readline("Password baru: ");

if (empty($newPassword)) {
    echo "❌ Password tidak boleh kosong!\n";
    exit(1);
}

if (strlen($newPassword) < 8) {
    echo "❌ Password minimal 8 karakter!\n";
    exit(1);
}

// Confirm password
$confirmPassword = readline("Konfirmasi password: ");

if ($newPassword !== $confirmPassword) {
    echo "❌ Password tidak sama!\n";
    exit(1);
}

// Reset password
try {
    $user->password = \Illuminate\Support\Facades\Hash::make($newPassword);
    $user->save();
    
    echo "\n✅ SUCCESS: Password berhasil direset!\n";
    echo "📧 Email: {$user->email}\n";
    echo "🔐 Password baru: $newPassword\n";
    echo "👤 User: {$user->name}\n";
    echo "📅 Reset pada: " . now() . "\n\n";
    
    echo "💡 Sekarang Anda bisa login dengan:\n";
    echo "   Email: {$user->email}\n";
    echo "   Password: $newPassword\n\n";
    
    echo "🔗 Login di: http://127.0.0.1:8000/login\n";
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}

echo "\n🎯 Reset password selesai!\n";


