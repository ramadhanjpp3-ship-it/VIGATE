<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Register - VIGATE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="/favicon_io/site.webmanifest">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="VIGATE">
    <meta name="theme-color" content="#0d6efd">
    <meta name="msapplication-TileColor" content="#0d6efd">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px 0;
        }

        .register-container {
            width: 100%;
            max-width: 500px;
            padding: 20px;
        }

        .register-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
            overflow: hidden;
        }

        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .register-header-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            color: white;
            font-size: 36px;
        }

        .register-header h2 {
            color: #1e293b;
            font-weight: 700;
            margin: 0 0 10px 0;
            font-size: 28px;
        }

        .register-header p {
            color: #64748b;
            font-size: 14px;
            margin: 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            color: #1e293b;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .form-group .required {
            color: #ef4444;
        }

        .form-group input {
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s ease;
            width: 100%;
        }

        .form-group input:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            outline: none;
        }

        .form-group input::placeholder {
            color: #cbd5e1;
        }

        .form-text {
            color: #64748b;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        .error-message {
            color: #ef4444;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        .error-alert {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .error-alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .error-alert li {
            margin: 5px 0;
        }

        .success-alert {
            background: #dcfce7;
            border: 1px solid #bbf7d0;
            color: #166534;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .btn-register {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-register:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        .register-footer {
            margin-top: 25px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
        }

        .register-footer p {
            color: #64748b;
            font-size: 14px;
            margin: 0 0 10px 0;
        }

        .register-footer a {
            color: #10b981;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .register-footer a:hover {
            color: #059669;
            text-decoration: underline;
        }

        .back-home {
            text-align: center;
            margin-top: 15px;
        }

        .back-home a {
            color: #64748b;
            font-size: 13px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .back-home a:hover {
            color: #10b981;
        }

        .register-header-icon img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(16, 185, 129, 0.15);
        }

        @media (max-width: 576px) {
            body {
                padding: 20px 0;
            }

            .register-card {
                padding: 28px 22px;
            }

            .register-header h2 {
                font-size: 24px;
            }

            .register-header p {
                font-size: 13px;
            }

            .register-header-icon {
                width: 58px;
                height: 58px;
            }

            .form-group input {
                padding: 11px 14px;
            }

            .btn-register {
                padding: 12px;
                font-size: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-card">
            <!-- Header -->
            <div class="register-header">
                <div>
                    <img src="/favicon_io/android-chrome-192x192.png" alt="VIGATE logo">
                </div>
                <h2>Buat Akun VIGATE</h2>
                <p>Daftar untuk mengakses sistem VIGATE.</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="success-alert">
                    <i class="bi bi-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
                <div class="error-alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Register Form -->
            <form action="{{ route('user.register.post') }}" method="POST">
                @csrf

                <!-- Name Input -->
                <div class="form-group">
                    <label for="name">Nama Lengkap <span class="required">*</span></label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="form-control @error('name') border-danger @enderror"
                        placeholder="Masukkan nama lengkap anda"
                        value="{{ old('name') }}"
                        required>
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- NIM Input -->
                <div class="form-group">
                    <label for="nim">NIM (Nomor Identitas Mahasiswa) <span class="required">*</span></label>
                    <input 
                        type="text" 
                        id="nim" 
                        name="nim" 
                        class="form-control @error('nim') border-danger @enderror"
                        placeholder="Contoh: 221401XXXX"
                        value="{{ old('nim') }}"
                        required>
                    @error('nim')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                    <span class="form-text"><i class="bi bi-info-circle"></i> NIM harus unik dan tidak boleh sama dengan yang sudah ada</span>
                </div>

                <!-- Email Input -->
                <div class="form-group">
                    <label for="email">Email Aktif <span class="required">*</span></label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-control @error('email') border-danger @enderror"
                        placeholder="contoh@email.com"
                        value="{{ old('email') }}"
                        required>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                    <span class="form-text"><i class="bi bi-info-circle"></i> Email harus aktif dan unik</span>
                </div>

                <!-- Phone Input -->
                <div class="form-group">
                    <label for="phone">Nomor HP <span class="required">*</span></label>
                    <input 
                        type="text" 
                        id="phone" 
                        name="phone" 
                        class="form-control @error('phone') border-danger @enderror"
                        placeholder="Contoh: 08123456789"
                        value="{{ old('phone') }}"
                        required>
                    @error('phone')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="form-group">
                    <label for="password">Password <span class="required">*</span></label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control @error('password') border-danger @enderror"
                        placeholder="Minimal 8 karakter"
                        required>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Confirmation Input -->
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password <span class="required">*</span></label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Masukkan ulang password"
                        required>
                </div>

                <!-- Register Button -->
                <button type="submit" class="btn-register">
                    <i class="bi bi-person-plus"></i>
                    Daftar Sekarang
                </button>
            </form>

            <!-- Footer Links -->
            <div class="register-footer">
                <p>Sudah memiliki akun?</p>
                <a href="{{ route('user.login.form') }}">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Masuk ke sini
                </a>

                <div class="back-home">
                    <a href="/">
                        <i class="bi bi-house"></i>
                        Kembali ke halaman utama
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js')
                    .then(function(registration) {
                        console.log('Service worker registered with scope:', registration.scope);
                    })
                    .catch(function(error) {
                        console.warn('Service worker registration failed:', error);
                    });
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>