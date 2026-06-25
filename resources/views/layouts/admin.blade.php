<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Salma Photography</title>

    @yield('styles')

    <style>
        /* Reset & Base Style */
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            /* Background abu-abu sangat muda biar card menonjol */
            color: #22222E;
        }

        /* ==========================================
           TOP NAVBAR DENGAN PALET UTAMA STUDIO
           ========================================== */
        .top-navbar {
            background-color: #3A3959;
            /* Warna Utama */
            color: #EAEBE6;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            height: 70px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        /* Logo / Nama Web di Kiri */
        .navbar-brand {
            font-size: 22px;
            font-weight: 800;
            color: #ffffff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: 0.5px;
        }

        /* Menu di Tengah */
        .navbar-menu {
            display: flex;
            gap: 15px;
        }

        .navbar-menu a {
            color: #EAEBE6;
            text-decoration: none;
            font-weight: 600;
            font-size: 14.5px;
            padding: 10px 18px;
            border-radius: 50px;
            /* Bentuk pil elegan */
            transition: all 0.3s ease;
        }

        /* Efek Hover & Menu Aktif pakai warna sekunder */
        .navbar-menu a:hover {
            background-color: #706F8E;
            color: #ffffff;
        }

        /* Profil & Tombol Logout di Kanan */
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-greeting {
            font-size: 14px;
            font-weight: 600;
            color: #EAEBE6;
        }

        .btn-logout {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 8px 18px;
            border-radius: 50px;
            font-weight: bold;
            font-size: 13px;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
        }

        .btn-logout:hover {
            background-color: #c0392b;
            transform: scale(1.05);
        }

        /* ==========================================
           AREA KONTEN UTAMA
           ========================================== */
        .main-content {
            max-width: 1250px;
            /* Lebar maksimal halaman */
            margin: 40px auto;
            padding: 0 20px;
            min-height: 80vh;
        }

        /* Footer Simple */
        .admin-footer {
            text-align: center;
            padding: 20px;
            color: #706F8E;
            font-size: 13px;
            margin-top: 40px;
            border-top: 1px solid #ddd;
        }

        /* ==========================================
           MODE PRINT (Menyembunyikan UI saat cetak laporan)
           ========================================== */
        @media print {

            .top-navbar,
            .admin-footer {
                display: none !important;
            }

            .main-content {
                margin: 0 !important;
                padding: 0 !important;
                max-width: 100% !important;
                background-color: white !important;
            }

            body {
                background-color: white;
            }
        }
    </style>
</head>

<body>

    <nav class="top-navbar">
        <a href="{{ route('admin.reservations.index') }}" class="navbar-brand">
            <img src="{{ asset('images/logo-salma.png') }}" alt="Logo Salma"
                style="height: 40px; width: auto; object-fit: contain; background-color: rgba(255,255,255,0.1); padding: 5px; border-radius: 8px;">
            <span style="font-family: 'Georgia', serif;">Salma Photography</span>
        </a>

        <div class="navbar-menu">
            <a href="{{ route('admin.reservations.index') }}">📋 Data Reservasi</a>
            <a href="{{ route('admin.packages.index') }}">📦 Kelola Paket</a>
            <a href="{{ route('admin.users.index') }}">👥 Kelola Akun</a>
            <a href="{{ route('admin.reservations.report') }}">📄 Laporan</a>
        </div>

        <div class="navbar-right">
            <span class="user-greeting">Halo, {{ Auth::user()->name }} 👋</span>

            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </nav>

    <main class="main-content">
        @yield('content')
    </main>

    <footer class="admin-footer">
        &copy; {{ date('Y') }} Sistem Informasi Manajemen Reservasi Salma Photography.
    </footer>

    @yield('scripts')

</body>

</html>
