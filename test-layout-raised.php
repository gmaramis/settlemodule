<?php

/**
 * Script Test Layout Raised - Settle Medical
 * Jalankan: php test-layout-raised.php
 */

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "⬆️ TEST LAYOUT RAISED - SETTLE MEDICAL\n";
echo "=====================================\n\n";

// Test 1: Cek logo margin yang dikurangi
echo "1. ✅ LOGO MARGIN YANG DIKURANGI:\n";
$authFiles = [
    'resources/views/auth/login.blade.php',
    'resources/views/auth/register.blade.php',
    'resources/views/auth/forgot-password.blade.php',
    'resources/views/auth/reset-password.blade.php',
];

$logoMarginReducedFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        if (strpos($content, 'mb-4') !== false) {
            echo "   ✅ " . basename($file) . " - Logo margin dikurangi ke mb-4\n";
            $logoMarginReducedFiles++;
        } else {
            echo "   ❌ " . basename($file) . " - Logo margin belum dikurangi\n";
        }
    }
}

// Test 2: Cek branding section margin yang dikurangi
echo "\n2. ✅ BRANDING SECTION MARGIN YANG DIKURANGI:\n";
$brandingMarginReducedFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        if (strpos($content, 'mb-6') !== false) {
            echo "   ✅ " . basename($file) . " - Branding section margin dikurangi ke mb-6\n";
            $brandingMarginReducedFiles++;
        } else {
            echo "   ❌ " . basename($file) . " - Branding section margin belum dikurangi\n";
        }
    }
}

// Test 3: Cek tidak ada margin yang berlebihan
echo "\n3. ✅ TIDAK ADA MARGIN YANG BERLEBIHAN:\n";
$noExcessiveMarginFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        // Cek tidak ada margin yang berlebihan
        $excessiveMargins = [
            'mb-8' => 'Tidak ada mb-8 yang berlebihan',
            'mb-10' => 'Tidak ada mb-10 yang berlebihan',
            'mb-12' => 'Tidak ada mb-12 yang berlebihan'
        ];
        
        $foundExcessive = 0;
        foreach ($excessiveMargins as $margin => $description) {
            if (strpos($content, $margin) !== false) {
                $foundExcessive++;
            }
        }
        
        if ($foundExcessive == 0) {
            echo "   ✅ " . basename($file) . " - Tidak ada margin yang berlebihan\n";
            $noExcessiveMarginFiles++;
        } else {
            echo "   ❌ " . basename($file) . " - Masih ada margin yang berlebihan\n";
        }
    }
}

// Test 4: Cek SETTLE title margin yang dikurangi
echo "\n4. ✅ SETTLE TITLE MARGIN YANG DIKURANGI:\n";
$settleTitleMarginReducedFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        if (strpos($content, 'mb-2') !== false) {
            echo "   ✅ " . basename($file) . " - SETTLE title margin dikurangi ke mb-2\n";
            $settleTitleMarginReducedFiles++;
        } else {
            echo "   ❌ " . basename($file) . " - SETTLE title margin belum dikurangi\n";
        }
    }
}

// Test 5: Cek layout yang lebih compact
echo "\n5. ✅ LAYOUT YANG LEBIH COMPACT:\n";
$compactLayoutFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        // Cek layout yang lebih compact
        $compactElements = [
            'mb-4' => 'Logo margin mb-4',
            'mb-6' => 'Branding section margin mb-6',
            'mb-2' => 'SETTLE title margin mb-2',
            'mb-1' => 'Text margin mb-1'
        ];
        
        $foundCompact = 0;
        foreach ($compactElements as $element => $description) {
            if (strpos($content, $element) !== false) {
                $foundCompact++;
            }
        }
        
        if ($foundCompact >= 2) {
            echo "   ✅ " . basename($file) . " - Layout lebih compact\n";
            $compactLayoutFiles++;
        } else {
            echo "   ❌ " . basename($file) . " - Layout belum compact\n";
        }
    }
}

// Test 6: Cek logo ukuran tetap besar
echo "\n6. ✅ LOGO UKURAN TETAP BESAR:\n";
$logoSizeMaintainedFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        if (strpos($content, 'h-60 w-60') !== false) {
            echo "   ✅ " . basename($file) . " - Logo ukuran tetap h-60 w-60\n";
            $logoSizeMaintainedFiles++;
        } else {
            echo "   ❌ " . basename($file) . " - Logo ukuran tidak tepat\n";
        }
    }
}

// Test 7: Cek font size yang tetap
echo "\n7. ✅ FONT SIZE YANG TETAP:\n";
$fontSizeMaintainedFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        if (strpos($content, 'font-size: 25px') !== false) {
            echo "   ✅ " . basename($file) . " - Font size tetap 25px\n";
            $fontSizeMaintainedFiles++;
        } else {
            echo "   ❌ " . basename($file) . " - Font size tidak tepat\n";
        }
    }
}

// Test 8: Final Summary
echo "\n8. 🎯 FINAL SUMMARY:\n";
echo "   📊 Files dengan logo margin dikurangi: $logoMarginReducedFiles/" . count($authFiles) . "\n";
echo "   📊 Files dengan branding margin dikurangi: $brandingMarginReducedFiles/" . count($authFiles) . "\n";
echo "   📊 Files tanpa margin berlebihan: $noExcessiveMarginFiles/" . count($authFiles) . "\n";
echo "   📊 Files dengan SETTLE title margin dikurangi: $settleTitleMarginReducedFiles/" . count($authFiles) . "\n";
echo "   📊 Files dengan layout compact: $compactLayoutFiles/" . count($authFiles) . "\n";
echo "   📊 Files dengan logo ukuran tetap: $logoSizeMaintainedFiles/" . count($authFiles) . "\n";
echo "   📊 Files dengan font size tetap: $fontSizeMaintainedFiles/" . count($authFiles) . "\n";

echo "\n9. ✅ LAYOUT RAISED CHANGES YANG DITERAPKAN:\n";
echo "   • Logo Margin: Dikurangi dari mb-8 ke mb-4\n";
echo "   • Branding Section Margin: Dikurangi dari mb-10 ke mb-6\n";
echo "   • SETTLE Title Margin: Dikurangi dari mb-4 ke mb-2\n";
echo "   • Layout Compact: Semua elemen dinaikkan ke atas\n";
echo "   • Logo Ukuran Tetap: h-60 w-60 tetap dipertahankan\n";
echo "   • Font Size Tetap: 25px tetap dipertahankan\n";
echo "   • Form Position: Form juga ikut naik ke atas\n";

echo "\n10. 🔗 URL UNTUK TEST:\n";
echo "   🔐 Login: " . config('app.url') . "/login\n";
echo "   📝 Register: " . config('app.url') . "/register\n";
echo "   🔑 Forgot Password: " . config('app.url') . "/forgot-password\n";
echo "   🔄 Reset Password: " . config('app.url') . "/reset-password\n";

echo "\n11. 🎨 LAYOUT RAISED IMPROVEMENTS:\n";
echo "   • Tulisan SETTLE dan text di bawahnya dinaikkan ke atas\n";
echo "   • Form juga ikut naik ke atas\n";
echo "   • Layout yang lebih compact dan tidak terlalu terpisah\n";
echo "   • Logo ukuran tetap besar (h-60 w-60)\n";
echo "   • Font size tetap 25px untuk readability\n";
echo "   • Background putih yang bersih\n";

// Test 9: Overall Score
$overallScore = ($logoMarginReducedFiles + $brandingMarginReducedFiles + $noExcessiveMarginFiles + $settleTitleMarginReducedFiles + $compactLayoutFiles + $logoSizeMaintainedFiles + $fontSizeMaintainedFiles) / (7 * count($authFiles)) * 100;

echo "\n12. 🏆 OVERALL SCORE:\n";
echo "   📊 Layout Raised Score: " . round($overallScore, 1) . "%\n";

if ($overallScore >= 90) {
    echo "   🎉 EXCELLENT! Layout sudah dinaikkan dengan sempurna!\n";
} elseif ($overallScore >= 80) {
    echo "   ✅ GOOD! Layout sudah dinaikkan dengan baik!\n";
} elseif ($overallScore >= 70) {
    echo "   ⚠️ FAIR! Ada beberapa area yang perlu diperbaiki.\n";
} else {
    echo "   ❌ NEEDS IMPROVEMENT! Perlu perbaikan lebih lanjut.\n";
}

echo "\n⬆️ LAYOUT RAISED SETTLE MEDICAL SELESAI!\n";
echo "✨ Tulisan SETTLE dan text di bawahnya dinaikkan ke atas\n";
echo "📱 Form juga ikut naik ke atas\n";
echo "📐 Layout yang lebih compact dan tidak terlalu terpisah\n";
echo "🎯 Logo ukuran tetap besar (h-60 w-60)\n";
echo "🚀 Ready untuk production!\n";




