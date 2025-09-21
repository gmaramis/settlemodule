# WhatsApp Notification Setup Guide

Sistem notifikasi WhatsApp menggunakan Fonnte API telah berhasil diintegrasikan ke dalam aplikasi Settle Medical. Sistem ini akan mengirim notifikasi otomatis ke admin ketika mahasiswa menyelesaikan:

1. **Incident Reports** - Laporan incident baru
2. **Weekly Reflections** - Refleksi mingguan
3. **Learning Logs** - Log pembelajaran

## Fitur yang Tersedia

### 🚨 Incident Report Notification

-   Mengirim notifikasi ketika mahasiswa melaporkan incident baru
-   Informasi yang dikirim: nama mahasiswa, email, departemen, tanggal incident, tipe event, outcome, dan link review

### 📝 Weekly Reflection Notification

-   Mengirim notifikasi ketika mahasiswa submit refleksi mingguan
-   Informasi yang dikirim: nama mahasiswa, email, minggu, departemen, fokus pembelajaran, refleksi, dan link review

### 📚 Learning Log Notification

-   Mengirim notifikasi ketika mahasiswa membuat learning log baru
-   Informasi yang dikirim: nama mahasiswa, email, tanggal, departemen, topik, yang dipelajari, dan link review

## Setup dan Konfigurasi

### 1. Daftar Fonnte API

1. Kunjungi [Fonnte.com](https://fonnte.com)
2. Daftar akun dan dapatkan API Token
3. Pastikan Anda memiliki kredit yang cukup untuk mengirim pesan

### 2. Konfigurasi Environment

Tambahkan konfigurasi berikut ke file `.env`:

```env
# Fonnte WhatsApp API Configuration
FONNTE_API_TOKEN=your_fonnte_api_token_here
FONNTE_API_URL=https://api.fonnte.com/send
ADMIN_WHATSAPP_NUMBER=6281234567890
```

**Catatan Penting:**

-   `FONNTE_API_TOKEN`: Token API dari Fonnte
-   `ADMIN_WHATSAPP_NUMBER`: Nomor WhatsApp admin dalam format internasional (6281234567890)

### 3. Setup Admin WhatsApp

Jalankan command berikut untuk mengatur admin WhatsApp:

```bash
php artisan whatsapp:setup-admin
```

Atau dengan parameter langsung:

```bash
php artisan whatsapp:setup-admin --name="Admin Name" --email="admin@email.com" --phone="6281234567890"
```

### 4. Test Koneksi WhatsApp

Jalankan command test untuk memastikan koneksi berfungsi:

```bash
php artisan whatsapp:test
```

Atau test dengan nomor admin spesifik:

```bash
php artisan whatsapp:test --admin-number=6281234567890
```

## Format Pesan WhatsApp

### Incident Report

```
🚨 LAPORAN INCIDENT BARU 🚨

👤 Mahasiswa: John Doe
📧 Email: john@example.com
🏥 Departemen: Ilmu Bedah
📅 Tanggal Incident: 20/09/2025 14:30
⚠️ Tipe Event: Near Miss
📊 Outcome: No harm
📝 Deskripsi: Deskripsi singkat incident...

🔗 Link Review: http://127.0.0.1:8000/incidents/1

Dikirim dari Settle Medical System
```

### Weekly Reflection

```
📝 REFLECTION MINGGUAN BARU 📝

👤 Mahasiswa: John Doe
📧 Email: john@example.com
📅 Minggu: Week 1
🏥 Departemen: Ilmu Bedah
🎯 Fokus Pembelajaran: Fokus pembelajaran minggu ini...
💭 Refleksi: Refleksi mahasiswa...

🔗 Link Review: http://127.0.0.1:8000/weekly-reflections/1

Dikirim dari Settle Medical System
```

### Learning Log

```
📚 LEARNING LOG BARU 📚

👤 Mahasiswa: John Doe
📧 Email: john@example.com
📅 Tanggal: 20/09/2025
🏥 Departemen: Ilmu Bedah
📖 Topik: Surgical Procedures
🎯 Yang Dipelajari: Yang dipelajari mahasiswa...

🔗 Link Review: http://127.0.0.1:8000/learning-logs/1

Dikirim dari Settle Medical System
```

## File yang Dibuat/Dimodifikasi

### Service Classes

-   `app/Services/FonnteWhatsAppService.php` - Service utama untuk mengirim pesan WhatsApp

### Notification Classes

-   `app/Notifications/IncidentReportNotification.php` - Notifikasi untuk incident reports
-   `app/Notifications/WeeklyReflectionNotification.php` - Notifikasi untuk weekly reflections
-   `app/Notifications/LearningLogNotification.php` - Notifikasi untuk learning logs

### Channel Classes

-   `app/Notifications/Channels/WhatsAppChannel.php` - Channel custom untuk WhatsApp

### Model Classes

-   `app/Models/Admin.php` - Model untuk admin yang menerima notifikasi

### Controller Updates

-   `app/Http/Controllers/IncidentController.php` - Ditambahkan notifikasi setelah create incident
-   `app/Http/Controllers/WeeklyReflectionController.php` - Ditambahkan notifikasi setelah create reflection
-   `app/Http/Controllers/LearningLogController.php` - Ditambahkan notifikasi setelah create learning log

### Command Classes

-   `app/Console/Commands/TestWhatsAppNotification.php` - Command untuk test koneksi
-   `app/Console/Commands/SetupWhatsAppAdmin.php` - Command untuk setup admin

### Configuration Files

-   `config/services.php` - Konfigurasi Fonnte API
-   `app/Providers/AppServiceProvider.php` - Registrasi WhatsApp channel

### Database

-   `database/migrations/2025_09_20_051827_create_admins_table.php` - Migration untuk tabel admin

## Troubleshooting

### Error: API Token Invalid

-   Pastikan token Fonnte API sudah benar
-   Cek kredit akun Fonnte

### Error: Phone Number Invalid

-   Pastikan nomor dalam format internasional (6281234567890)
-   Pastikan nomor sudah terdaftar di WhatsApp

### Error: Notification Not Sent

-   Cek log Laravel di `storage/logs/laravel.log`
-   Pastikan queue worker berjalan jika menggunakan queue
-   Test koneksi dengan command `php artisan whatsapp:test`

### Error: Admin Not Found

-   Jalankan `php artisan whatsapp:setup-admin` untuk membuat admin
-   Atau buat admin manual di database

## Monitoring dan Logging

Sistem akan mencatat semua aktivitas notifikasi di log Laravel:

-   Sukses mengirim notifikasi
-   Error saat mengirim notifikasi
-   Response dari Fonnte API

Log dapat dilihat di `storage/logs/laravel.log`.

## Queue Support

Notifikasi menggunakan queue untuk performa yang lebih baik. Pastikan queue worker berjalan:

```bash
php artisan queue:work
```

## Security Notes

1. Jangan commit API token ke repository
2. Gunakan environment variables untuk konfigurasi sensitif
3. Batasi akses ke nomor admin WhatsApp
4. Monitor penggunaan API untuk mencegah abuse

## Support

Jika mengalami masalah dengan setup WhatsApp notification, silakan:

1. Cek dokumentasi Fonnte API
2. Periksa log aplikasi
3. Test koneksi dengan command yang disediakan
4. Hubungi support Fonnte jika masalah terkait API


