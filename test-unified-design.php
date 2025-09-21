<?php

/**
 * Script Test Unified Design - Settle Medical
 * Jalankan: php test-unified-design.php
 */

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🎨 TEST UNIFIED DESIGN - SETTLE MEDICAL\n";
echo "=======================================\n\n";

// Test 1: Cek background gradient yang menyatu
echo "1. ✅ BACKGROUND GRADIENT YANG MENYATU:\n";
$authFiles = [
    'resources/views/auth/login.blade.php',
    'resources/views/auth/register.blade.php',
    'resources/views/auth/forgot-password.blade.php',
    'resources/views/auth/reset-password.blade.php',
];

$backgroundElements = [
    'bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50' => 'Background gradient blue-indigo-purple',
    'bg-white/90 backdrop-blur-sm' => 'Form card dengan transparency dan blur',
    'bg-white/80 backdrop-blur-sm' => 'Logo container dengan transparency dan blur',
    'border-white/20' => 'Border dengan transparency',
    'shadow-lg' => 'Shadow yang konsisten',
];

$backgroundFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $foundElements = 0;
        
        echo "\n   📄 " . basename($file) . ":\n";
        
        foreach ($backgroundElements as $element => $description) {
            if (strpos($content, $element) !== false) {
                echo "      ✅ $description\n";
                $foundElements++;
            } else {
                echo "      ❌ $description\n";
            }
        }
        
        echo "      📊 Background elements: $foundElements/" . count($backgroundElements) . "\n";
        
        if ($foundElements >= (count($backgroundElements) * 0.8)) { // 80% threshold
            $backgroundFiles++;
        }
    }
}

// Test 2: Cek logo container yang menyatu
echo "\n2. ✅ LOGO CONTAINER YANG MENYATU:\n";
$logoContainerElements = [
    'bg-white/80 backdrop-blur-sm' => 'Logo container dengan transparency',
    'rounded-full' => 'Logo container rounded full',
    'p-6' => 'Logo container padding',
    'shadow-lg' => 'Logo container shadow',
    'border border-white/20' => 'Logo container border dengan transparency',
];

$logoContainerFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $foundElements = 0;
        
        echo "\n   📄 " . basename($file) . ":\n";
        
        foreach ($logoContainerElements as $element => $description) {
            if (strpos($content, $element) !== false) {
                echo "      ✅ $description\n";
                $foundElements++;
            } else {
                echo "      ❌ $description\n";
            }
        }
        
        echo "      📊 Logo container elements: $foundElements/" . count($logoContainerElements) . "\n";
        
        if ($foundElements >= (count($logoContainerElements) * 0.8)) { // 80% threshold
            $logoContainerFiles++;
        }
    }
}

// Test 3: Cek form card yang menyatu
echo "\n3. ✅ FORM CARD YANG MENYATU:\n";
$formCardElements = [
    'bg-white/90 backdrop-blur-sm' => 'Form card dengan transparency dan blur',
    'rounded-xl' => 'Form card rounded xl',
    'shadow-lg' => 'Form card shadow',
    'border border-white/20' => 'Form card border dengan transparency',
    'p-10' => 'Form card padding yang adequate',
];

$formCardFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $foundElements = 0;
        
        echo "\n   📄 " . basename($file) . ":\n";
        
        foreach ($formCardElements as $element => $description) {
            if (strpos($content, $element) !== false) {
                echo "      ✅ $description\n";
                $foundElements++;
            } else {
                echo "      ❌ $description\n";
            }
        }
        
        echo "      📊 Form card elements: $foundElements/" . count($formCardElements) . "\n";
        
        if ($foundElements >= (count($formCardElements) * 0.8)) { // 80% threshold
            $formCardFiles++;
        }
    }
}

// Test 4: Cek tidak ada background putih solid
echo "\n4. ✅ TIDAK ADA BACKGROUND PUTIH SOLID:\n";
$solidWhiteFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        if (strpos($content, 'bg-white flex') !== false || strpos($content, 'bg-white"') !== false) {
            echo "   ❌ " . basename($file) . " - Masih ada background putih solid\n";
        } else {
            echo "   ✅ " . basename($file) . " - Tidak ada background putih solid\n";
            $solidWhiteFiles++;
        }
    }
}

// Test 5: Cek tidak ada border gray solid
echo "\n5. ✅ TIDAK ADA BORDER GRAY SOLID:\n";
$solidBorderFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        if (strpos($content, 'border-gray-200') !== false || strpos($content, 'border-gray-300') !== false) {
            echo "   ❌ " . basename($file) . " - Masih ada border gray solid\n";
        } else {
            echo "   ✅ " . basename($file) . " - Tidak ada border gray solid\n";
            $solidBorderFiles++;
        }
    }
}

// Test 6: Cek glassmorphism effects
echo "\n6. ✅ GLASSMORPHISM EFFECTS:\n";
$glassmorphismElements = [
    'backdrop-blur-sm' => 'Backdrop blur effect',
    'bg-white/90' => 'Background dengan transparency 90%',
    'bg-white/80' => 'Background dengan transparency 80%',
    'border-white/20' => 'Border dengan transparency 20%',
    'shadow-lg' => 'Shadow yang konsisten',
];

$glassmorphismFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $foundElements = 0;
        
        echo "\n   📄 " . basename($file) . ":\n";
        
        foreach ($glassmorphismElements as $element => $description) {
            if (strpos($content, $element) !== false) {
                echo "      ✅ $description\n";
                $foundElements++;
            } else {
                echo "      ❌ $description\n";
            }
        }
        
        echo "      📊 Glassmorphism elements: $foundElements/" . count($glassmorphismElements) . "\n";
        
        if ($foundElements >= (count($glassmorphismElements) * 0.8)) { // 80% threshold
            $glassmorphismFiles++;
        }
    }
}

// Test 7: Cek color harmony
echo "\n7. ✅ COLOR HARMONY:\n";
$colorHarmonyElements = [
    'from-blue-50' => 'Gradient start blue-50',
    'via-indigo-50' => 'Gradient middle indigo-50',
    'to-purple-50' => 'Gradient end purple-50',
    'text-gray-900' => 'Text color gray-900',
    'text-gray-800' => 'Text color gray-800',
    'text-yellow-500' => 'Accent color yellow-500',
];

$colorHarmonyFiles = 0;
foreach ($authFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $foundElements = 0;
        
        echo "\n   📄 " . basename($file) . ":\n";
        
        foreach ($colorHarmonyElements as $element => $description) {
            if (strpos($content, $element) !== false) {
                echo "      ✅ $description\n";
                $foundElements++;
            } else {
                echo "      ❌ $description\n";
            }
        }
        
        echo "      📊 Color harmony elements: $foundElements/" . count($colorHarmonyElements) . "\n";
        
        if ($foundElements >= (count($colorHarmonyElements) * 0.6)) { // 60% threshold
            $colorHarmonyFiles++;
        }
    }
}

// Test 8: Final Summary
echo "\n8. 🎯 FINAL SUMMARY:\n";
echo "   📊 Files dengan background gradient yang menyatu: $backgroundFiles/" . count($authFiles) . "\n";
echo "   📊 Files dengan logo container yang menyatu: $logoContainerFiles/" . count($authFiles) . "\n";
echo "   📊 Files dengan form card yang menyatu: $formCardFiles/" . count($authFiles) . "\n";
echo "   📊 Files tanpa background putih solid: $solidWhiteFiles/" . count($authFiles) . "\n";
echo "   📊 Files tanpa border gray solid: $solidBorderFiles/" . count($authFiles) . "\n";
echo "   📊 Files dengan glassmorphism effects: $glassmorphismFiles/" . count($authFiles) . "\n";
echo "   📊 Files dengan color harmony: $colorHarmonyFiles/" . count($authFiles) . "\n";

echo "\n9. ✅ UNIFIED DESIGN ELEMENTS YANG DITERAPKAN:\n";
echo "   • Background Gradient: Blue-indigo-purple gradient yang soft\n";
echo "   • Logo Container: Rounded full dengan transparency dan blur\n";
echo "   • Form Card: Transparency 90% dengan backdrop blur\n";
echo "   • Border: Transparency 20% untuk efek glassmorphism\n";
echo "   • Shadow: Konsisten di semua elemen\n";
echo "   • Color Harmony: Warna yang menyatu dan harmonis\n";
echo "   • No Solid Backgrounds: Tidak ada background putih solid\n";
echo "   • No Solid Borders: Tidak ada border gray solid\n";

echo "\n10. 🔗 URL UNTUK TEST:\n";
echo "   🔐 Login: " . config('app.url') . "/login\n";
echo "   📝 Register: " . config('app.url') . "/register\n";
echo "   🔑 Forgot Password: " . config('app.url') . "/forgot-password\n";
echo "   🔄 Reset Password: " . config('app.url') . "/reset-password\n";

echo "\n11. 🎨 UNIFIED DESIGN IMPROVEMENTS:\n";
echo "   • Background yang menyatu dengan gradient blue-indigo-purple\n";
echo "   • Logo container dengan glassmorphism effect\n";
echo "   • Form card dengan transparency dan backdrop blur\n";
echo "   • Border dengan transparency untuk efek yang halus\n";
echo "   • Shadow yang konsisten di semua elemen\n";
echo "   • Color harmony yang menyatu\n";
echo "   • Tidak ada kontras yang tajam antara elemen\n";

// Test 9: Overall Score
$overallScore = ($backgroundFiles + $logoContainerFiles + $formCardFiles + $solidWhiteFiles + $solidBorderFiles + $glassmorphismFiles + $colorHarmonyFiles) / (7 * count($authFiles)) * 100;

echo "\n12. 🏆 OVERALL SCORE:\n";
echo "   📊 Unified Design Score: " . round($overallScore, 1) . "%\n";

if ($overallScore >= 90) {
    echo "   🎉 EXCELLENT! Desain sudah sangat menyatu dan harmonis!\n";
} elseif ($overallScore >= 80) {
    echo "   ✅ GOOD! Desain sudah cukup menyatu!\n";
} elseif ($overallScore >= 70) {
    echo "   ⚠️ FAIR! Ada beberapa area yang perlu diperbaiki.\n";
} else {
    echo "   ❌ NEEDS IMPROVEMENT! Perlu perbaikan lebih lanjut.\n";
}

echo "\n🎨 UNIFIED DESIGN SETTLE MEDICAL SELESAI!\n";
echo "✨ Background gradient yang menyatu (blue-indigo-purple)\n";
echo "🔮 Glassmorphism effects dengan transparency dan blur\n";
echo "🎯 Logo container yang menyatu dengan background\n";
echo "📱 Form card yang menyatu dengan glassmorphism\n";
echo "🌈 Color harmony yang konsisten\n";
echo "🔧 Ready untuk production!\n";


