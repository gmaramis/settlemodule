# 📧 Konfigurasi Email SMTP untuk Fungsi Lupa Password

## 🔧 Konfigurasi di File .env

Tambahkan atau update konfigurasi berikut di file `.env`:

```env
# ===========================================
# KONFIGURASI EMAIL SMTP
# ===========================================

# Mail Driver
MAIL_MAILER=smtp

# SMTP Configuration
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls

# Email Settings
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

## 📋 Konfigurasi untuk Provider Email Populer

### 1. Gmail SMTP

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Settle"
```

**Catatan untuk Gmail:**

-   Gunakan **App Password**, bukan password biasa
-   Aktifkan 2-Factor Authentication
-   Generate App Password di: Google Account → Security → App passwords

### 2. Yahoo SMTP

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mail.yahoo.com
MAIL_PORT=587
MAIL_USERNAME=your-email@yahoo.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@yahoo.com
MAIL_FROM_NAME="Settle"
```

### 3. Outlook/Hotmail SMTP

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp-mail.outlook.com
MAIL_PORT=587
MAIL_USERNAME=your-email@outlook.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@outlook.com
MAIL_FROM_NAME="Settle"
```

### 4. Custom SMTP (Hosting)

```env
MAIL_MAILER=smtp
MAIL_HOST=mail.yourdomain.com
MAIL_PORT=587
MAIL_USERNAME=noreply@yourdomain.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="Settle"
```

## 🚀 Langkah-langkah Setup

### 1. Update File .env

```bash
# Edit file .env
nano .env

# Atau buka dengan editor favorit
code .env
```

### 2. Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
```

### 3. Test Email

```bash
# Test email dengan tinker
php artisan tinker

# Di dalam tinker:
Mail::raw('Test email', function ($message) {
    $message->to('test@example.com')->subject('Test Email');
});
```

### 4. Test Password Reset

1. Buka halaman login: `http://127.0.0.1:8000/login`
2. Klik "Forgot your password?"
3. Masukkan email yang valid
4. Cek email untuk reset link

## 🔍 Troubleshooting

### Error: "Connection could not be established"

-   Periksa `MAIL_HOST` dan `MAIL_PORT`
-   Pastikan firewall tidak memblokir port 587/465
-   Coba gunakan `MAIL_ENCRYPTION=ssl` untuk port 465

### Error: "Authentication failed"

-   Periksa `MAIL_USERNAME` dan `MAIL_PASSWORD`
-   Untuk Gmail, gunakan App Password
-   Pastikan 2FA aktif untuk Gmail

### Error: "Connection timeout"

-   Periksa koneksi internet
-   Coba port alternatif (465 untuk SSL)
-   Periksa setting firewall

## 📧 Template Email Custom

Untuk custom template email, buat file di:

```
resources/views/emails/password-reset.blade.php
```

Contoh template:

```html
<!DOCTYPE html>
<html>
    <head>
        <title>Reset Password</title>
    </head>
    <body>
        <h1>Reset Password</h1>
        <p>Klik link berikut untuk reset password:</p>
        <a href="{{ $resetUrl }}">Reset Password</a>
        <p>Link ini berlaku selama 60 menit.</p>
    </body>
</html>
```

## ✅ Checklist Konfigurasi

-   [ ] File `.env` sudah diupdate
-   [ ] Cache sudah di-clear
-   [ ] Email credentials sudah benar
-   [ ] Test email berhasil
-   [ ] Test password reset berhasil
-   [ ] Email template sudah sesuai (opsional)

## 🎯 Hasil Akhir

Setelah konfigurasi selesai:

1. User bisa klik "Forgot your password?" di halaman login
2. User memasukkan email
3. Email reset password terkirim
4. User klik link di email
5. User bisa reset password
6. User login dengan password baru

**Fungsi lupa password akan berfungsi dengan sempurna!** 🎉
