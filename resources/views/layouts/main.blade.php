<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salma Photography</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #EAEBE6;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navbar */
        .navbar {
            background-color: #EAEBE6;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(34, 34, 46, 0.08);
            position: relative;
            z-index: 1000;
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: #3A3959;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-links { display: flex; align-items: center; }
        .nav-links a {
            margin-left: 20px;
            text-decoration: none;
            color: #22222E;
            font-weight: 600;
            transition: color 0.3s;
        }
        .nav-links a:hover { color: #706F8E; }

        /* Buttons */
        .btn-primary {
            background-color: #3A3959;
            color: #EAEBE6 !important;
            padding: 10px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-primary:hover { background-color: #706F8E; transform: scale(1.05); }

        .btn-danger {
            background-color: #706F8E;
            color: #EAEBE6;
            padding: 10px 20px;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-danger:hover { background-color: #22222E; }

        /* Content & Footer */
        .container { max-width: 1100px; margin: 40px auto; padding: 0 20px; flex: 1; width: 100%; box-sizing: border-box; }
        .footer {
            background-color: #3A3959;
            color: #ADA9BA;
            padding: 50px 20px 30px;
            text-align: center;
            margin-top: auto;
        }

        /* Responsive */
        .menu-toggle { display: none; font-size: 28px; cursor: pointer; }
        @media (max-width: 768px) {
            .menu-toggle { display: block; }
            .nav-links {
                display: none; flex-direction: column; position: absolute; top: 100%; left: 0;
                width: 100%; background-color: #EAEBE6; padding: 20px 0; box-shadow: 0 5px 10px rgba(0,0,0,0.1);
            }
            .nav-links.active { display: flex; }
            .nav-links a { margin: 15px 0; }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <a href="{{ route('home') }}" class="navbar-brand">
            <img src="{{ asset('images/logo-salma.png') }}" alt="Logo" style="height: 50px;">
            Salma Photography
        </a>

        <div class="menu-toggle" id="mobile-menu">&#9776;</div>

        <div class="nav-links" id="nav-links">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('catalog') }}">Katalog Paket</a>
            <a href="{{ route('about') }}">Tentang Kami</a>

            @auth
                @if (Auth::user()->role == 'admin')
                    <a href="{{ route('admin.reservations.index') }}">Dashboard Admin</a>
                @else
                    <a href="{{ route('reservations.index') }}">Riwayat Pesanan Saya</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" style="margin-left: 20px;">
                    @csrf
                    <button type="submit" class="btn-danger">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-primary" style="margin-left: 20px;">Login / Register</a>
            @endauth
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <footer class="footer">
        <div>&copy; {{ date('Y') }} Salma Photography. Sistem Informasi Manajemen Reservasi.</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const menuToggle = document.getElementById('mobile-menu');
        const navLinks = document.getElementById('nav-links');
        menuToggle.addEventListener('click', () => navLinks.classList.toggle('active'));
    </script>
</body>
</html>
