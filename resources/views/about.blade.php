@extends('layouts.main')

@section('content')
<style>
    /* =========================================
       CSS KHUSUS TENTANG KAMI (TEMA TWILIGHT)
       ========================================= */
    .about-header {
        text-align: center;
        padding: 60px 20px;
        background-color: #EAEBE6;
    }

    .about-header h1 {
        color: #3A3959;
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 15px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .about-header p {
        color: #706F8E;
        font-size: 1.2rem;
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* Section Cerita Kami */
    .story-section {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        padding: 80px 10%;
        gap: 50px;
        background-color: #ffffff;
    }

    .story-text {
        flex: 1;
        min-width: 300px;
    }

    .story-text h2 {
        color: #3A3959;
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 15px;
    }

    .story-text h2::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 80px;
        height: 4px;
        background-color: #706F8E;
        border-radius: 2px;
    }

    .story-text p {
        color: #22222E;
        font-size: 1.1rem;
        line-height: 1.8;
        margin-bottom: 20px;
    }

    .story-image {
        flex: 1;
        min-width: 300px;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(34, 34, 46, 0.15);
    }

    .story-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        aspect-ratio: 4/3;
        display: block;
    }

    /* Section Kontak & Card */
    .contact-section {
        padding: 80px 10% 40px;
        background-color: #EAEBE6;
        text-align: center;
    }

    .contact-section h2 {
        color: #3A3959;
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 50px;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
    }

    .contact-card {
        background: #ffffff;
        padding: 40px 20px;
        border-radius: 20px;
        box-shadow: 0 5px 15px rgba(34, 34, 46, 0.05);
        transition: transform 0.3s;
    }

    .contact-card:hover {
        transform: translateY(-5px);
    }

    .contact-icon {
        color: #706F8E;
        margin-bottom: 20px;
    }

    .contact-card h3 {
        color: #3A3959;
        font-size: 1.3rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .contact-card p {
        color: #22222E;
        line-height: 1.6;
    }

    /* =========================================
       CSS KHUSUS EMBED GOOGLE MAPS
       ========================================= */
    .map-section {
        background-color: #EAEBE6;
        padding: 0 10% 80px;
        text-align: center;
    }

    .map-container {
        max-width: 1000px;
        margin: 0 auto 30px;
        border-radius: 20px; /* Bikin ujung peta melengkung */
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(34, 34, 46, 0.1);
        border: 6px solid #ffffff; /* Bingkai putih agar terlihat mahal */
    }

    .map-container iframe {
        width: 100%;
        height: 450px;
        border: 0;
        display: block;
    }

    /* Style Tombol Buka di Google Maps */
    .btn-maps {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background-color: #3A3959; /* Menggunakan Deep Muted Navy */
        color: #EAEBE6 !important;
        padding: 12px 35px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: bold;
        font-size: 1.1rem;
        transition: transform 0.2s, background-color 0.2s;
        box-shadow: 0 4px 10px rgba(34, 34, 46, 0.2);
    }

    .btn-maps:hover {
        background-color: #22222E; /* Berubah jadi Dark Slate saat dihover */
        transform: scale(1.05);
    }

    /* Responsif untuk HP */
    @media (max-width: 768px) {
        .about-header h1 {
            font-size: 2.5rem;
        }
        .story-section, .contact-section, .map-section {
            padding-left: 5%;
            padding-right: 5%;
        }
        .map-container iframe {
            height: 300px; /* Peta lebih pendek di HP */
        }
    }
</style>

<!-- 1. Header -->
<div class="about-header">
    <h1>Tentang Salma</h1>
    <p>Lebih dari sekadar studio foto. Kami hadir untuk membekukan waktu dan menyimpannya dalam lembaran memori yang tak lekang oleh zaman.</p>
</div>

<!-- 2. Cerita Kami -->
<div class="story-section">
    <div class="story-text">
        <h2>Cerita Kami</h2>
        <p>
            Berawal dari sebuah passion sederhana untuk mengabadikan momen, <strong>Salma Photography</strong> kini telah berkembang menjadi salah satu studio fotografi profesional di Banjarmasin yang fokus pada kualitas, estetika, dan kepuasan pelanggan.
        </p>
        <p>
            Kami percaya bahwa setiap senyuman, tawa, dan tatapan memiliki ceritanya masing-masing. Oleh karena itu, kami merancang ruang studio yang nyaman dengan nuansa *aesthetic* kekinian, didukung oleh peralatan standar industri, agar Anda bisa mengekspresikan diri dengan bebas dan percaya diri.
        </p>
    </div>

    <div class="story-image">
        <!-- Pastikan file gambar ini ada di folder public/images kamu -->
        <img src="{{ asset('images/hero-studio.jpg') }}" alt="Studio Salma Photography">
    </div>
</div>

<!-- 3. Informasi Kontak -->
<div class="contact-section">
    <h2>Hubungi Kami</h2>

    <div class="contact-grid">
        <div class="contact-card">
            <div class="contact-icon">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg>
            </div>
            <h3>Lokasi Studio</h3>
            <!-- Teks alamat sudah di-update -->
            <p>Jl. Ahmad Yani No.5, Pemurus Dalam, Kec. Banjarmasin Sel., Kota Banjarmasin<br>Buka Setiap Hari: 09.00 - 21.00 WITA</p>
        </div>

        <div class="contact-card">
            <div class="contact-icon">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
                </svg>
            </div>
            <h3>Admin Reservasi</h3>
            <p>+62 822-5552-4446<br>Melayani konsultasi paket dan booking.</p>
        </div>

        <div class="contact-card">
            <div class="contact-icon">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/>
                </svg>
            </div>
            <h3>Instagram</h3>
            <p>@photographsalma<br>Lihat portofolio dan promo terbaru kami.</p>
        </div>
    </div>
</div>

<!-- 4. Bagian Embed Peta -->
<div class="map-section">
    <div class="map-container">
        <!-- iFrame Embed Peta sudah menunjuk ke Jl Ahmad Yani Banjarmasin -->
        <iframe src="https://maps.google.com/maps?q=Jl.%20Ahmad%20Yani%20No.5%2C%20Pemurus%20Dalam%2C%20Banjarmasin&t=&z=15&ie=UTF8&iwloc=&output=embed" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    <!-- Link tombol sudah menggunakan link yang kamu berikan -->
    <a href="https://maps.app.goo.gl/aMVuT98arzdkqUox6" target="_blank" class="btn-maps">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
        </svg>
        Buka di Google Maps
    </a>
</div>
@endsection
