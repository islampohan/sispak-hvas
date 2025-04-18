<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pakar HVAS</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#6777ef">
    <!-- Material Dashboard CSS -->
    <link rel="stylesheet" href="{{ asset('css/material-dashboard.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(60deg, #ab47bc, #7b1fa2);
            height: 100vh;
            margin: 0;
            color: #fff;
        }
        .landing-container {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 0 20px;
        }
        .buttons {
            margin-top: 30px;
        }
        .title {
            font-size: 3.5rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .description {
            font-size: 1.5rem;
            max-width: 800px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="landing-container">
        <h1 class="title">Sistem Pakar HVAS</h1>
        <p class="description">
            Sistem pakar untuk identifikasi kesalahan pada High Volume Air Sampler
            menggunakan metode forward chaining
        </p>

        <div class="buttons">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-lg btn-info">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-lg btn-success">Login</a>
                @endauth
            @endif
        </div>
    </div>

    <!-- Core JavaScript -->
    <script src="{{ asset('js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('js/core/popper.min.js') }}"></script>
    <script src="{{ asset('js/core/bootstrap-material-design.min.js') }}"></script>

    <!-- Service Worker for PWA -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/service-worker.js')
                    .then(function(registration) {
                        console.log('ServiceWorker registration successful');
                    }, function(err) {
                        console.log('ServiceWorker registration failed: ', err);
                    });
            });
        }
    </script>
</body>
</html>
