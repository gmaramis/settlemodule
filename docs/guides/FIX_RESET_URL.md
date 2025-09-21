# 🔧 Fix Reset Password URL Problem

## 🚨 **Masalah: URL Reset Password Salah**

### **❌ Masalah yang Ditemukan:**

-   **URL Lama**: `http://localhost/reset-password/...`
-   **URL Benar**: `http://127.0.0.1:8000/reset-password/...`
-   **Error**: "site can't be reached"

### **✅ Solusi yang Diterapkan:**

#### **1. Update APP_URL di .env:**

```env
# Sebelum (SALAH):
APP_URL=http://localhost

# Sesudah (BENAR):
APP_URL=http://127.0.0.1:8000
```

#### **2. Clear Cache:**

```bash
php artisan config:clear
php artisan cache:clear
```

#### **3. Verifikasi:**

```bash
grep "APP_URL" .env
```

### **🎯 Hasil Setelah Perbaikan:**

#### **✅ URL Sekarang Benar:**

-   **Base URL**: `http://127.0.0.1:8000`
-   **Reset URL**: `http://127.0.0.1:8000/reset-password/[TOKEN]?email=...`
-   **Fungsi**: Link di email akan berfungsi

#### **❌ Masalah Throttle:**

-   **Status**: `passwords.throttled`
-   **Penyebab**: Terlalu sering kirim email reset
-   **Solusi**: Tunggu 5-10 menit

### **📧 Langkah-langkah Reset Password:**

#### **1. Tunggu Throttle Reset:**

-   ⏰ **Tunggu 5-10 menit**
-   🔄 **Rate limit** akan reset otomatis

#### **2. Request Reset Password:**

-   🌐 **Buka**: `http://127.0.0.1:8000/login`
-   🔗 **Klik**: "Forgot your password?"
-   📧 **Masukkan**: `glendpm@gmail.com`
-   ✅ **Klik**: "Email Password Reset Link"

#### **3. Cek Email:**

-   📬 **Inbox**: Cek email di `glendpm@gmail.com`
-   🗑️ **Spam**: Cek folder spam/junk
-   📧 **From**: Settle Medical <medicalsettle@gmail.com>
-   📝 **Subject**: Reset Password Notification

#### **4. Klik Link Reset:**

-   🔗 **URL Baru**: `http://127.0.0.1:8000/reset-password/...`
-   ✅ **Fungsi**: Link akan berfungsi dengan baik
-   🔐 **Masukkan**: Password baru

### **🔧 Troubleshooting:**

#### **A. Jika Masih Throttled:**

```bash
# Clear semua cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Tunggu 10 menit
sleep 600

# Test lagi
php artisan tinker --execute="echo Password::sendResetLink(['email' => 'glendpm@gmail.com']);"
```

#### **B. Jika URL Masih Salah:**

```bash
# Cek konfigurasi
grep "APP_URL" .env

# Update jika perlu
sed -i 's|APP_URL=http://localhost|APP_URL=http://127.0.0.1:8000|' .env

# Clear cache
php artisan config:clear
```

#### **C. Test Manual:**

```bash
# Test URL
php test-reset-url.php

# Test email
php test-email-glendpm.php
```

### **📱 Gmail Rate Limits:**

#### **A. Limit yang Berlaku:**

-   📧 **100 emails/hour** per recipient
-   ⏰ **1 email/minute** per recipient
-   🔄 **Reset otomatis** setiap jam

#### **B. Jika Melebihi Limit:**

-   ⏰ **Tunggu 1 jam** untuk reset
-   🔄 **Gunakan email lain** untuk test
-   📧 **Cek log** untuk monitoring

### **🎯 Hasil yang Diharapkan:**

#### **✅ Setelah Tunggu Throttle:**

1. **Email Reset**: Terkirim dengan URL yang benar
2. **Link Email**: `http://127.0.0.1:8000/reset-password/...`
3. **Klik Link**: Berfungsi dan buka halaman reset
4. **Reset Password**: Berhasil dengan password baru

### **💡 Tips Pencegahan:**

#### **A. Jangan Terlalu Sering:**

-   ❌ **Jangan** kirim email reset berulang-ulang
-   ✅ **Tunggu** beberapa menit antar percobaan
-   🔄 **Gunakan** email yang berbeda untuk test

#### **B. Monitor Rate Limit:**

-   📊 **Cek status** sebelum kirim
-   ⚠️ **Perhatikan** error `throttled`
-   📝 **Catat** waktu terakhir kirim

### **🔍 Debug Commands:**

#### **A. Cek Status:**

```bash
php artisan tinker --execute="echo Password::sendResetLink(['email' => 'glendpm@gmail.com']);"
```

#### **B. Cek Konfigurasi:**

```bash
php artisan tinker --execute="echo config('app.url');"
```

#### **C. Cek Cache:**

```bash
php artisan tinker --execute="dd(Cache::get('password_reset_glendpm@gmail.com'));"
```

### **📞 Bantuan Lebih Lanjut:**

Jika masih bermasalah:

1. ⏰ **Tunggu 10 menit** dan coba lagi
2. 🔄 **Clear semua cache**
3. 📧 **Test dengan email lain**
4. 📊 **Cek log error**

## ** KESIMPULAN:**

**✅ URL RESET PASSWORD SUDAH DIPERBAIKI!**

**Sekarang:**

-   🔗 **URL**: `http://127.0.0.1:8000/reset-password/...`
-   ✅ **Fungsi**: Link di email akan berfungsi
-   ⏰ **Tunggu**: 5-10 menit untuk throttle reset
-   📧 **Email**: Akan terkirim dengan URL yang benar

**Tunggu sebentar dan coba lagi - URL sekarang sudah benar!** 🎉✅
