<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <style>
            body {
                background: radial-gradient(circle at top, rgba(59,130,246,0.12), transparent 30%),
                            linear-gradient(180deg, #f8fafc 0%, #e2e8ff 100%);
            }

            .guest-shell {
                width: 100%;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 24px 16px;
            }

            .guest-card {
                width: 100%;
                max-width: 420px;
                background: rgba(255,255,255,0.98);
                border: 1px solid rgba(15,23,42,0.08);
                box-shadow: 0 20px 48px rgba(15,23,42,0.08);
                border-radius: 28px;
                overflow: hidden;
            }

            .guest-card-inner {
                padding: 28px 24px;
            }

            .guest-brand {
                display: flex;
                justify-content: center;
                margin-bottom: 20px;
            }

            .guest-brand img,
            .guest-brand svg {
                width: 72px;
                height: 72px;
                border-radius: 22px;
                box-shadow: 0 12px 32px rgba(15,23,42,0.08);
            }
        </style>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="/favicon_io/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon_io/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon_io/favicon-16x16.png">
        <link rel="manifest" href="/favicon_io/site.webmanifest">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="apple-mobile-web-app-title" content="VIGATE">
        <meta name="theme-color" content="#0d6efd">
        <meta name="msapplication-TileColor" content="#0d6efd">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="guest-shell">
            <div class="guest-brand">
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="guest-card">
                <div class="guest-card-inner">
                    {{ $slot }}
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
    </body>
</html>
