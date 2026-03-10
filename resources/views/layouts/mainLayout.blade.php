<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/mainLayout.css') }}">
</head>
<body>
    <header>
        <div class="container">
            <h1>Wheely Good Cars</h1>
            <nav>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/about">About</a></li>
                    <li><a href="/contact">Contact</a></li>
                    <li><a href="/cars">Browse Cars</a></li>
                    @if (Auth::check())
                        <li><a href="/profile">Profile</a></li>
                    @else
                        <li><a href="/login">Login</a></li>
                        <li><a href="/register">Register</a></li>
                    @endif
                    <li><a href="/sell">Sell Your Car</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        <div class="container">
            <nav>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/about">About</a></li>
                    <li><a href="/contact">Contact</a></li>
                </ul>
            </nav>
            <p>&copy; 2026 Wheely Good Cars. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>