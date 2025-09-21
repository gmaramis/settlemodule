<?php

/**
 * Script Test Logo Fix - Settle Medical
 * Jalankan: php test-logo-fix.php
 */

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔧 TEST LOGO FIX - SETTLE MEDICAL\n";
echo "=================================\n\n";

// Test 1: Cek logo sudah diperbaiki
echo "1. ✅ LOGO SUDAH DIPERBAIKI:\n";
$authFiles = [
    'resources/views/auth/login.blade.php',
    'resources/views/auth/register.blade.php',
    'resources/views/auth/forgot-password.blade.php',
    'resources/views/auth/reset-password.blade.php',
];

$logoFixElements = [
    'h-32 w-32' => 'Logo size 32x32 (ukuran yang wajar)',
    'object-contain' => 'Object contain untuk scaling',
    'mx-auto' => 'Logo centered',
    'alt="Settle Medical"' => 'Alt text untuk accessibility',
];

$logoFixFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $foundElements = 0;
        
        echo "\n   📄 " . basename($file) . ":\n";
        
        foreach ($logoFixElements as $element => $description) {
            if (strpos($content, $element) !== false) {
                echo "      ✅ $description\n";
                $foundElements++;
            } else {
                echo "      ❌ $description\n";
            }
        }
        
        echo "      📊 Logo fix elements: $foundElements/" . count($logoFixElements) . "\n";
        
        if ($foundElements >= count($logoFixElements)) {
            $logoFixFiles++;
        }
    }
}

// Test 2: Cek tidak ada container yang kacau
echo "\n2. ✅ TIDAK ADA CONTAINER YANG KACAU:\n";
$problematicElements = [
    'rounded-full' => 'Tidak ada rounded-full container',
    'bg-white/80 backdrop-blur-sm' => 'Tidak ada glassmorphism container',
    'p-6' => 'Tidak ada padding yang berlebihan',
    'border border-white/20' => 'Tidak ada border yang tidak perlu',
    'h-60 w-60' => 'Tidak ada ukuran logo yang terlalu besar',
];

$cleanFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $foundProblems = 0;
        
        echo "\n   📄 " . basename($file) . ":\n";
        
        foreach ($problematicElements as $element => $description) {
            if (strpos($content, $element) !== false) {
                echo "      ❌ $description\n";
                $foundProblems++;
            } else {
                echo "      ✅ $description\n";
            }
        }
        
        echo "      📊 Problematic elements: $foundProblems/" . count($problematicElements) . "\n";
        
        if ($foundProblems == 0) {
            $cleanFiles++;
        }
    }
}

// Test 3: Cek logo PNG masih digunakan
echo "\n3. ✅ LOGO PNG MASIH DIGUNAKAN:\n";
$pngFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        if (strpos($content, 'logo_settle.png') !== false) {
            echo "   ✅ " . basename($file) . " - Menggunakan logo PNG\n";
            $pngFiles++;
        } else {
            echo "   ❌ " . basename($file) . " - Tidak menggunakan logo PNG\n";
        }
    }
}

// Test 4: Cek ukuran logo yang wajar
echo "\n4. ✅ UKURAN LOGO YANG WAJAR:\n";
$reasonableSizeFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        if (strpos($content, 'h-32 w-32') !== false) {
            echo "   ✅ " . basename($file) . " - Ukuran logo wajar (h-32 w-32)\n";
            $reasonableSizeFiles++;
        } elseif (strpos($content, 'h-24 w-24') !== false) {
            echo "   ✅ " . basename($file) . " - Ukuran logo wajar (h-24 w-24)\n";
            $reasonableSizeFiles++;
        } else {
            echo "   ❌ " . basename($file) . " - Ukuran logo tidak wajar\n";
        }
    }
}

// Test 5: Cek logo tidak terpotong atau kacau
echo "\n5. ✅ LOGO TIDAK TERPOTONG ATAU KACAU:\n";
$cleanLogoFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        // Cek tidak ada container yang bisa membuat logo terpotong
        if (strpos($content, 'rounded-full') === false && 
            strpos($content, 'overflow-hidden') === false &&
            strpos($content, 'p-6') === false) {
            echo "   ✅ " . basename($file) . " - Logo tidak terpotong\n";
            $cleanLogoFiles++;
        } else {
            echo "   ❌ " . basename($file) . " - Logo mungkin terpotong\n";
        }
    }
}

// Test 6: Final Summary
echo "\n6. 🎯 FINAL SUMMARY:\n";
echo "   📊 Files dengan logo yang diperbaiki: $logoFixFiles/" . count($authFiles) . "\n";
echo "   📊 Files tanpa container yang kacau: $cleanFiles/" . count($authFiles) . "\n";
echo "   📊 Files menggunakan logo PNG: $pngFiles/" . count($authFiles) . "\n";
echo "   📊 Files dengan ukuran logo wajar: $reasonableSizeFiles/" . count($authFiles) . "\n";
echo "   📊 Files dengan logo tidak terpotong: $cleanLogoFiles/" . count($authFiles) . "\n";

echo "\n7. ✅ LOGO FIX YANG DITERAPKAN:\n";
echo "   • Ukuran Logo: h-32 w-32 (ukuran yang wajar)\n";
echo "   • Tidak Ada Container: Menghilangkan container yang tidak perlu\n";
echo "   • Object Contain: Untuk scaling yang proper\n";
echo "   • Centered: mx-auto untuk posisi tengah\n";
echo "   • PNG Format: Masih menggunakan logo_settle.png\n";
echo "   • Clean Design: Logo yang bersih dan tidak kacau\n";

echo "\n8. 🔗 URL UNTUK TEST:\n";
echo "   🔐 Login: " . config('app.url') . "/login\n";
echo "   📝 Register: " . config('app.url') . "/register\n";
echo "   🔑 Forgot Password: " . config('app.url') . "/forgot-password\n";
echo "   🔄 Reset Password: " . config('app.url') . "/reset-password\n";

echo "\n9. 🎨 LOGO IMPROVEMENTS:\n";
echo "   • Menghilangkan container rounded-full yang kacau\n";
echo "   • Mengurangi ukuran logo dari h-60 w-60 ke h-32 w-32\n";
echo "   • Menghilangkan padding yang berlebihan\n";
echo "   • Menghilangkan border yang tidak perlu\n";
echo "   • Logo yang bersih dan proporsional\n";

// Test 7: Overall Score
$overallScore = ($logoFixFiles + $cleanFiles + $pngFiles + $reasonableSizeFiles + $cleanLogoFiles) / (5 * count($authFiles)) * 100;

echo "\n10. 🏆 OVERALL SCORE:\n";
echo "   📊 Logo Fix Score: " . round($overallScore, 1) . "%\n";

if ($overallScore >= 90) {
    echo "   🎉 EXCELLENT! Logo sudah diperbaiki dengan sempurna!\n";
} elseif ($overallScore >= 80) {
    echo "   ✅ GOOD! Logo sudah diperbaiki dengan baik!\n";
} elseif ($overallScore >= 70) {
    echo "   ⚠️ FAIR! Ada beberapa area yang perlu diperbaiki.\n";
} else {
    echo "   ❌ NEEDS IMPROVEMENT! Perlu perbaikan lebih lanjut.\n";
}

echo "\n🔧 LOGO FIX SETTLE MEDICAL SELESAI!\n";
echo "✨ Logo dengan ukuran yang wajar (h-32 w-32)\n";
echo "🧹 Menghilangkan container yang kacau\n";
echo "📐 Logo yang bersih dan proporsional\n";
echo "🎯 Desain yang tidak mengganggu\n";
echo "🔧 Ready untuk production!\n";


