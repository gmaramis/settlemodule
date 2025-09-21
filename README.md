# 🏥 Settle Medical - Sistem Manajemen Rotasi Klinis

**Platform digital terintegrasi untuk pengelolaan rotasi klinis mahasiswa kedokteran Fakultas Kedokteran Sam Ratulangi University.**

## ✨ **Fitur Utama**

-   🎓 **Manajemen Rotasi Klinis**: Kelola jadwal rotasi dengan mudah
-   📊 **Tracking Progress**: Pantau kemajuan pembelajaran mahasiswa
-   📝 **Evaluasi Terpadu**: Sistem evaluasi komprehensif
-   👥 **Manajemen User**: Admin, mahasiswa, dan pengelolaan akun
-   📧 **Sistem Email**: Notifikasi dan password reset
-   📱 **Responsive Design**: Bekerja sempurna di semua device

## 🚀 **Quick Start**

### **Prerequisites**

-   PHP 8.1+
-   Composer
-   MySQL/PostgreSQL
-   Node.js & NPM

### **Installation**

```bash
# Clone repository
git clone <repository-url>
cd Settle

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database
# Edit .env file with your database credentials

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Start development server
php artisan serve
```

### **Access URLs**

-   **Welcome**: http://127.0.0.1:8000
-   **Login**: http://127.0.0.1:8000/login
-   **Dashboard**: http://127.0.0.1:8000/dashboard

## 🎨 **Custom Branding**

Aplikasi ini telah dikustomisasi dengan branding **Settle Medical**:

-   ✅ Logo custom: `logo_settle.jpeg`
-   ✅ Desain modern dengan gradient
-   ✅ Bahasa Indonesia
-   ✅ Responsive design
-   ✅ Custom email templates

## 📁 **Project Structure**

```
Settle/
├── app/                    # Laravel application logic
├── public/                 # Public assets
│   ├── images/
│   │   └── logos/
│   │       └── logo_settle.jpeg
│   └── favicon.ico
├── resources/
│   ├── views/              # Blade templates
│   │   ├── auth/           # Authentication pages
│   │   ├── welcome.blade.php
│   │   └── ...
│   └── css/                # Stylesheets
├── docs/                   # Documentation
│   ├── guides/             # Setup guides
│   └── tests/              # Test scripts
└── database/               # Migrations & seeders
```

## 🔧 **Configuration**

### **Email Setup**

Email menggunakan Gmail SMTP:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=medicalsettle@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

### **App Configuration**

```
APP_NAME="Settle Medical"
APP_URL=http://127.0.0.1:8000
APP_LOCALE=id
```

## 📚 **Documentation**

Lihat folder `docs/guides/` untuk panduan lengkap:

-   `COMPLETE_CUSTOMIZATION_GUIDE.md` - Panduan lengkap customisasi
-   `CUSTOM_LOGO_GUIDE.md` - Panduan logo dan branding
-   `SETUP_EMAIL_SMTP.md` - Setup email SMTP
-   Dan lainnya...

## 🧪 **Testing**

Script test tersedia di `docs/tests/`:

```bash
# Test custom logo
php docs/tests/test-custom-logo.php

# Test auth pages
php docs/tests/test-final-auth.php

# Test password reset
php docs/tests/test-custom-reset-password.php
```

## 👥 **User Roles**

-   **Admin**: Full access ke semua fitur
-   **Student**: Mahasiswa dengan akses ke rotasi klinis

## 🎯 **Screenshots**

### **Welcome Page**

-   Modern landing page dengan logo custom
-   Gradient background dan responsive design
-   Feature showcase dan call-to-action

### **Authentication Pages**

-   Login/Register dengan desain modern
-   Custom logo di semua halaman
-   Bahasa Indonesia untuk user experience

### **Dashboard**

-   Overview rotasi klinis
-   Progress tracking
-   Quick actions

## 🔒 **Security**

-   CSRF protection
-   Input validation
-   Password hashing
-   Rate limiting
-   Secure email transmission

## 📱 **Responsive Design**

-   Mobile-first approach
-   Tailwind CSS framework
-   Breakpoints: sm (640px), md (768px), lg (1024px), xl (1280px)
-   Touch-friendly interface

## 🚀 **Deployment**

### **Production Checklist**

-   [ ] Update `.env` dengan production settings
-   [ ] Set `APP_ENV=production`
-   [ ] Configure production database
-   [ ] Setup email SMTP
-   [ ] Run `php artisan config:cache`
-   [ ] Run `php artisan route:cache`
-   [ ] Run `php artisan view:cache`

### **Environment Variables**

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=your-db-name
DB_USERNAME=your-db-user
DB_PASSWORD=your-db-password

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=medicalsettle@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

## 🤝 **Contributing**

1. Fork repository
2. Create feature branch
3. Commit changes
4. Push to branch
5. Create Pull Request

## 📄 **License**

This project is proprietary software developed for Sam Ratulangi University.

## 📞 **Support**

Untuk bantuan dan dukungan:

-   Email: medicalsettle@gmail.com
-   Institusi: Fakultas Kedokteran Sam Ratulangi University

---

**© 2024 Settle Medical. Sistem Manajemen Rotasi Klinis untuk Fakultas Kedokteran Sam Ratulangi University.**


