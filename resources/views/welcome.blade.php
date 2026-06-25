@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    /* ==========================================
       HERO BANNER & PENGUMUMAN STUDIO (BARU)
       ========================================== */
    .hero-banner {
        position: relative;
        width: 100%;
        min-height: 80vh;
        border-radius: 24px; /* Membuat sudut membulat elegan */
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: -10px;
        margin-bottom: 60px;
        box-shadow: 0 15px 40px rgba(34, 34, 46, 0.15);
    }

    /* Background GIF kompilasi */
    .hero-bg {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        /* Pastikan file kompilasi.gif ada di folder public/images */
        background-image: url('{{ asset("images/kompilasi.gif") }}');
        background-size: cover;
        background-position: center;
        z-index: 1;
    }

    /* Overlay gelap agar teks & kotak kaca terlihat jelas */
    .hero-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(to bottom, rgba(58, 57, 89, 0.6), rgba(34, 34, 46, 0.85));
        z-index: 2;
    }

    .hero-content {
        position: relative;
        z-index: 3;
        text-align: center;
        color: #EAEBE6;
        padding: 20px;
        width: 100%;
        max-width: 800px;
    }

    .hero-title {
        font-family: 'Georgia', serif;
        font-size: 3.8rem;
        font-weight: 800;
        margin: 0 0 15px 0;
        text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
    }

    .hero-subtitle {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 35px;
        color: #ADA9BA;
        letter-spacing: 2px;
    }

    /* Kotak Pengumuman Kaca (Glassmorphism) */
    .announcement-box {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 35px;
        border-radius: 20px;
        display: inline-block;
        text-align: left;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .announce-title {
        font-size: 1.4rem;
        font-weight: 800;
        text-align: center;
        margin: 0 0 20px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        padding-bottom: 15px;
        letter-spacing: 1px;
        color: #ffffff;
    }

    .schedule-grid {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 15px 25px;
        font-size: 1.1rem;
    }

    .schedule-label { font-weight: bold; color: #EAEBE6; }
    .schedule-time { color: #f1c40f; font-weight: bold; } /* Warna kuning terang */

    .location-info {
        margin-top: 25px;
        text-align: center;
        font-size: 1rem;
        color: #EAEBE6;
        line-height: 1.6;
        font-weight: 500;
    }

    /* CUSTOM CSS UNTUK FLATPICKR (Asli milikmu) */
    .flatpickr-calendar {
        background: #ffffff;
        border: none !important;
        box-shadow: 0 10px 40px rgba(34, 34, 46, 0.08) !important;
        border-radius: 20px !important;
        padding: 15px !important;
        width: 340px !important;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .flatpickr-month {
        color: #3A3959 !important;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .flatpickr-current-month .flatpickr-monthDropdown-months,
    .flatpickr-current-month input.cur-year {
        font-weight: 800 !important;
        font-size: 1.2rem;
    }

    .flatpickr-prev-month svg, .flatpickr-next-month svg {
        fill: #3A3959 !important;
    }

    span.flatpickr-weekday {
        color: #706F8E !important;
        font-weight: 800;
        font-size: 0.9rem;
    }

    .flatpickr-day {
        border-radius: 12px !important;
        color: #22222E;
        font-weight: 600;
        margin: 2px !important;
        transition: transform 0.2s;
    }

    .flatpickr-day:hover {
        transform: scale(1.1);
    }

    .flatpickr-day.today {
        background: #ADA9BA !important;
        border-color: #ADA9BA !important;
        color: #ffffff !important;
    }

    .flatpickr-day.fully-booked {
        background-color: #ffe8e8 !important;
        color: #e74c3c !important;
        text-decoration: line-through;
        font-weight: 800;
        border-color: transparent !important;
    }

    .flatpickr-day.partially-booked {
        background-color: #fff3cd !important;
        color: #d35400 !important;
        font-weight: 800;
        border-color: #ffeeba !important;
    }

    /* CSS KHUSUS UNTUK GALERI INSPIRASI (Asli milikmu) */
    .galeri-inspirasi {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        padding: 80px 5%;
        gap: 50px;
        background-color: #ffffff;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(34, 34, 46, 0.05);
        margin-top: 40px;
    }

    .galeri-text {
        flex: 1;
        min-width: 300px;
    }

    .galeri-text h2 {
        font-size: 3.5rem;
        font-weight: 800;
        color: #3A3959;
        line-height: 1.2;
        margin-bottom: 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .galeri-text p {
        font-size: 1.2rem;
        color: #22222E;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    .btn-inspirasi {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background-color: #3A3959;
        color: #EAEBE6 !important;
        padding: 15px 35px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: bold;
        font-size: 1.1rem;
        transition: transform 0.2s, background-color 0.2s;
    }

    .btn-inspirasi:hover {
        transform: scale(1.05);
        background-color: #706F8E;
    }

    .galeri-grid {
        flex: 1;
        min-width: 300px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .galeri-item {
        width: 100%;
        aspect-ratio: 4/5;
        overflow: hidden;
        border-radius: 20px;
        box-shadow: 0 4px 10px rgba(34, 34, 46, 0.15);
    }

    .galeri-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }

    .galeri-item:hover img {
        transform: scale(1.1);
    }

    @media (max-width: 768px) {
        .galeri-text h2 { font-size: 2.4rem; }
        .galeri-inspirasi { padding: 50px 5%; text-align: center; }
        .schedule-grid { grid-template-columns: 1fr; gap: 5px; text-align: center; }
        .schedule-label { margin-top: 10px; }
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

<div style="padding: 40px 0; text-align: center;">
    <h2 style="margin-bottom: 15px; color: #3A3959; font-size: 2.5rem; font-weight: 800;">Cek Ketersediaan Jadwal Studio</h2>

    <p style="margin-bottom: 40px; color: #22222E; font-size: 1.1rem;">
        Tanggal <b style="color: #e74c3c;">merah dicoret</b> berarti <i>Full Booked</i>.<br>
        Tanggal <b style="color: #d35400;">kuning/orange</b> berarti masih ada jam kosong. <b>Klik tanggal</b> untuk melihat detail.
    </p>

    <div style="display: flex; justify-content: center;">
        <div id="calendar-display"></div>
    </div>

    <div style="margin-top: 40px;">
        @auth
            <a href="{{ route('catalog') }}" style="display: inline-block; background: #3A3959; color: #EAEBE6; padding: 12px 35px; border-radius: 50px; text-decoration: none; font-weight: bold; font-size: 1.1rem; transition: all 0.3s; box-shadow: 0 4px 15px rgba(58,57,89,0.2);" onmouseover="this.style.backgroundColor='#706F8E';" onmouseout="this.style.backgroundColor='#3A3959';">
                Booking Sekarang &rarr;
            </a>
        @else
            <a href="{{ route('login') }}" style="display: inline-block; background: #3A3959; color: #EAEBE6; padding: 12px 35px; border-radius: 50px; text-decoration: none; font-weight: bold; font-size: 1.1rem; transition: all 0.3s; box-shadow: 0 4px 15px rgba(58,57,89,0.2);" onmouseover="this.style.backgroundColor='#706F8E';" onmouseout="this.style.backgroundColor='#3A3959';">
                Ingin booking? Login / Daftar sekarang &rarr;
            </a>
        @endauth
    </div>
</div>

<div style="padding: 60px 0; text-align: center;">
    <h2 style="margin-bottom: 50px; color: #3A3959; font-size: 2.5rem; font-weight: 800;">Mengapa Memilih Kami?</h2>
    <div style="display: flex; gap: 30px; justify-content: center; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 250px; background: #ffffff; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(34, 34, 46, 0.05); border: 1px solid rgba(173,169,186,0.2);">
            <h3 style="color: #22222E; font-size: 1.5rem; margin-bottom: 15px;">📸 Peralatan Modern</h3>
            <p style="color: #706F8E; line-height: 1.6;">Menggunakan kamera dan lighting standar industri untuk hasil maksimal.</p>
        </div>
        <div style="flex: 1; min-width: 250px; background: #ffffff; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(34, 34, 46, 0.05); border: 1px solid rgba(173,169,186,0.2);">
            <h3 style="color: #22222E; font-size: 1.5rem; margin-bottom: 15px;">👨‍🎨 Berpengalaman</h3>
            <p style="color: #706F8E; line-height: 1.6;">Tim fotografer yang ahli menangkap sudut terbaik dan mengarahkan gaya anda.</p>
        </div>
        <div style="flex: 1; min-width: 250px; background: #ffffff; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(34, 34, 46, 0.05); border: 1px solid rgba(173,169,186,0.2);">
            <h3 style="color: #22222E; font-size: 1.5rem; margin-bottom: 15px;">🖨️ Hasil Cetak Tajam</h3>
            <p style="color: #706F8E; line-height: 1.6;">Teknologi cetak terkini dengan akurasi warna tinggi dan kertas premium.</p>
        </div>
    </div>
</div>

<div class="galeri-inspirasi">
    <div class="galeri-text">
        <h2>Our Best Moments.</h2>
        <p>
            Setiap senyuman punya ceritanya sendiri. Intip bagaimana kami mengabadikan momen-momen berharga dengan sentuhan aesthetic khas Salma Photography.
        </p>
        <a href="https://instagram.com/photographsalma" target="_blank" class="btn-inspirasi">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z" />
            </svg>
            Lihat Karya Lainnya di IG
        </a>
    </div>

    <div class="galeri-grid">
        @foreach($featuredPackages as $package)
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
        // Tangkap data array pintar dari Controller
        let bookedData = @json($bookedDatesData ?? []);

        flatpickr("#calendar-display", {
            inline: true,
            minDate: "today",
            dateFormat: "Y-m-d",

            // Warnai tanggal sesuai status (full atau partial)
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

            // Munculkan Pop-up SweetAlert saat tanggal diklik
            onChange: function(selectedDates, dateStr, instance) {
                if (bookedData[dateStr]) {
                    let info = bookedData[dateStr];

                    // Susun list HTML untuk jam yang sudah dibooking
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
                        confirmButtonColor: '#3A3959'
                    });
                } else {
                     Swal.fire({
                        title: `Jadwal Tgl ${dateStr}`,
                        text: "Studio masih kosong seharian! Silakan booking dari jam 08:00 - 21:00.",
                        icon: 'success',
                        confirmButtonText: 'Mantap!',
                        confirmButtonColor: '#27ae60'
                    });
                }
            }
        });
    });
</script>
@endsection
