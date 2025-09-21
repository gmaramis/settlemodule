<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Settle Medical</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }
        .logo {
            width: 60px;
            height: 60px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
        }
        .content {
            padding: 40px 30px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 20px;
            text-align: center;
        }
        .message {
            font-size: 16px;
            color: #6b7280;
            margin-bottom: 30px;
            text-align: center;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #059669 0%, #2563eb 100%);
            color: white;
            text-decoration: none;
            padding: 16px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            margin: 20px auto;
            display: block;
            width: fit-content;
            transition: all 0.3s ease;
        }
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(5, 150, 105, 0.3);
        }
        .info-box {
            background-color: #f3f4f6;
            border-left: 4px solid #2563eb;
            padding: 20px;
            margin: 30px 0;
            border-radius: 0 8px 8px 0;
        }
        .info-title {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 10px;
        }
        .info-text {
            color: #6b7280;
            font-size: 14px;
        }
        .footer {
            background-color: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer-text {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .footer-links {
            margin-top: 20px;
        }
        .footer-links a {
            color: #2563eb;
            text-decoration: none;
            margin: 0 10px;
            font-size: 14px;
        }
        .security-notice {
            background-color: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }
        .security-notice strong {
            color: #92400e;
        }
        .security-notice p {
            color: #92400e;
            font-size: 14px;
            margin: 0;
        }
        @media (max-width: 600px) {
            .container {
                margin: 0;
                border-radius: 0;
            }
            .header, .content, .footer {
                padding: 20px;
            }
            .title {
                font-size: 20px;
            }
            .button {
                width: 100%;
                box-sizing: border-box;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">🏥</div>
            <h1 style="margin: 0; font-size: 28px; font-weight: 700;">Settle Medical</h1>
            <p style="margin: 10px 0 0; font-size: 16px; opacity: 0.9;">Sistem Manajemen Rotasi Klinis</p>
        </div>

        <!-- Content -->
        <div class="content">
            <h2 class="title">Reset Password Anda</h2>
            
            <p class="message">
                Halo! Kami menerima permintaan untuk mereset password akun Settle Medical Anda.
                Klik tombol di bawah ini untuk membuat password baru.
            </p>

            <!-- Reset Button -->
            <a href="{{ $actionUrl }}" class="button">
                🔐 Reset Password
            </a>

            <!-- Info Box -->
            <div class="info-box">
                <div class="info-title">📧 Informasi Akun</div>
                <div class="info-text">
                    <strong>Email:</strong> {{ $email }}<br>
                    <strong>Tanggal Permintaan:</strong> {{ now()->format('d F Y, H:i') }}<br>
                    <strong>Link Berlaku:</strong> 60 menit
                </div>
            </div>

            <!-- Security Notice -->
            <div class="security-notice">
                <strong>🔒 Perhatian Keamanan</strong>
                <p>Jika Anda tidak meminta reset password ini, abaikan email ini. Password Anda tidak akan berubah.</p>
            </div>

            <!-- Alternative Link -->
            <div style="background-color: #f8fafc; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <p style="margin: 0 0 10px; font-size: 14px; color: #6b7280;">
                    <strong>Link tidak berfungsi?</strong> Salin dan tempel link berikut ke browser Anda:
                </p>
                <p style="margin: 0; font-size: 12px; color: #9ca3af; word-break: break-all;">
                    {{ $actionUrl }}
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="footer-text">
                <strong>Settle Medical</strong><br>
                Sistem Manajemen Rotasi Klinis untuk Fakultas Kedokteran
            </p>
            
            <div class="footer-links">
                <a href="{{ config('app.url') }}">Website</a>
                <a href="{{ config('app.url') }}/login">Login</a>
                <a href="mailto:medicalsettle@gmail.com">Support</a>
            </div>

            <p style="color: #9ca3af; font-size: 12px; margin-top: 20px;">
                © {{ date('Y') }} Settle Medical. Email ini dikirim otomatis, mohon tidak membalas.
            </p>
        </div>
    </div>
</body>
</html>


