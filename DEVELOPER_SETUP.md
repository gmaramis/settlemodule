# Developer Information Setup

## Cara Mengubah Informasi Developer di Footer

Footer aplikasi menampilkan informasi developer yang dapat dikustomisasi dengan mudah. Berikut cara mengubahnya:

### 1. Menggunakan Environment Variables (.env)

Tambahkan variabel berikut ke file `.env` Anda:

```env
# Developer Information
DEVELOPER_NAME="Glenn Maramis"
DEVELOPER_TITLE="Full Stack Developer"
DEVELOPER_EMAIL="glendpm@gmail.com"
DEVELOPER_PHONE="085240543123"
DEVELOPER_WEBSITE="https://yourwebsite.com"
DEVELOPER_LINKEDIN="https://linkedin.com/in/yourprofile"
DEVELOPER_GITHUB="https://github.com/yourusername"
```

### 2. Mengubah File Konfigurasi

Atau edit langsung file `config/developer.php`:

```php
<?php

return [
    'name' => 'Glenn Maramis',
    'title' => 'Full Stack Developer',
    'email' => 'glendpm@gmail.com',
    'phone' => '085240543123',
    'website' => 'https://yourwebsite.com',
    'linkedin' => 'https://linkedin.com/in/yourprofile',
    'github' => 'https://github.com/yourusername',

    'services' => [
        'Web Development',
        'Mobile App Development',
        'System Integration',
        'Custom Solutions',
        'Database Design',
        'API Development'
    ],

    'specializations' => [
        'Laravel & PHP',
        'React & Vue.js',
        'Flutter & React Native',
        'MySQL & PostgreSQL',
        'AWS & Digital Ocean'
    ]
];
```

### 3. Fitur Footer

Footer menampilkan:

-   **Informasi Aplikasi**: Deskripsi Settle Medical
-   **Informasi Developer**: Nama, title, email, dan phone
-   **Layanan**: List layanan yang ditawarkan
-   **Tombol Hubungi**: Link email dengan subject otomatis
-   **Copyright**: Tahun dan nama developer

### 4. Customization

Anda dapat mengubah:

-   **Warna**: Edit class CSS di `resources/views/components/footer.blade.php`
-   **Layout**: Ubah struktur HTML
-   **Konten**: Tambah/ubah informasi di config
-   **Styling**: Gunakan Tailwind CSS classes

### 5. Contoh Penggunaan

Setelah mengubah informasi, footer akan menampilkan:

```
Settle Medical
Sistem manajemen klinis yang memudahkan tracking rotasi...

Developer
[Nama Anda]
Full Stack Developer
your.email@example.com
+62 812-3456-7890

Layanan
✓ Web Development
✓ Mobile App Development
✓ System Integration
✓ Custom Solutions

[Hubungi Developer] button
```

### 6. Tips Marketing

-   Gunakan email profesional
-   Sertakan nomor WhatsApp untuk kemudahan kontak
-   Tulis layanan yang spesifik dan relevan
-   Gunakan title yang menunjukkan expertise
-   Pastikan informasi kontak valid dan aktif

Footer ini akan membantu mendapatkan klien baru dari pengguna aplikasi!
