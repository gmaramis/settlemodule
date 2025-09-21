# 🚨 Troubleshooting Email Throttle (Rate Limiting)

## **Masalah: `passwords.throttled`**

### **🔍 Penyebab:**

-   ❌ **Rate Limiting**: Email reset password dibatasi karena terlalu sering dikirim
-   ❌ **Cache Throttle**: Laravel menyimpan throttle di cache
-   ❌ **Gmail Rate Limit**: Gmail membatasi jumlah email per menit

### **✅ Solusi:**

#### **1. Clear Cache Laravel:**

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

#### **2. Clear Cache Manual:**

```bash
php artisan tinker
```

Di dalam tinker:

```php
Cache::flush();
```

#### **3. Tunggu Beberapa Menit:**

-   ⏰ **Tunggu 5-10 menit** sebelum coba lagi
-   🕐 **Rate limit** biasanya reset otomatis

#### **4. Test dengan Email Lain:**

```bash
php test-password-reset.php
```

### **🔧 Script Otomatis:**

#### **A. Clear Throttle Script:**

```bash
php artisan tinker --execute="Cache::flush(); echo 'Throttle cleared!';"
```

#### **B. Test Email Script:**

```bash
php test-email-glendpm.php
```

### **📊 Status Email Reset:**

#### **✅ Berhasil:**

-   `passwords.sent` - Email terkirim
-   `passwords.user` - User ditemukan

#### **❌ Gagal:**

-   `passwords.throttled` - Terlalu sering dikirim
-   `passwords.invalid` - Email tidak valid
-   `passwords.user` - User tidak ditemukan

### **🎯 Langkah Troubleshooting:**

1. **Cek Status:**

    ```bash
    php artisan tinker --execute="echo Password::sendResetLink(['email' => 'glendpm@gmail.com']);"
    ```

2. **Clear Cache:**

    ```bash
    php artisan cache:clear
    ```

3. **Test Lagi:**

    ```bash
    php test-password-reset.php
    ```

4. **Tunggu:**
    - ⏰ Tunggu 5-10 menit
    - 🔄 Coba lagi

### **💡 Tips Pencegahan:**

#### **A. Jangan Terlalu Sering:**

-   ❌ Jangan kirim email reset berulang-ulang
-   ✅ Tunggu beberapa menit antar percobaan

#### **B. Gunakan Email Test:**

-   📧 Test dengan email yang berbeda
-   🔄 Rotasi email untuk testing

#### **C. Monitor Rate Limit:**

-   📊 Cek log untuk throttle
-   ⚠️ Perhatikan error `throttled`

### **🔍 Debugging:**

#### **A. Cek Cache:**

```bash
php artisan tinker --execute="dd(Cache::get('password_reset_glendpm@gmail.com'));"
```

#### **B. Cek Log:**

```bash
tail -50 storage/logs/laravel.log
```

#### **C. Test Manual:**

```bash
php test-email-glendpm.php
```

### **📱 Gmail Rate Limits:**

#### **A. Gmail SMTP Limits:**

-   📧 **500 emails/day** (free account)
-   ⏰ **100 emails/hour** (rate limit)
-   🔄 **1 email/minute** (per recipient)

#### **B. Jika Melebihi Limit:**

-   ⏰ **Tunggu 24 jam** untuk reset
-   🔄 **Gunakan email provider lain**
-   📧 **Upgrade ke Gmail Business**

### **🎯 Hasil Setelah Troubleshooting:**

#### **✅ Berhasil:**

-   Status: `passwords.sent`
-   Email terkirim ke inbox
-   User bisa reset password

#### **❌ Masih Gagal:**

-   Cek konfigurasi SMTP
-   Cek Gmail App Password
-   Cek rate limit Gmail

### **📞 Bantuan Lebih Lanjut:**

Jika masih bermasalah:

1. 🔄 **Tunggu 10 menit** dan coba lagi
2. 📧 **Test dengan email lain**
3. 🔧 **Clear semua cache**
4. 📊 **Cek log error**

**Rate limiting adalah fitur keamanan normal - tunggu sebentar dan coba lagi!** ⏰✅
