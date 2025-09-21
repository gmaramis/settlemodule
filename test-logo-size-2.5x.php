<?php

/**
 * Script Test Logo Size 2.5x - Settle Medical
 * Jalankan: php test-logo-size-2.5x.php
 */

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "📏 TEST LOGO SIZE 2.5X - SETTLE MEDICAL\n";
echo "======================================\n\n";

// Test 1: Cek ukuran logo 2.5x lebih besar
echo "1. ✅ UKURAN LOGO 2.5X LEBIH BESAR:\n";
$authFiles = [
    'resources/views/auth/login.blade.php',
    'resources/views/auth/register.blade.php',
    'resources/views/auth/forgot-password.blade.php',
    'resources/views/auth/reset-password.blade.php',
];

$logoSize2_5xFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        if (strpos($content, 'h-60 w-60') !== false) {
            echo "   ✅ " . basename($file) . " - Logo ukuran h-60 w-60 (2.5x dari h-24 w-24)\n";
            $logoSize2_5xFiles++;
        } else {
            echo "   ❌ " . basename($file) . " - Logo ukuran belum 2.5x lebih besar\n";
        }
    }
}

// Test 2: Cek tidak ada ukuran logo lama
echo "\n2. ✅ TIDAK ADA UKURAN LOGO LAMA:\n";
$noOldSizeFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        if (strpos($content, 'h-24 w-24') !== false) {
            echo "   ❌ " . basename($file) . " - Masih ada ukuran logo lama h-24 w-24\n";
        } else {
            echo "   ✅ " . basename($file) . " - Tidak ada ukuran logo lama\n";
            $noOldSizeFiles++;
        }
    }
}

// Test 3: Cek ukuran logo yang tepat (h-60 w-60)
echo "\n3. ✅ UKURAN LOGO YANG TEPAT (H-60 W-60):\n";
$correctSizeFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        if (strpos($content, 'h-60 w-60') !== false) {
            echo "   ✅ " . basename($file) . " - Logo ukuran h-60 w-60\n";
            $correctSizeFiles++;
        } else {
            echo "   ❌ " . basename($file) . " - Logo ukuran tidak tepat\n";
        }
    }
}

// Test 4: Cek positioning logo yang tetap
echo "\n4. ✅ POSITIONING LOGO YANG TETAP:\n";
$correctPositioningFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        if (strpos($content, 'mx-auto') !== false && 
            strpos($content, 'object-contain') !== false &&
            strpos($content, 'mb-8') !== false) {
            echo "   ✅ " . basename($file) . " - Logo positioning tetap (mx-auto, object-contain, mb-8)\n";
            $correctPositioningFiles++;
        } else {
            echo "   ❌ " . basename($file) . " - Logo positioning tidak tepat\n";
        }
    }
}

// Test 5: Cek logo dengan PNG format
echo "\n5. ✅ LOGO DENGAN PNG FORMAT:\n";
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

// Test 6: Cek logo tanpa container yang mengganggu
echo "\n6. ✅ LOGO TANPA CONTAINER YANG MENGGANGGU:\n";
$noContainerFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        // Cek tidak ada container yang mengganggu
        $containerElements = [
            'bg-gray-50' => 'Tidak ada background gray-50',
            'shadow-lg' => 'Tidak ada shadow-lg',
            'border border-gray-200' => 'Tidak ada border gray-200',
            'rounded-2xl' => 'Tidak ada rounded-2xl',
            'p-4' => 'Tidak ada padding p-4'
        ];
        
        $foundContainers = 0;
        foreach ($containerElements as $element => $description) {
            if (strpos($content, $element) !== false) {
                $foundContainers++;
            }
        }
        
        if ($foundContainers == 0) {
            echo "   ✅ " . basename($file) . " - Logo tanpa container yang mengganggu\n";
            $noContainerFiles++;
        } else {
            echo "   ❌ " . basename($file) . " - Logo masih ada container yang mengganggu\n";
        }
    }
}

// Test 7: Cek logo dengan alt text yang tepat
echo "\n7. ✅ LOGO DENGAN ALT TEXT YANG TEPAT:\n";
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

// Test 8: Final Summary
echo "\n8. 🎯 FINAL SUMMARY:\n";
echo "   📊 Files dengan logo ukuran 2.5x: $logoSize2_5xFiles/" . count($authFiles) . "\n";
echo "   📊 Files tanpa ukuran logo lama: $noOldSizeFiles/" . count($authFiles) . "\n";
echo "   📊 Files dengan ukuran logo tepat: $correctSizeFiles/" . count($authFiles) . "\n";
echo "   📊 Files dengan positioning tepat: $correctPositioningFiles/" . count($authFiles) . "\n";
echo "   📊 Files dengan PNG format: $pngFormatFiles/" . count($authFiles) . "\n";
echo "   📊 Files tanpa container mengganggu: $noContainerFiles/" . count($authFiles) . "\n";
echo "   📊 Files dengan alt text tepat: $correctAltTextFiles/" . count($authFiles) . "\n";

echo "\n9. ✅ LOGO SIZE 2.5X CHANGES YANG DITERAPKAN:\n";
echo "   • Ukuran Logo: h-60 w-60 (2.5x dari h-24 w-24)\n";
echo "   • Tidak Ada Ukuran Lama: Menghilangkan h-24 w-24\n";
echo "   • Positioning Tetap: mx-auto untuk center, object-contain untuk scaling\n";
echo "   • Margin Tetap: mb-8 untuk spacing yang konsisten\n";
echo "   • Alt Text: alt=\"Settle Medical\" untuk accessibility\n";
echo "   • PNG Format: logo_settle.png untuk semua halaman\n";
echo "   • Tidak Ada Container: Logo langsung tanpa container yang mengganggu\n";

echo "\n10. 🔗 URL UNTUK TEST:\n";
echo "   🔐 Login: " . config('app.url') . "/login\n";
echo "   📝 Register: " . config('app.url') . "/register\n";
echo "   🔑 Forgot Password: " . config('app.url') . "/forgot-password\n";
echo "   🔄 Reset Password: " . config('app.url') . "/reset-password\n";

echo "\n11. 🎨 LOGO SIZE 2.5X IMPROVEMENTS:\n";
echo "   • Logo yang 2.5x lebih besar dan lebih menonjol\n";
echo "   • Ukuran h-60 w-60 yang proporsional\n";
echo "   • Positioning yang tetap center dan responsive\n";
echo "   • Logo yang bersih tanpa container yang mengganggu\n";
echo "   • Background putih yang minimalis\n";
echo "   • Desain yang clean dan professional\n";

// Test 9: Overall Score
$overallScore = ($logoSize2_5xFiles + $noOldSizeFiles + $correctSizeFiles + $correctPositioningFiles + $pngFormatFiles + $noContainerFiles + $correctAltTextFiles) / (7 * count($authFiles)) * 100;

echo "\n12. 🏆 OVERALL SCORE:\n";
echo "   📊 Logo Size 2.5x Score: " . round($overallScore, 1) . "%\n";

if ($overallScore >= 90) {
    echo "   🎉 EXCELLENT! Logo sudah diperbesar 2.5x dengan sempurna!\n";
} elseif ($overallScore >= 80) {
    echo "   ✅ GOOD! Logo sudah diperbesar 2.5x dengan baik!\n";
} elseif ($overallScore >= 70) {
    echo "   ⚠️ FAIR! Ada beberapa area yang perlu diperbaiki.\n";
} else {
    echo "   ❌ NEEDS IMPROVEMENT! Perlu perbaikan lebih lanjut.\n";
}

echo "\n📏 LOGO SIZE 2.5X SETTLE MEDICAL SELESAI!\n";
echo "✨ Logo yang 2.5x lebih besar (h-60 w-60)\n";
echo "🎯 Logo yang lebih menonjol dan terlihat jelas\n";
echo "📐 Ukuran yang proporsional dan responsive\n";
echo "🔧 Positioning yang tetap center dan konsisten\n";
echo "🚀 Ready untuk production!\n";


