# 📧 Setup Email medicalsettle@gmail.com untuk Sistem Settle

## 🎯 **Email yang Sudah Dibuat: medicalsettle@gmail.com**

### **1. Pilihan Setup:**

#### **A. Gmail dengan 2FA (Recommended):**

-   ✅ **Lebih aman** dengan App Password
-   ✅ **Tidak masuk spam**
-   ✅ **Setup sekali untuk selamanya**

#### **B. Yahoo/Outlook (Tanpa 2FA):**

-   ✅ **Tidak perlu 2FA**
-   ✅ **Setup lebih cepat**
-   ✅ **Password biasa**

### **2. Setup Gmail dengan 2FA:**

#### **A. Aktifkan 2FA:**

1. **Buka**: https://myaccount.google.com/security
2. **Klik**: "2-Step Verification"
3. **Pilih**: SMS atau Authenticator app
4. **Selesaikan**: Setup 2FA

#### **B. Generate App Password:**

1. **Buka**: Google Account → Security
2. **Klik**: "App passwords"
3. **Pilih**: "Mail"
4. **Copy**: 16-character password

#### **C. Update .env:**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=medicalsettle@gmail.com
MAIL_PASSWORD=your-16-character-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="medicalsettle@gmail.com"
MAIL_FROM_NAME="Settle Medical"
```

### **3. Setup Yahoo Mail (Tanpa 2FA):**

#### **A. Buat Email Yahoo:**

1. **Buka**: https://mail.yahoo.com
2. **Buat**: medicalsettle@yahoo.com
3. **Gunakan**: Password biasa

#### **B. Update .env:**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mail.yahoo.com
MAIL_PORT=587
MAIL_USERNAME=medicalsettle@yahoo.com
MAIL_PASSWORD=your-yahoo-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="medicalsettle@yahoo.com"
MAIL_FROM_NAME="Settle Medical"
```

### **4. Setup Outlook (Tanpa 2FA):**

#### **A. Buat Email Outlook:**

1. **Buka**: https://outlook.com
2. **Buat**: medicalsettle@outlook.com
3. **Gunakan**: Password biasa

#### **B. Update .env:**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp-mail.outlook.com
MAIL_PORT=587
MAIL_USERNAME=medicalsettle@outlook.com
MAIL_PASSWORD=your-outlook-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="medicalsettle@outlook.com"
MAIL_FROM_NAME="Settle Medical"
```

### **5. Langkah-langkah Setup:**

#### **A. Gunakan Script Otomatis:**

```bash
php setup-medicalsettle-email.php
```

#### **B. Atau Manual:**

```bash
nano .env
```

#### **C. Clear Cache:**

```bash
php artisan config:clear
php artisan cache:clear
```

#### **D. Test Email:**

```bash
php test-email-simple.php
```

### **6. Hasil Email yang Diterima User:**

#### **A. Dari Gmail:**

```
From: Settle Medical <medicalsettle@gmail.com>
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

#### **B. Dari Yahoo:**

```
From: Settle Medical <medicalsettle@yahoo.com>
To: user@example.com
Subject: Reset Password Notification

[Same content as above]
```

### **7. Test Password Reset:**

#### **A. Buka Halaman Login:**

-   Kunjungi: `http://127.0.0.1:8000/login`

#### **B. Test Lupa Password:**

1. Klik: "Forgot your password?"
2. Masukkan: Email yang valid
3. Klik: "Email Password Reset Link"
4. Cek: Email inbox (dan spam folder)

### **8. Troubleshooting:**

#### **A. Gmail Error:**

-   Pastikan 2FA aktif
-   Pastikan App Password benar
-   Pastikan tidak ada spasi di App Password

#### **B. Yahoo/Outlook Error:**

-   Pastikan password benar
-   Pastikan email sudah diverifikasi
-   Coba port 465 dengan SSL

#### **C. Email tidak masuk:**

-   Cek folder spam/junk
-   Tunggu beberapa menit
-   Pastikan email address benar

### **9. Rekomendasi:**

#### **A. Untuk Development:**

-   ✅ **Yahoo/Outlook**: Setup cepat, tidak perlu 2FA

#### **B. Untuk Production:**

-   ✅ **Gmail + 2FA**: Lebih aman, tidak masuk spam

### **10. Checklist Setup:**

-   [ ] Email medicalsettle@gmail.com sudah dibuat
-   [ ] Pilih metode setup (Gmail 2FA / Yahoo / Outlook)
-   [ ] Update konfigurasi .env
-   [ ] Clear cache Laravel
-   [ ] Test email berhasil
-   [ ] Test password reset berhasil

## 🎯 **Hasil Akhir:**

Setelah setup selesai:

-   ✅ Email reset password dikirim dari "Settle Medical"
-   ✅ User menerima email yang profesional
-   ✅ Fungsi lupa password berfungsi sempurna
-   ✅ Branding sistem konsisten

**Sistem siap digunakan dengan email medicalsettle!** 🎉
