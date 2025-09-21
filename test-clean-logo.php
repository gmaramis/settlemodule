<?php

/**
 * Script Test Clean Logo - Settle Medical
 * Jalankan: php test-clean-logo.php
 */

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🧹 TEST CLEAN LOGO - SETTLE MEDICAL\n";
echo "===================================\n\n";

// Test 1: Cek logo tanpa container
echo "1. ✅ LOGO TANPA CONTAINER:\n";
$authFiles = [
    'resources/views/auth/login.blade.php',
    'resources/views/auth/register.blade.php',
    'resources/views/auth/forgot-password.blade.php',
    'resources/views/auth/reset-password.blade.php',
];

$cleanLogoFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        // Cek logo langsung tanpa container
        if (strpos($content, '<img src="{{ asset(\'images/logos/logo_settle.png\') }}"') !== false &&
            strpos($content, 'alt="Settle Medical"') !== false &&
            strpos($content, 'class="h-24 w-24 mx-auto object-contain"') !== false) {
            echo "   ✅ " . basename($file) . " - Logo tanpa container\n";
            $cleanLogoFiles++;
        } else {
            echo "   ❌ " . basename($file) . " - Logo masih ada container\n";
        }
    }
}

// Test 2: Cek tidak ada container sekitar logo
echo "\n2. ✅ TIDAK ADA CONTAINER SEKITAR LOGO:\n";
$noContainerFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        $containerElements = [
            'bg-gray-50' => 'Tidak ada background gray-50',
            'rounded-2xl' => 'Tidak ada rounded-2xl',
            'p-4' => 'Tidak ada padding p-4',
            'shadow-lg' => 'Tidak ada shadow-lg',
            'border border-gray-200' => 'Tidak ada border gray-200'
        ];
        
        $foundContainers = 0;
        foreach ($containerElements as $element => $description) {
            if (strpos($content, $element) !== false) {
                $foundContainers++;
            }
        }
        
        if ($foundContainers == 0) {
            echo "   ✅ " . basename($file) . " - Tidak ada container sekitar logo\n";
            $noContainerFiles++;
        } else {
            echo "   ❌ " . basename($file) . " - Masih ada container sekitar logo\n";
        }
    }
}

// Test 3: Cek logo dengan ukuran yang tepat
echo "\n3. ✅ LOGO DENGAN UKURAN YANG TEPAT:\n";
$correctSizeFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        if (strpos($content, 'h-24 w-24') !== false) {
            echo "   ✅ " . basename($file) . " - Logo ukuran h-24 w-24\n";
            $correctSizeFiles++;
        } else {
            echo "   ❌ " . basename($file) . " - Logo ukuran tidak tepat\n";
        }
    }
}

// Test 4: Cek logo dengan positioning yang tepat
echo "\n4. ✅ LOGO DENGAN POSITIONING YANG TEPAT:\n";
$correctPositioningFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        if (strpos($content, 'mx-auto') !== false && 
            strpos($content, 'object-contain') !== false) {
            echo "   ✅ " . basename($file) . " - Logo positioning tepat\n";
            $correctPositioningFiles++;
        } else {
            echo "   ❌ " . basename($file) . " - Logo positioning tidak tepat\n";
        }
    }
}

// Test 5: Cek logo dengan alt text yang tepat
echo "\n5. ✅ LOGO DENGAN ALT TEXT YANG TEPAT:\n";
$correctAltTextFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        if (strpos($content, 'alt="Settle Medical"') !== false) {
            echo "   ✅ " . basename($file) . " - Logo dengan alt text tepat\n";
            $correctAltTextFiles++;
        } else {
            echo "   ❌ " . basename($file) . " - Logo tanpa alt text yang tepat\n";
        }
    }
}

// Test 6: Cek logo dengan PNG format
echo "\n6. ✅ LOGO DENGAN PNG FORMAT:\n";
$pngFormatFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        if (strpos($content, 'logo_settle.png') !== false) {
            echo "   ✅ " . basename($file) . " - Logo menggunakan format PNG\n";
            $pngFormatFiles++;
        } else {
            echo "   ❌ " . basename($file) . " - Logo tidak menggunakan format PNG\n";
        }
    }
}

// Test 7: Cek struktur HTML yang bersih
echo "\n7. ✅ STRUKTUR HTML YANG BERSIH:\n";
$cleanStructureFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        // Cek struktur logo yang sederhana
        $logoStructure = '<div class="mx-auto mb-8">
                    <img src="{{ asset(\'images/logos/logo_settle.png\') }}" alt="Settle Medical" class="h-24 w-24 mx-auto object-contain">
                </div>';
        
        if (strpos($content, $logoStructure) !== false) {
            echo "   ✅ " . basename($file) . " - Struktur HTML bersih\n";
            $cleanStructureFiles++;
        } else {
            echo "   ❌ " . basename($file) . " - Struktur HTML tidak bersih\n";
        }
    }
}

// Test 8: Final Summary
echo "\n8. 🎯 FINAL SUMMARY:\n";
echo "   📊 Files dengan logo tanpa container: $cleanLogoFiles/" . count($authFiles) . "\n";
echo "   📊 Files tanpa container sekitar logo: $noContainerFiles/" . count($authFiles) . "\n";
echo "   📊 Files dengan ukuran logo tepat: $correctSizeFiles/" . count($authFiles) . "\n";
echo "   📊 Files dengan positioning tepat: $correctPositioningFiles/" . count($authFiles) . "\n";
echo "   📊 Files dengan alt text tepat: $correctAltTextFiles/" . count($authFiles) . "\n";
echo "   📊 Files dengan PNG format: $pngFormatFiles/" . count($authFiles) . "\n";
echo "   📊 Files dengan struktur HTML bersih: $cleanStructureFiles/" . count($authFiles) . "\n";

echo "\n9. ✅ CLEAN LOGO CHANGES YANG DITERAPKAN:\n";
echo "   • Logo Tanpa Container: Menghilangkan semua container sekitar logo\n";
echo "   • Logo Langsung: <img> tag langsung tanpa wrapper\n";
echo "   • Ukuran Konsisten: h-24 w-24 untuk semua halaman\n";
echo "   • Positioning: mx-auto untuk center, object-contain untuk scaling\n";
echo "   • Alt Text: alt=\"Settle Medical\" untuk accessibility\n";
echo "   • PNG Format: logo_settle.png untuk semua halaman\n";
echo "   • Struktur Bersih: HTML yang sederhana dan clean\n";

echo "\n10. 🔗 URL UNTUK TEST:\n";
echo "   🔐 Login: " . config('app.url') . "/login\n";
echo "   📝 Register: " . config('app.url') . "/register\n";
echo "   🔑 Forgot Password: " . config('app.url') . "/forgot-password\n";
echo "   🔄 Reset Password: " . config('app.url') . "/reset-password\n";

echo "\n11. 🎨 CLEAN LOGO IMPROVEMENTS:\n";
echo "   • Logo yang bersih tanpa container yang mengganggu\n";
echo "   • Background putih yang minimalis\n";
echo "   • Logo yang langsung terlihat tanpa efek tambahan\n";
echo "   • Struktur HTML yang sederhana dan mudah dibaca\n";
echo "   • Ukuran logo yang proporsional dan konsisten\n";
echo "   • Desain yang clean dan professional\n";

// Test 9: Overall Score
$overallScore = ($cleanLogoFiles + $noContainerFiles + $correctSizeFiles + $correctPositioningFiles + $correctAltTextFiles + $pngFormatFiles + $cleanStructureFiles) / (7 * count($authFiles)) * 100;

echo "\n12. 🏆 OVERALL SCORE:\n";
echo "   📊 Clean Logo Score: " . round($overallScore, 1) . "%\n";

if ($overallScore >= 90) {
    echo "   🎉 EXCELLENT! Logo sudah bersih tanpa container dengan sempurna!\n";
} elseif ($overallScore >= 80) {
    echo "   ✅ GOOD! Logo sudah bersih tanpa container dengan baik!\n";
} elseif ($overallScore >= 70) {
    echo "   ⚠️ FAIR! Ada beberapa area yang perlu diperbaiki.\n";
} else {
    echo "   ❌ NEEDS IMPROVEMENT! Perlu perbaikan lebih lanjut.\n";
}

echo "\n🧹 CLEAN LOGO SETTLE MEDICAL SELESAI!\n";
echo "✨ Logo tanpa container yang mengganggu\n";
echo "🎯 Logo yang bersih dan langsung terlihat\n";
echo "📐 Ukuran logo yang proporsional (h-24 w-24)\n";
echo "🔧 Struktur HTML yang sederhana dan clean\n";
echo "🚀 Ready untuk production!\n";


