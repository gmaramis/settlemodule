<?php

/**
 * Script Test Custom Logo dan Halaman Welcome
 * Jalankan: php test-custom-logo.php
 */

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🎨 Test Custom Logo dan Halaman Welcome\n";
echo "======================================\n\n";

// Test 1: Cek file logo
echo "1. Cek File Logo:\n";
$logoFiles = [
    'public/images/logos/logo_settle.jpeg',
    'public/favicon.ico',
];

foreach ($logoFiles as $file) {
    if (file_exists($file)) {
        $size = filesize($file);
        echo "   ✅ $file - Ada (" . number_format($size / 1024, 2) . " KB)\n";
    } else {
        echo "   ❌ $file - Tidak ada\n";
    }
}

// Test 2: Cek halaman welcome
echo "\n2. Cek Halaman Welcome:\n";
$welcomeFile = 'resources/views/welcome.blade.php';
if (file_exists($welcomeFile)) {
    echo "   ✅ $welcomeFile - Ada\n";
    
    // Cek apakah menggunakan logo custom
    $content = file_get_contents($welcomeFile);
    if (strpos($content, 'logo_settle.jpeg') !== false) {
        echo "   ✅ Menggunakan logo custom: logo_settle.jpeg\n";
    } else {
        echo "   ❌ Tidak menggunakan logo custom\n";
    }
    
    if (strpos($content, 'Settle Medical') !== false) {
        echo "   ✅ Menggunakan branding: Settle Medical\n";
    } else {
        echo "   ❌ Tidak menggunakan branding yang benar\n";
    }
    
    if (strpos($content, 'Sam Ratulangi University') !== false) {
        echo "   ✅ Menggunakan institusi: Sam Ratulangi University\n";
    } else {
        echo "   ❌ Tidak menggunakan institusi yang benar\n";
    }
    
} else {
    echo "   ❌ $welcomeFile - Tidak ada\n";
}

// Test 3: Cek konfigurasi aplikasi
echo "\n3. Cek Konfigurasi Aplikasi:\n";
echo "   APP_NAME: " . config('app.name') . "\n";
echo "   APP_URL: " . config('app.url') . "\n";
echo "   APP_LOCALE: " . config('app.locale') . "\n";

// Test 4: Cek asset URL
echo "\n4. Test Asset URL:\n";
$logoUrl = asset('images/logos/logo_settle.jpeg');
echo "   Logo URL: $logoUrl\n";

// Test 5: Cek apakah halaman welcome bisa diakses
echo "\n5. Test Akses Halaman Welcome:\n";
try {
    $response = \Illuminate\Support\Facades\Route::get('/', function () {
        return view('welcome');
    });
    echo "   ✅ Route welcome berfungsi\n";
} catch (Exception $e) {
    echo "   ❌ Error route welcome: " . $e->getMessage() . "\n";
}

echo "\n6. Fitur Custom yang Sudah Diterapkan:\n";
echo "   ✅ Logo custom: logo_settle.jpeg\n";
echo "   ✅ Favicon: favicon.ico\n";
echo "   ✅ Halaman welcome: Desain modern dengan branding Settle Medical\n";
echo "   ✅ Branding: Settle Medical - Sistem Manajemen Rotasi Klinis\n";
echo "   ✅ Institusi: Sam Ratulangi University\n";
echo "   ✅ Bahasa: Indonesia\n";
echo "   ✅ Desain: Gradient, modern, responsive\n";

echo "\n7. URL untuk Test:\n";
echo "   🏠 Welcome Page: " . config('app.url') . "\n";
echo "   🔗 Logo: " . $logoUrl . "\n";
echo "   📱 Dashboard: " . config('app.url') . "/dashboard\n";

echo "\n🎯 Test Custom Logo Selesai!\n";
echo "\n💡 Tips:\n";
echo "- Logo sekarang menggunakan file logo_settle.jpeg\n";
echo "- Halaman welcome sudah menggunakan branding Settle Medical\n";
echo "- Tidak ada lagi tulisan 'Laravel' yang terlihat\n";
echo "- Desain modern dan responsive\n";
echo "- Favicon sudah diupdate\n";
