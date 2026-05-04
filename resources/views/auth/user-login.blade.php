<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Login - VIGATE</title>
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
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
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
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
            overflow: hidden;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header-icon {
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

        .login-header h2 {
            color: #1e293b;
            font-weight: 700;
            margin: 0 0 10px 0;
            font-size: 28px;
        }

        .login-header p {
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
        }

        .form-group input {
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.1);
            outline: none;
        }

        .form-group input::placeholder {
            color: #cbd5e1;
        }

        .error-message {
            color: #ef4444;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        .btn-login {
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
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
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

        .success-alert {
            background: #dcfce7;
            border: 1px solid #86efac;
            color: #166534;
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

        .login-footer {
            margin-top: 25px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
        }

        .login-footer p {
            color: #64748b;
            font-size: 14px;
            margin: 0 0 10px 0;
        }

        .login-footer a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .login-footer a:hover {
            color: #60a5fa;
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
            color: #3b82f6;
        }

        .login-header-icon img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(13, 110, 253, 0.15);
        }

        @media (max-width: 576px) {
            body {
                padding: 20px 0;
            }

            .login-card {
                padding: 28px 22px;
            }

            .login-header h2 {
                font-size: 24px;
            }

            .login-header p {
                font-size: 13px;
            }

            .login-header-icon {
                width: 58px;
                height: 58px;
            }

            .form-group input {
                padding: 11px 14px;
            }

            .btn-login {
                padding: 12px;
                font-size: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <div>
                    <img src="/favicon_io/android-chrome-192x192.png" alt="VIGATE logo">
                </div>
                <h2>Masuk Akun VIGATE</h2>
                <p>Masuk ke akun Anda untuk mengakses sistem VIGATE.</p>
            </div>

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

            @if(session('success'))
                <div class="success-alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('user.login') }}" method="POST">
                @csrf

                <!-- Email Input -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-control"
                        placeholder="Masukkan email anda"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        autofocus>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-control"
                        placeholder="Masukkan password anda"
                        required
                        autocomplete="current-password">
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Login Button -->
                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Masuk
                </button>
            </form>

            <!-- Footer Links -->
            <div class="login-footer">
                <p>Belum memiliki akun?</p>
                <a href="{{ route('user.register') }}">
                    <i class="bi bi-person-plus"></i>
                    Buat akun baru di sini
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
        window.addEventListener('pageshow', function(event) {
            var nav = window.performance && (window.performance.navigation || window.performance.getEntriesByType('navigation')[0]);
            var isBackForward = nav && (nav.type === 2 || nav.type === 'back_forward');
            if (event.persisted || isBackForward) {
                window.location.reload();
            }
        });

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