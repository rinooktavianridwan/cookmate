<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CookMate</title>
    <link rel="stylesheet" href="assets/css/welcome.css" type="text/css">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
</head>

<body>
    <div class="container">
        <img src="assets/images/logo.png" alt="Logo" class="logo">
        <div style="margin-top: 20px;">
            @if (Route::has('login'))
            <nav>
                @auth
                <a href="{{ url('/dashboard') }}" class="dashboard">
                    Dashboard
                </a>
                @else
                <a href="{{ route('login') }}" class="login">
                    Masuk
                </a>

                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="register">
                    Daftar
                </a>
                @endif
                @endauth
            </nav>
            @endif
        </div>
    </div>
</body>

</html>