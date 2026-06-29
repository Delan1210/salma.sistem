@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

<style>
    /* Styling khusus Slider */
    .swiper { width: 100%; padding: 40px 10px; }
    .swiper-slide { height: auto; display: flex; justify-content: center; }
    .swiper-pagination-bullet-active { background: #3A3959 !important; }

    /* Navigation Arrows */
    .swiper-button-next, .swiper-button-prev { color: #3A3959 !important; }

    /* Package Card */
    .package-card {
        background: #ffffff;
        border-radius: 24px;
        overflow: hidden;
        width: 320px;
        box-shadow: 0 10px 30px rgba(58, 57, 89, 0.08);
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease;
        border: 1px solid rgba(173, 169, 186, 0.2);
    }
    .package-card:hover { transform: translateY(-10px); }
    .package-img { width: 100%; height: 220px; object-fit: cover; }
    .package-body { padding: 25px; flex: 1; display: flex; flex-direction: column; }
    .package-title { color: #3A3959; font-size: 1.4rem; font-weight: 800; margin: 0 0 10px 0; }
    .package-price { color: #27ae60; font-weight: 800; font-size: 1.2rem; margin-bottom: 15px; }

    /* Modifikasi Package Deskripsi agar Enter terbaca dan bisa di-scroll */
    .package-desc {
        color: #706F8E;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 25px;
        white-space: pre-line; /* Membaca tombol Enter / Baris Baru */
        max-height: 150px; /* Batas tinggi teks */
        overflow-y: auto; /* Memunculkan scroll otomatis jika teks panjang */
        padding-right: 5px; /* Jarak untuk scrollbar */
        flex-grow: 1; /* Mendorong tombol booking ke bawah */
    }

    /* Custom Scrollbar tipis untuk deskripsi */
    .package-desc::-webkit-scrollbar { width: 6px; }
    .package-desc::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .package-desc::-webkit-scrollbar-thumb { background: #ADA9BA; border-radius: 10px; }
    .package-desc::-webkit-scrollbar-thumb:hover { background: #706F8E; }

    .btn-book { background: #3A3959; color: white; padding: 12px; border-radius: 50px; text-decoration: none; font-weight: bold; text-align: center; display: block; transition: 0.3s; margin-top: auto; }
    .btn-book:hover { background: #706F8E; }
</style>

<div class="container">
    <div style="text-align: center; margin-bottom: 50px;">
        <h1 style="color: #3A3959; font-size: 3rem; font-weight: 800;">Katalog Paket</h1>
        <p style="color: #706F8E; font-size: 1.2rem;">Pilih momen spesialmu.</p>
    </div>

    <h2 style="color: #3A3959; font-weight: 800; padding-left: 20px;">📸 Paket Fotografi Studio</h2>
    <div class="swiper swiper-foto">
        <div class="swiper-wrapper">
            @foreach($photographyPackages as $package)
            <div class="swiper-slide">
                <div class="package-card">
                    <img src="{{ asset('storage/' . $package->image) }}" class="package-img">
                    <div class="package-body">
                        <h3 class="package-title">{{ $package->name }}</h3>
                        <p class="package-price">Rp {{ number_format($package->price, 0, ',', '.') }}</p>

                        <!-- Pemotong Str::limit dihapus, diubah menjadi div -->
                        <div class="package-desc">{{ $package->description }}</div>

                        <a href="{{ route('reservations.create', ['package_id' => $package->id]) }}" class="btn-book">Reservasi Sekarang</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-pagination"></div>
    </div>

    <h2 style="color: #3A3959; font-weight: 800; padding-left: 20px; margin-top: 50px;">🖨️ Paket Cetak Foto</h2>
    <div class="swiper swiper-cetak">
        <div class="swiper-wrapper">
            @foreach($cetakPackages as $package)
            <div class="swiper-slide">
                <div class="package-card">
                    <img src="{{ asset('storage/' . $package->image) }}" class="package-img">
                    <div class="package-body">
                        <h3 class="package-title">{{ $package->name }}</h3>
                        <p class="package-price">Rp {{ number_format($package->price, 0, ',', '.') }}</p>

                        <!-- Pemotong Str::limit dihapus, diubah menjadi div -->
                        <div class="package-desc">{{ $package->description }}</div>

                        <a href="{{ route('reservations.create', ['package_id' => $package->id]) }}" class="btn-book">Pesan Cetak</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-pagination"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const config = {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
            breakpoints: { 768: { slidesPerView: 3 } }
        };
        new Swiper('.swiper-foto', config);
        new Swiper('.swiper-cetak', config);
    });
</script>
@endsection
