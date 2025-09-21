<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Developer Information
    |--------------------------------------------------------------------------
    |
    | Informasi developer yang akan ditampilkan di footer aplikasi.
    | Silakan ubah sesuai dengan informasi Anda.
    |
    */

    'name' => env('DEVELOPER_NAME', 'Glenn Maramis'),
    'title' => env('DEVELOPER_TITLE', 'Full Stack Developer'),
    'email' => env('DEVELOPER_EMAIL', 'glendpm@gmail.com'),
    'phone' => env('DEVELOPER_PHONE', '085240543123'),
    'website' => env('DEVELOPER_WEBSITE', 'https://yourwebsite.com'),
    'linkedin' => env('DEVELOPER_LINKEDIN', 'https://linkedin.com/in/yourprofile'),
    'github' => env('DEVELOPER_GITHUB', 'https://github.com/yourusername'),
    
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
