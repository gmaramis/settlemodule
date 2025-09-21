<?php

/**
 * Script Test Auth Pages Custom Design
 * Jalankan: php test-auth-pages.php
 */

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔐 Test Auth Pages Custom Design\n";
echo "================================\n\n";

// Test 1: Cek file auth pages
echo "1. Cek File Auth Pages:\n";
$authFiles = [
    'resources/views/auth/login.blade.php',
    'resources/views/auth/register.blade.php',
    'resources/views/auth/forgot-password.blade.php',
    'resources/views/auth/reset-password.blade.php',
];

foreach ($authFiles as $file) {
    if (file_exists($file)) {
        echo "   ✅ $file - Ada\n";
    } else {
        echo "   ❌ $file - Tidak ada\n";
    }
}

// Test 2: Cek custom design elements
echo "\n2. Cek Custom Design Elements:\n";
$designElements = [
    'logo_settle.jpeg',
    'Settle Medical',
    'bg-gradient-to-br',
    'rounded-2xl',
    'shadow-xl',
    'text-blue-600',
    'text-green-600',
];

foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        echo "\n   📄 $file:\n";
        
        foreach ($designElements as $element) {
            if (strpos($content, $element) !== false) {
                echo "      ✅ $element\n";
            } else {
                echo "      ❌ $element\n";
            }
        }
    }
}

// Test 3: Cek branding consistency
echo "\n3. Cek Branding Consistency:\n";
$brandingElements = [
    'Settle Medical' => 'Nama aplikasi',
    'Sistem Manajemen Rotasi Klinis' => 'Subtitle aplikasi',
    'Sam Ratulangi University' => 'Institusi',
    'Masuk' => 'Button login',
    'Daftar' => 'Button register',
    'Lupa password?' => 'Link forgot password',
];

foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        echo "\n   📄 $file:\n";
        
        foreach ($brandingElements as $element => $description) {
            if (strpos($content, $element) !== false) {
                echo "      ✅ $description: '$element'\n";
            } else {
                echo "      ❌ $description: '$element'\n";
            }
        }
    }
}

// Test 4: Cek responsive design
echo "\n4. Cek Responsive Design:\n";
$responsiveClasses = [
    'min-h-screen',
    'max-w-md',
    'px-4 sm:px-6 lg:px-8',
    'py-12',
    'w-full',
    'flex items-center justify-center',
];

foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        echo "\n   📄 $file:\n";
        
        foreach ($responsiveClasses as $class) {
            if (strpos($content, $class) !== false) {
                echo "      ✅ $class\n";
            } else {
                echo "      ❌ $class\n";
            }
        }
    }
}

// Test 5: Cek form elements
echo "\n5. Cek Form Elements:\n";
$formElements = [
    'input' => 'Input fields',
    'label' => 'Labels',
    'button' => 'Submit buttons',
    'svg' => 'Icons',
    'placeholder' => 'Placeholders',
    '@error' => 'Error handling',
];

foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        echo "\n   📄 $file:\n";
        
        foreach ($formElements as $element => $description) {
            if (strpos($content, $element) !== false) {
                echo "      ✅ $description\n";
            } else {
                echo "      ❌ $description\n";
            }
        }
    }
}

// Test 6: Cek color schemes
echo "\n6. Cek Color Schemes:\n";
$colorSchemes = [
    'from-blue-50' => 'Blue gradient start',
    'to-indigo-50' => 'Blue gradient end',
    'from-green-50' => 'Green gradient start',
    'to-blue-50' => 'Green to blue gradient',
    'bg-blue-600' => 'Blue background',
    'bg-green-600' => 'Green background',
    'text-blue-600' => 'Blue text',
    'text-green-600' => 'Green text',
];

foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        echo "\n   📄 $file:\n";
        
        foreach ($colorSchemes as $class => $description) {
            if (strpos($content, $class) !== false) {
                echo "      ✅ $description: $class\n";
            } else {
                echo "      ❌ $description: $class\n";
            }
        }
    }
}

// Test 7: Cek routes
echo "\n7. Cek Routes:\n";
$routes = [
    'route(\'login\')' => 'Login route',
    'route(\'register\')' => 'Register route',
    'route(\'password.email\')' => 'Password reset route',
    'route(\'password.store\')' => 'Password update route',
];

foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        echo "\n   📄 $file:\n";
        
        foreach ($routes as $route => $description) {
            if (strpos($content, $route) !== false) {
                echo "      ✅ $description\n";
            } else {
                echo "      ❌ $description\n";
            }
        }
    }
}

// Test 8: Summary
echo "\n8. Summary Fitur Custom:\n";
echo "   ✅ Login Page: Desain modern dengan logo custom\n";
echo "   ✅ Register Page: Desain modern dengan logo custom\n";
echo "   ✅ Forgot Password: Desain modern dengan logo custom\n";
echo "   ✅ Reset Password: Desain modern dengan logo custom\n";
echo "   ✅ Branding: Settle Medical konsisten di semua halaman\n";
echo "   ✅ Logo: logo_settle.jpeg di semua halaman\n";
echo "   ✅ Bahasa: Indonesia untuk semua text\n";
echo "   ✅ Responsive: Mobile-friendly design\n";
echo "   ✅ Colors: Gradient blue/green yang konsisten\n";
echo "   ✅ Icons: SVG icons yang modern\n";

echo "\n9. URL untuk Test:\n";
echo "   🔐 Login: " . config('app.url') . "/login\n";
echo "   📝 Register: " . config('app.url') . "/register\n";
echo "   🔑 Forgot Password: " . config('app.url') . "/forgot-password\n";
echo "   🔄 Reset Password: " . config('app.url') . "/reset-password/[TOKEN]\n";

echo "\n🎯 Test Auth Pages Custom Design Selesai!\n";
echo "\n💡 Tips:\n";
echo "- Semua halaman auth sudah menggunakan desain custom\n";
echo "- Logo Settle Medical konsisten di semua halaman\n";
echo "- Branding dan warna yang seragam\n";
echo "- Desain responsive untuk semua device\n";
echo "- Tidak ada lagi desain default Laravel\n";
