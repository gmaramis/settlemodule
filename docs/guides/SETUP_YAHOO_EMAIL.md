# 📧 Setup Email Yahoo untuk Settle (Tanpa 2FA)

## 🎯 **Alternatif Setup Email Tanpa 2FA**

### **1. Buat Email Yahoo:**

#### **A. Buka Yahoo Mail:**

-   Kunjungi: https://mail.yahoo.com
-   Klik: "Sign up"

#### **B. Pilih Nama Email:**

```
settle.medical@yahoo.com
settle.clinic@yahoo.com
settle.rotation@yahoo.com
settle.university@yahoo.com
```

#### **C. Lengkapi Form:**

-   **First name**: Settle
-   **Last name**: Medical
-   **Email**: settle.medical@yahoo.com
-   **Password**: Buat password yang kuat
-   **Phone**: Masukkan nomor HP

### **2. Update Konfigurasi .env**

#### **A. Buka File .env:**

```bash
nano .env
```

#### **B. Ganti Konfigurasi Email:**

```env
MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=smtp.mail.yahoo.com
MAIL_PORT=587
MAIL_USERNAME=settle.medical@yahoo.com
MAIL_PASSWORD=your-yahoo-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="settle.medical@yahoo.com"
MAIL_FROM_NAME="Settle Medical"
```

### **3. Clear Cache dan Test**

```bash
php artisan config:clear
php artisan cache:clear
php test-email-simple.php
```

### **4. Hasil Email:**

```
From: Settle Medical <settle.medical@yahoo.com>
To: user@example.com
Subject: Reset Password Notification

Hello!

You are receiving this email because we received a password reset request for your account.

Reset Password

This password reset link will expire in 60 minutes.

If you did not request a password reset, no further action is required.

Regards,
Settle Medical
```

## ✅ **Keuntungan Yahoo Mail:**

-   ✅ Tidak perlu 2FA
-   ✅ Setup lebih cepat
-   ✅ Password biasa bisa digunakan
-   ✅ Email profesional

## 🎯 **Hasil Akhir:**

Email reset password akan dikirim dari "Settle Medical" menggunakan Yahoo Mail tanpa perlu 2FA!
