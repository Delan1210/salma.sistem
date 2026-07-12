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
            padding: 40px 20px 30px;
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

        /* Social Icons Footer (Tanpa Background) */
        .social-footer {
            display: flex;
            justify-content: center;
            gap: 25px;
            margin-bottom: 20px;
        }

        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ADA9BA; /* Warna awal senada dengan teks footer */
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-icon svg {
            width: 26px; /* Icon sedikit dibesarkan karena tidak ada background box */
            height: 26px;
        }

        .social-icon:hover {
            color: #ffffff; /* Menyala putih saat disentuh */
            transform: translateY(-3px) scale(1.1);
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
        <!-- SVG Social Media Icons (Transparent Background) -->
        <div class="social-footer">
            <!-- Icon WhatsApp -->
            <a href="https://wa.me/6282255524446" target="_blank" class="social-icon" title="WhatsApp Salma Studio">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
                </svg>
            </a>

            <!-- Icon Instagram -->
            <a href="https://instagram.com/photographsalma" target="_blank" class="social-icon" title="Instagram Salma Studio">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/>
                </svg>
            </a>

            <!-- Icon TikTok -->
            <a href="https://www.tiktok.com/@photographsalma?lang=en-GB&is_from_webapp=1&sender_device=mobile&sender_web_id=7661593189371479553" target="_blank" class="social-icon" title="TikTok Salma Studio">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                </svg>
            </a>
        </div>

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
