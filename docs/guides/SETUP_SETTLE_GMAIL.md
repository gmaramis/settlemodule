# 📧 Setup Email Gmail "Settle" untuk Sistem

## 🎯 **Langkah-langkah Membuat Email Gmail Settle**

### **1. Buat Email Gmail Baru**

#### **A. Buka Gmail:**

-   Kunjungi: https://gmail.com
-   Klik: "Create account"

#### **B. Pilih Nama Email:**

**Rekomendasi nama email:**

```
settle.medical@gmail.com
settle.clinic@gmail.com
settle.rotation@gmail.com
settle.university@gmail.com
settle.medical.rotation@gmail.com
```

#### **C. Lengkapi Form:**

-   **First name**: Settle
-   **Last name**: Medical
-   **Username**: settle.medical (atau pilihan lain)
-   **Password**: Buat password yang kuat
-   **Phone**: Masukkan nomor HP untuk verifikasi
-   **Recovery email**: Email alternatif (opsional)

### **2. Aktifkan 2-Factor Authentication**

#### **A. Buka Google Account:**

1. Klik avatar di Gmail
2. Pilih: "Manage your Google Account"
3. Klik: "Security"

#### **B. Aktifkan 2-Step Verification:**

1. Klik: "2-Step Verification"
2. Klik: "Get started"
3. Masukkan password
4. Pilih metode verifikasi (SMS atau Authenticator app)
5. Selesaikan setup

### **3. Generate App Password**

#### **A. Buka App Passwords:**

1. Di halaman Security
2. Klik: "App passwords"
3. Masukkan password Gmail

#### **B. Generate Password:**

1. Pilih app: "Mail"
2. Pilih device: "Other (custom name)"
3. Masukkan: "Settle Medical System"
4. Klik: "Generate"
5. **Copy 16-character password** (contoh: `abcd efgh ijkl mnop`)

### **4. Update Konfigurasi .env**

#### **A. Buka File .env:**

```bash
nano .env
# atau
code .env
```

#### **B. Ganti Konfigurasi Email:**

```env
# Ganti dari:
MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

# Menjadi:
MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=settle.medical@gmail.com
MAIL_PASSWORD=abcd efgh ijkl mnop
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="settle.medical@gmail.com"
MAIL_FROM_NAME="Settle Medical"
```

**Catatan:** Ganti `settle.medical@gmail.com` dengan email yang Anda buat, dan `abcd efgh ijkl mnop` dengan App Password yang Anda generate.

### **5. Clear Cache Laravel**

```bash
php artisan config:clear
php artisan cache:clear
```

### **6. Test Email**

#### **A. Test dengan Script:**

```bash
php test-email-simple.php
```

#### **B. Test Manual:**

```bash
php artisan tinker
```

Di dalam tinker:

```php
Mail::raw('Test email from Settle Medical', function ($message) {
    $message->to('your-email@example.com')->subject('Test from Settle');
});
```

### **7. Test Password Reset**

#### **A. Buka Halaman Login:**

-   Kunjungi: `http://127.0.0.1:8000/login`

#### **B. Test Lupa Password:**

1. Klik: "Forgot your password?"
2. Masukkan: Email yang valid
3. Klik: "Email Password Reset Link"
4. Cek: Email inbox (dan spam folder)

### **8. Hasil yang Diharapkan**

#### **A. Email Test:**

```
From: Settle Medical <settle.medical@gmail.com>
To: your-email@example.com
Subject: Test from Settle
Content: Test email from Settle Medical
```

#### **B. Email Reset Password:**

```
From: Settle Medical <settle.medical@gmail.com>
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

## 🚨 **Troubleshooting**

### **Error: "Authentication failed"**

-   Pastikan menggunakan App Password (bukan password biasa)
-   Pastikan 2FA sudah aktif
-   Pastikan App Password benar (16 karakter)

### **Error: "Connection could not be established"**

-   Periksa `MAIL_HOST=smtp.gmail.com`
-   Periksa `MAIL_PORT=587`
-   Pastikan `MAIL_ENCRYPTION=tls`

### **Email tidak masuk inbox:**

-   Cek folder spam/junk
-   Tunggu beberapa menit
-   Pastikan email address benar

## ✅ **Checklist Setup**

-   [ ] Email Gmail "Settle" dibuat
-   [ ] 2-Factor Authentication aktif
-   [ ] App Password di-generate
-   [ ] File .env di-update
-   [ ] Cache Laravel di-clear
-   [ ] Test email berhasil
-   [ ] Test password reset berhasil

## 🎯 **Hasil Akhir**

Setelah setup selesai:

-   ✅ Email reset password dikirim dari "Settle Medical"
-   ✅ User menerima email yang profesional
-   ✅ Fungsi lupa password berfungsi sempurna
-   ✅ Branding sistem konsisten

**Sistem siap digunakan dengan email profesional!** 🎉
