<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Welcome Page</title>
    <link rel="stylesheet" href="assets/css/welcome.css" type="text/css">
</head>

<body>
    <div class="container">
        <img src="assets/images/logo.png" alt="Logo" class="logo">
        <div style="margin-top: 20px;">
            @if (Route::has('login'))
            <nav>
                @auth
                <a href="{{ url('/dashboard') }}">
                    Dashboard
                </a>
                @else
                <a href="{{ route('login') }}" class="login">
                    Log in
                </a>

                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="register">
                    Register
                </a>
                @endif
                @endauth
            </nav>
            @endif
        </div>
    </div>
</body>

</html>