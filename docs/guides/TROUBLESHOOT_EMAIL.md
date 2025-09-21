# 🔧 Troubleshooting Email Lupa Password

## 🚨 **Masalah: Email Reset Password Tidak Terkirim**

### **1. Diagnosis Awal:**

#### **A. Cek Konfigurasi:**

```bash
grep -E "MAIL_" .env
```

#### **B. Test Email:**

```bash
php test-password-reset.php
```

#### **C. Cek Log:**

```bash
tail -50 storage/logs/laravel.log
```

### **2. Kemungkinan Penyebab:**

#### **A. Email Tidak Ada di Database:**

-   ❌ **User dengan email tersebut tidak terdaftar**
-   ✅ **Solusi**: Gunakan email yang sudah terdaftar

**Users yang tersedia:**

-   admin@settle.com
-   glendpm@gmail.com
-   jane@settle.com
-   admin@settle.test

#### **B. Email Masuk ke Spam/Junk:**

-   ❌ **Email terkirim tapi masuk spam**
-   ✅ **Solusi**: Cek folder spam/junk

#### **C. Error SMTP:**

-   ❌ **Konfigurasi SMTP salah**
-   ✅ **Solusi**: Cek App Password Gmail

#### **D. Cache Laravel:**

-   ❌ **Konfigurasi belum ter-update**
-   ✅ **Solusi**: Clear cache

### **3. Langkah Troubleshooting:**

#### **A. Test Email Langsung:**

```bash
php artisan tinker
```

Di dalam tinker:

```php
Mail::raw('Test email', function ($message) {
    $message->to('your-email@example.com')->subject('Test');
});
```

#### **B. Test Password Reset:**

```bash
php artisan tinker
```

Di dalam tinker:

```php
Password::sendResetLink(['email' => 'admin@settle.com']);
```

#### **C. Clear Cache:**

```bash
php artisan config:clear
php artisan cache:clear
```

### **4. Cek Email di Gmail:**

#### **A. Cek Inbox:**

-   Buka Gmail
-   Cari email dari "Settle Medical"
-   Subject: "Reset Password Notification"

#### **B. Cek Spam/Junk:**

-   Buka folder Spam
-   Cari email dari "medicalsettle@gmail.com"

#### **C. Cek All Mail:**

-   Buka "All Mail" di Gmail
-   Cari email terbaru

### **5. Test dengan Email yang Valid:**

#### **A. Gunakan Email yang Ada:**

-   admin@settle.com
-   glendpm@gmail.com
-   jane@settle.com

#### **B. Test Password Reset:**

1. Buka: http://127.0.0.1:8000/login
2. Klik: "Forgot your password?"
3. Masukkan: admin@settle.com
4. Klik: "Email Password Reset Link"

### **6. Verifikasi Konfigurasi:**

#### **A. Konfigurasi yang Benar:**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=medicalsettle@gmail.com
MAIL_PASSWORD=uatxvozkntvqvegw
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="medicalsettle@gmail.com"
MAIL_FROM_NAME="Settle Medical"
```

#### **B. Test Konfigurasi:**

```bash
php test-password-reset.php
```

### **7. Solusi Alternatif:**

#### **A. Jika Gmail Bermasalah:**

-   Switch ke Yahoo Mail
-   Switch ke Outlook
-   Gunakan LOG driver untuk development

#### **B. Jika Email Tidak Ada:**

-   Buat user baru dengan email yang valid
-   Gunakan email yang sudah ada

### **8. Checklist Troubleshooting:**

-   [ ] Konfigurasi email benar
-   [ ] Cache Laravel di-clear
-   [ ] Email ada di database
-   [ ] Test email langsung berhasil
-   [ ] Test password reset berhasil
-   [ ] Cek inbox dan spam
-   [ ] Cek All Mail di Gmail

### **9. Script Bantuan:**

#### **A. Test Email:**

```bash
php test-password-reset.php
```

#### **B. Test Konfigurasi:**

```bash
php test-email-simple.php
```

#### **C. Switch Provider:**

```bash
php switch-to-yahoo.php
```

## 🎯 **Hasil yang Diharapkan:**

Setelah troubleshooting:

-   ✅ Email reset password terkirim
-   ✅ User menerima email di inbox
-   ✅ User bisa reset password
-   ✅ Sistem berfungsi normal

## 📞 **Bantuan Lebih Lanjut:**

Jika masih bermasalah:

1. Cek log file: `storage/logs/laravel.log`
2. Test dengan email yang berbeda
3. Cek konfigurasi SMTP
4. Pastikan App Password Gmail benar

**Email reset password akan berfungsi setelah troubleshooting!** 🔧✅
