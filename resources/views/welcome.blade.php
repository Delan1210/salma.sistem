@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    /* ==========================================
       ANIMASI GLOBAL & KESELURUHAN
       ========================================== */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }

    .section-title {
        color: #3A3959; font-size: 2.8rem; font-weight: 800; margin-bottom: 10px;
        letter-spacing: -0.5px;
    }
    .section-subtitle {
        color: #706F8E; font-size: 1.15rem; margin-bottom: 40px; font-weight: 500;
    }

    /* ==========================================
       HERO BANNER & PENGUMUMAN STUDIO
       ========================================== */
    .hero-banner {
        position: relative; width: 100%; min-height: 85vh;
        border-radius: 30px; overflow: hidden;
        display: flex; align-items: center; justify-content: center;
        margin-top: -10px; box-shadow: 0 20px 50px rgba(34, 34, 46, 0.15);
    }
    .hero-bg {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background-image: url('{{ asset("images/merged.gif") }}');
        background-size: cover; background-position: center; z-index: 1;
    }
    .hero-overlay {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(135deg, rgba(34, 34, 46, 0.9) 0%, rgba(58, 57, 89, 0.6) 100%);
        z-index: 2;
    }
    .hero-content {
        position: relative; z-index: 3; text-align: center; color: #EAEBE6;
        padding: 20px; width: 100%; max-width: 800px;
    }
    .hero-title {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 4.2rem; font-weight: 900; margin: 0 0 10px 0;
        text-shadow: 0 10px 20px rgba(0,0,0,0.3); letter-spacing: -1px;
    }
    .hero-subtitle {
        font-size: 1.3rem; font-weight: 500; margin-bottom: 40px; color: #dcdde1; letter-spacing: 3px;
    }

    /* Glassmorphism Floating Box */
    .announcement-box {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.15); border-top: 1px solid rgba(255, 255, 255, 0.3);
        padding: 40px; border-radius: 24px; display: inline-block; text-align: left;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        animation: float 6s ease-in-out infinite;
    }
    .announce-title {
        font-size: 1.3rem; font-weight: 800; text-align: center; margin: 0 0 25px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.15); padding-bottom: 15px; color: #ffffff;
    }
    .schedule-grid { display: grid; grid-template-columns: auto 1fr; gap: 15px 25px; font-size: 1.1rem; }
    .schedule-label { font-weight: 600; color: #EAEBE6; }
    .schedule-time { color: #f1c40f; font-weight: 800; }
    .location-info {
        margin-top: 30px; text-align: center; font-size: 1rem; color: #dcdde1;
        line-height: 1.6; font-weight: 500; background: rgba(0,0,0,0.2); padding: 15px; border-radius: 12px;
    }

    /* ==========================================
       SECTION PAKET FAVORIT
       ========================================== */
    .home-featured-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px; max-width: 1200px; margin: 0 auto; padding: 20px;
    }
    .home-package-card {
        background: #ffffff; border-radius: 24px; overflow: hidden;
        box-shadow: 0 10px 30px rgba(58, 57, 89, 0.05); display: flex; flex-direction: column;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(173, 169, 186, 0.15);
    }
    .home-package-card:hover { transform: translateY(-12px); box-shadow: 0 20px 40px rgba(58, 57, 89, 0.12); }
    .home-img-wrapper { width: 100%; height: 220px; overflow: hidden; }
    .home-package-img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform 0.5s ease;
    }
    .home-package-card:hover .home-package-img { transform: scale(1.08); }

    .home-package-body { padding: 25px; display: flex; flex-direction: column; flex: 1; position: relative; }
    .home-package-title { color: #3A3959; font-size: 1.4rem; font-weight: 800; margin: 0 0 5px 0; }
    .home-package-price { color: #27ae60; font-weight: 800; font-size: 1.2rem; margin-bottom: 10px; }

    .home-favorite-badge {
        position: absolute; top: -15px; right: 20px;
        background: linear-gradient(135deg, #ff7675, #e74c3c); color: white;
        padding: 6px 16px; border-radius: 50px; font-weight: 800; font-size: 0.75rem;
        box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3); border: 2px solid #fff;
    }

    .home-btn-book {
        background: #3A3959; color: white; padding: 12px; border-radius: 50px;
        text-decoration: none; font-weight: bold; text-align: center;
        display: block; transition: 0.3s; margin-top: auto;
    }
    .home-btn-book:hover { background: #706F8E; box-shadow: 0 5px 15px rgba(112, 111, 142, 0.3); }

    /* ==========================================
       SECTION KALENDER (Anti-Benjot)
       ========================================== */
    .calendar-wrapper {
        background: #ffffff; max-width: 800px; margin: 0 auto;
        padding: 40px; border-radius: 30px; box-shadow: 0 20px 50px rgba(34, 34, 46, 0.05);
        border: 1px solid rgba(173, 169, 186, 0.2);
    }
    .flatpickr-calendar {
        background: #ffffff !important;
        border: none !important;
        box-shadow: 0 10px 40px rgba(34, 34, 46, 0.08) !important;
        border-radius: 20px !important;
        padding: 15px !important;
        width: 340px !important; /* Mengunci ukuran agar tidak gepeng */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0 auto;
    }
    .flatpickr-month { color: #3A3959 !important; font-weight: 800; margin-bottom: 10px; }
    .flatpickr-current-month .flatpickr-monthDropdown-months,
    .flatpickr-current-month input.cur-year { font-weight: 800 !important; font-size: 1.2rem; }
    .flatpickr-prev-month svg, .flatpickr-next-month svg { fill: #3A3959 !important; }
    span.flatpickr-weekday { color: #706F8E !important; font-weight: 800; font-size: 0.9rem; }
    .flatpickr-day { border-radius: 12px !important; color: #22222E; font-weight: 600; margin: 2px !important; transition: transform 0.2s; }
    .flatpickr-day:hover { transform: scale(1.1); }
    .flatpickr-day.today { background: #ADA9BA !important; border-color: #ADA9BA !important; color: #ffffff !important; }
    .flatpickr-day.fully-booked { background-color: #ffe8e8 !important; color: #e74c3c !important; text-decoration: line-through; font-weight: 800; border-color: transparent !important; }
    .flatpickr-day.partially-booked { background-color: #fff3cd !important; color: #d35400 !important; font-weight: 800; border-color: #ffeeba !important; }

    /* ==========================================
       SECTION MENGAPA KAMI
       ========================================== */
    .feature-card {
        flex: 1; min-width: 260px; background: #ffffff; padding: 40px 30px;
        border-radius: 24px; box-shadow: 0 10px 30px rgba(34, 34, 46, 0.05);
        border: 1px solid rgba(173,169,186,0.15); text-align: center;
        transition: transform 0.3s ease;
    }
    .feature-card:hover { transform: translateY(-10px); border-color: #3A3959; }
    .feature-icon-wrapper {
        width: 80px; height: 80px; background: rgba(58, 57, 89, 0.08);
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        font-size: 2rem; margin: 0 auto 20px; transition: transform 0.3s;
    }
    .feature-card:hover .feature-icon-wrapper { transform: scale(1.1) rotate(5deg); background: #3A3959; color: white; }

    /* ==========================================
       GALERI INSPIRASI
       ========================================== */
    .galeri-inspirasi {
        display: flex; flex-wrap: wrap; align-items: center; padding: 80px 5%;
        gap: 60px; background-color: #ffffff; border-radius: 30px;
        box-shadow: 0 20px 50px rgba(34, 34, 46, 0.05); margin-top: 60px;
    }
    .galeri-text { flex: 1; min-width: 300px; }
    .galeri-text p { font-size: 1.15rem; color: #706F8E; margin-bottom: 35px; line-height: 1.7; }
    .btn-inspirasi {
        display: inline-flex; align-items: center; gap: 10px;
        background-color: #3A3959; color: #ffffff !important; padding: 16px 40px;
        border-radius: 50px; text-decoration: none; font-weight: 800; font-size: 1.1rem;
        transition: all 0.3s; box-shadow: 0 10px 20px rgba(58, 57, 89, 0.2);
    }
    .btn-inspirasi:hover { transform: translateY(-5px); background-color: #22222E; box-shadow: 0 15px 25px rgba(34, 34, 46, 0.3); }

    .galeri-grid { flex: 1; min-width: 300px; display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: center; }
    .galeri-item { width: 100%; overflow: hidden; border-radius: 20px; box-shadow: 0 10px 20px rgba(34, 34, 46, 0.1); }
    .galeri-item img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); aspect-ratio: 4/5; display: block; }
    .galeri-item:hover img { transform: scale(1.1); }

    .galeri-grid .galeri-item:nth-child(even) { transform: translateY(30px); }

    @media (max-width: 768px) {
        .hero-title { font-size: 2.8rem; }
        .galeri-inspirasi { padding: 50px 20px; text-align: center; }
        .schedule-grid { grid-template-columns: 1fr; gap: 5px; text-align: center; }
        .schedule-label { margin-top: 10px; }
        .galeri-grid .galeri-item:nth-child(even) { transform: translateY(0); }
    }
</style>

<div class="hero-banner">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>

    <div class="hero-content">
        <h1 class="hero-title">WE ARE OPEN</h1>
        <div class="hero-subtitle">SALMA DIGITAL STUDIO</div>

        <div class="announcement-box">
            <h3 class="announce-title">JAM OPERASIONAL KAMI</h3>

            <div class="schedule-grid">
                <div class="schedule-label">🗓️ Buka Setiap Hari:</div>
                <div class="schedule-time">09.00 Pagi - 09.00 Malam</div>

                <div class="schedule-label">🕌 Khusus Jum'at:</div>
                <div class="schedule-time">
                    09.00 Pagi - 12.00 Siang<br>
                    02.00 Siang - 09.00 Malam
                </div>
            </div>

            <div class="location-info">
                📍 Jl. A. Yani Km. 5,700 No. 55A Banjarmasin<br>
                📞 0822-5552-4446 &nbsp;|&nbsp; 📸 @photographsalma
            </div>
        </div>
    </div>
</div>

<!-- ==========================================
     SECTION PAKET FAVORIT (3 ITEM)
     ========================================== -->
<div style="padding: 80px 20px; background-color: #FAF9F5; margin: 0 -20px 60px -20px; border-radius: 40px;">
    <div style="text-align: center; margin-bottom: 50px;">
        <h2 class="section-title">Pilihan Favorit Pelanggan</h2>
        <p class="section-subtitle">Paket terlaris yang paling sering dipesan untuk mengabadikan momen spesial.</p>
    </div>

    <div class="home-featured-grid">
        @foreach($featuredPackages as $package)
            <div class="home-package-card">
                <div class="home-img-wrapper">
                    <img src="{{ asset('storage/' . $package->image) }}" class="home-package-img" alt="{{ $package->name }}">
                </div>
                <div class="home-package-body">
                    <div class="home-favorite-badge">💖 Paling Laku</div>

                    <h3 class="home-package-title">{{ $package->name }}</h3>
                    <p class="home-package-price">Rp {{ number_format($package->price, 0, ',', '.') }}</p>

                    <p style="font-size: 13px; color: #7f8c8d; margin-bottom: 20px; font-weight: 600;">
                        <span style="color: #f39c12;">★</span> Telah dipesan {{ $package->reservations_count ?? 0 }} kali
                    </p>

                    <a href="{{ route('reservations.create', ['package_id' => $package->id]) }}" class="home-btn-book">Reservasi Sekarang</a>
                </div>
            </div>
        @endforeach
    </div>

    <div style="text-align: center; margin-top: 50px;">
        <a href="{{ route('catalog') }}" style="color: #3A3959; font-weight: 800; text-decoration: none; border-bottom: 2px solid #3A3959; padding-bottom: 5px; font-size: 1.15rem; transition: 0.3s;" onmouseover="this.style.color='#706F8E'; this.style.borderColor='#706F8E';" onmouseout="this.style.color='#3A3959'; this.style.borderColor='#3A3959';">Jelajahi Semua Katalog &rarr;</a>
    </div>
</div>

<!-- ==========================================
     SECTION KALENDER
     ========================================== -->
<div style="padding: 40px 20px; text-align: center;">
    <h2 class="section-title">Cek Ketersediaan Studio</h2>

    <div class="calendar-wrapper">
        <p style="margin-bottom: 30px; color: #706F8E; font-size: 1.1rem; line-height: 1.6;">
            Tanggal <b style="color: #e74c3c;">merah dicoret</b> berarti <i>Full Booked</i>.<br>
            Tanggal <b style="color: #d35400;">kuning terang</b> berarti masih ada jam kosong.<br>
            <span style="font-size: 0.95rem;">(Silakan klik pada tanggal untuk melihat detail antrian jam)</span>
        </p>

        <div style="display: flex; justify-content: center;">
            <div id="calendar-display"></div>
        </div>

        <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid #EAEBE6;">
            @auth
                <a href="{{ route('catalog') }}" class="btn-inspirasi" style="box-shadow: none;">
                    Booking Tanggal Sekarang &rarr;
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-inspirasi" style="box-shadow: none; background: #27ae60;">
                    Login untuk Booking &rarr;
                </a>
            @endauth
        </div>
    </div>
</div>

<!-- ==========================================
     SECTION MENGAPA KAMI
     ========================================== -->
<div style="padding: 80px 20px; text-align: center;">
    <h2 class="section-title">Mengapa Memilih Kami?</h2>
    <p class="section-subtitle">Kami mendedikasikan kualitas terbaik untuk setiap jepretan Anda.</p>

    <div style="display: flex; gap: 30px; justify-content: center; flex-wrap: wrap; max-width: 1200px; margin: 0 auto;">
        <div class="feature-card">
            <div class="feature-icon-wrapper">📸</div>
            <h3 style="color: #22222E; font-size: 1.5rem; margin-bottom: 15px; font-weight: 800;">Peralatan Modern</h3>
            <p style="color: #706F8E; line-height: 1.6;">Kami menggunakan perlengkapan kamera dan lighting standar profesional untuk menghasilkan detail foto yang sempurna.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon-wrapper">👨‍🎨</div>
            <h3 style="color: #22222E; font-size: 1.5rem; margin-bottom: 15px; font-weight: 800;">Berpengalaman</h3>
            <p style="color: #706F8E; line-height: 1.6;">Tim fotografer kami sangat ahli dalam menangkap angle terbaik dan siap membantu mengarahkan gaya andalanmu.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon-wrapper">🖨️</div>
            <h3 style="color: #22222E; font-size: 1.5rem; margin-bottom: 15px; font-weight: 800;">Hasil Cetak Tajam</h3>
            <p style="color: #706F8E; line-height: 1.6;">Didukung oleh mesin cetak mutakhir, memastikan akurasi warna yang tinggi dan tahan lama pada kertas premium.</p>
        </div>
    </div>
</div>

<!-- ==========================================
     SECTION GALERI INSPIRASI (4 ITEM, TANPA CETAK FOTO)
     ========================================== -->
<div class="galeri-inspirasi">
    <div class="galeri-text">
        <h2 class="section-title" style="text-align: left; font-size: 3.5rem;">Our Best Moments.</h2>
        <p>
            Setiap senyuman punya ceritanya sendiri. Intip bagaimana kami mengabadikan momen-momen berharga dengan sentuhan aesthetic khas Salma Photography.
        </p>
        <a href="https://instagram.com/photographsalma" target="_blank" class="btn-inspirasi">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z" />
            </svg>
            Jelajahi Karya Kami
        </a>
    </div>

    <div class="galeri-grid">
        <!-- SEKARANG MENGGUNAKAN $galleryPackages -->
        @foreach($galleryPackages as $package)
            <div class="galeri-item">
                <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->name }}">
            </div>
        @endforeach
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let bookedData = @json($bookedDatesData ?? []);

        flatpickr("#calendar-display", {
            inline: true,
            minDate: "today",
            dateFormat: "Y-m-d",

            onDayCreate: function(dObj, dStr, fp, dayElem) {
                let dateStr = fp.formatDate(dayElem.dateObj, "Y-m-d");

                if (bookedData[dateStr]) {
                    let info = bookedData[dateStr];

                    if (info.status === 'full') {
                        dayElem.classList.add('fully-booked');
                    } else if (info.status === 'partial') {
                        dayElem.classList.add('partially-booked');
                    }
                    dayElem.title = "Klik untuk lihat detail jadwal";
                }
            },

            onChange: function(selectedDates, dateStr, instance) {
                if (bookedData[dateStr]) {
                    let info = bookedData[dateStr];
                    let jamList = info.booked_hours.map(j => `<li>${j}</li>`).join('');

                    Swal.fire({
                        title: `Jadwal Tgl ${dateStr}`,
                        html: `
                            <div style="font-size: 1.1rem; color: #3A3959;">
                                Jam di bawah ini sudah <b>ter-booking</b>:<br>
                                <ul style="text-align:left; display:inline-block; margin-top: 10px; color: #e74c3c; font-weight: bold;">
                                    ${jamList}
                                </ul><br>
                                ${info.status === 'partial' ? '<span style="color: #27ae60; font-weight: bold;">Sisa jam lainnya masih tersedia!</span>' : '<span style="color: #e74c3c; font-weight: bold;">Maaf, studio sudah penuh hari ini.</span>'}
                            </div>
                        `,
                        icon: info.status === 'full' ? 'error' : 'info',
                        confirmButtonText: 'Tutup',
                        confirmButtonColor: '#3A3959',
                        backdrop: `rgba(34, 34, 46, 0.7)`
                    });
                } else {
                     Swal.fire({
                        title: `Tersedia! (Tgl ${dateStr})`,
                        text: "Studio masih kosong seharian! Silakan booking dari jam 09:00 - 21:00.",
                        icon: 'success',
                        confirmButtonText: 'Mantap!',
                        confirmButtonColor: '#27ae60',
                        backdrop: `rgba(34, 34, 46, 0.7)`
                    });
                }
            }
        });
    });
</script>
@endsection
