# 📧 Setup Email SMTP untuk Fungsi Lupa Password

## 🔍 **Masalah Saat Ini:**

-   ✅ Email reset password **berfungsi** (tersimpan di log file)
-   ❌ Email **tidak terkirim** ke inbox karena menggunakan `MAIL_MAILER=log`
-   ❌ Perlu konfigurasi SMTP untuk mengirim email asli

## 🔧 **Solusi - Konfigurasi SMTP:**

### **1. Edit File .env**

```bash
# Buka file .env
nano .env
# atau
code .env
```

### **2. Ganti Konfigurasi Email**

**Ganti dari:**

```env
MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

**Menjadi (contoh Gmail):**

```env
MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### **3. Pilihan SMTP Provider:**

#### **A. Gmail SMTP (Recommended):**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email@gmail.com"
MAIL_FROM_NAME="Settle"
```

**Setup Gmail:**

1. Aktifkan 2-Factor Authentication
2. Generate App Password: Google Account → Security → App passwords
3. Gunakan App Password (bukan password biasa)

#### **B. Yahoo SMTP:**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mail.yahoo.com
MAIL_PORT=587
MAIL_USERNAME=your-email@yahoo.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email@yahoo.com"
MAIL_FROM_NAME="Settle"
```

#### **C. Outlook/Hotmail SMTP:**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp-mail.outlook.com
MAIL_PORT=587
MAIL_USERNAME=your-email@outlook.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email@outlook.com"
MAIL_FROM_NAME="Settle"
```

### **4. Clear Cache Setelah Update:**

```bash
php artisan config:clear
php artisan cache:clear
```

### **5. Test Email:**

```bash
# Test dengan script
php test-email.php

# Atau test manual
php artisan tinker
```

Di dalam tinker:

```php
Mail::raw('Test email', function ($message) {
    $message->to('your-email@example.com')->subject('Test Email');
});
```

### **6. Test Password Reset:**

1. Buka: `http://127.0.0.1:8000/login`
2. Klik: "Forgot your password?"
3. Masukkan: Email yang valid
4. Cek: Email inbox (dan spam folder)

## 🚨 **Troubleshooting:**

### **Error: "Connection could not be established"**

-   Periksa `MAIL_HOST` dan `MAIL_PORT`
-   Pastikan firewall tidak memblokir port 587/465
-   Coba gunakan `MAIL_ENCRYPTION=ssl` untuk port 465

### **Error: "Authentication failed"**

-   Periksa `MAIL_USERNAME` dan `MAIL_PASSWORD`
-   Untuk Gmail: gunakan App Password (bukan password biasa)
-   Pastikan 2FA aktif untuk Gmail

### **Error: "Connection timeout"**

-   Periksa koneksi internet
-   Coba port alternatif (465 untuk SSL)
-   Periksa setting firewall

### **Email tidak masuk inbox:**

-   Cek folder spam/junk
-   Pastikan email address benar
-   Tunggu beberapa menit (email bisa delay)

## ✅ **Verifikasi Setup:**

### **1. Cek Konfigurasi:**

```bash
php artisan tinker --execute="echo 'MAIL_MAILER: ' . env('MAIL_MAILER'); echo 'MAIL_HOST: ' . env('MAIL_HOST');"
```

### **2. Test Email:**

```bash
php test-email.php
```

### **3. Test Password Reset:**

-   Coba lupa password dengan email yang valid
-   Cek email inbox untuk reset link

## 🎯 **Hasil Akhir:**

Setelah setup selesai:

-   ✅ Email reset password akan terkirim ke inbox
-   ✅ User bisa klik link reset di email
-   ✅ User bisa reset password
-   ✅ User bisa login dengan password baru

## 📞 **Bantuan:**

Jika masih ada masalah, cek:

1. Log file: `storage/logs/laravel.log`
2. Email provider settings
3. Firewall/network settings
4. App password untuk Gmail

**Fungsi lupa password akan berfungsi sempurna setelah setup SMTP!** 🎉
