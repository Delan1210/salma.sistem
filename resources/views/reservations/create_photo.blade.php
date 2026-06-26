@extends('layouts.main')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .reservation-container {
            max-width: 650px; margin: 60px auto; background: #ffffff; padding: 40px;
            border-radius: 20px; box-shadow: 0 8px 25px rgba(34, 34, 46, 0.05);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .reservation-title {
            text-align: center; color: #3A3959; margin-top: 0; margin-bottom: 30px;
            font-weight: 800; font-size: 1.8rem; border-bottom: 2px solid #EAEBE6; padding-bottom: 15px;
        }
        .package-summary {
            background-color: #EAEBE6; padding: 20px; border-radius: 12px;
            border: 1px solid #ADA9BA; margin-bottom: 25px; text-align: center;
        }
        .form-label { display: block; font-weight: bold; color: #22222E; font-size: 0.95rem; margin-bottom: 8px; }
        .form-control {
            width: 100%; padding: 12px 15px; border: 1px solid #ADA9BA; border-radius: 8px;
            margin-bottom: 20px; box-sizing: border-box; background-color: #fff; color: #22222E;
            font-family: inherit;
        }
        .form-control:focus {
            outline: none; border-color: #3A3959; box-shadow: 0 0 0 3px rgba(58, 57, 89, 0.1);
        }
        .payment-box {
            background-color: #ffffff; padding: 25px; border-radius: 12px;
            border: 2px dashed #706F8E; text-align: center; margin-bottom: 25px;
        }
        .btn-submit {
            width: 100%; background-color: #3A3959; color: #EAEBE6; padding: 15px;
            border: none; border-radius: 50px; cursor: pointer; font-weight: bold;
            font-size: 1.1rem; transition: 0.3s; margin-top: 10px;
        }
        .btn-submit:hover { background-color: #706F8E; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(58, 57, 89, 0.2); }

        /* Modifikasi Flatpickr */
        .flatpickr-day.flatpickr-disabled {
            background-color: #ffe8e8 !important; color: #e74c3c !important;
            text-decoration: line-through; font-weight: bold; border-color: transparent !important;
        }
        .form-text-info {
            display: block; color: #706F8E; font-size: 12px; margin-top: -12px; margin-bottom: 20px; font-weight: 500;
        }
    </style>

    <div class="reservation-container">
        <h2 class="reservation-title">📸 Form Reservasi Fotografi</h2>

        @if(session('error'))
            <div style="background-color: #FFECEB; color: #c0392b; padding: 15px; border-radius: 8px; margin-bottom: 25px; font-weight: bold; border-left: 5px solid #e74c3c; font-size: 14px; display: flex; align-items: center; gap: 10px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('reservations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="package_id" value="{{ $package->id }}">

            <input type="hidden" name="location" value="Studio Salma">

            <div class="package-summary">
                <p style="margin: 0; color: #706F8E; font-size: 14px; font-weight: bold;">Paket Pilihan Anda:</p>
                <h3 style="margin: 5px 0 10px 0; color: #3A3959; font-size: 1.6rem; font-weight: 800;">{{ $package->name }}</h3>
                <div style="background: #3A3959; color: #EAEBE6; display: inline-block; padding: 5px 15px; border-radius: 50px; font-weight: bold; font-size: 1.1rem;">
                    Rp {{ number_format($package->price, 0, ',', '.') }}
                </div>
            </div>

            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 200px;">
                    <label class="form-label">Tanggal Pemotretan</label>
                    <input type="text" name="reservation_date" id="reservation_date" value="{{ old('reservation_date') }}" class="form-control" required placeholder="Pilih tanggal..." style="cursor: pointer; background-color: #FAFAFA;">
                </div>
                <div style="flex: 1; min-width: 200px;">
                    <label class="form-label">Waktu (Sesi 1 jam)</label>
                    <input type="text" name="reservation_time" id="reservation_time" value="{{ old('reservation_time') }}" class="form-control" required placeholder="Pilih jam..." style="cursor: pointer; background-color: #FAFAFA;">
                </div>
            </div>

            <div class="payment-box">
                <h4 style="margin-top: 0; color: #3A3959; margin-bottom: 10px; font-weight: 800;">💳 Informasi Pembayaran</h4>
                <p style="font-size: 14px; color: #22222E; margin-bottom: 20px;">Silakan selesaikan pembayaran sebesar <strong style="color: #27ae60; font-size: 16px;">Rp {{ number_format($package->price, 0, ',', '.') }}</strong> dengan melakukan <i>scan</i> QRIS di bawah ini:</p>

                <div style="display: flex; justify-content: center; align-items: center; gap: 30px; flex-wrap: wrap;">
                    <img src="{{ asset('images/qris-studio.png') }}" alt="QRIS" style="max-width: 180px; border-radius: 12px; box-shadow: 0 4px 15px rgba(34, 34, 46, 0.1);">
                    <div style="text-align: left; min-width: 200px;">
                        <p style="margin: 0 0 10px 0; font-size: 13px; color: #706F8E; border-bottom: 1px solid #EAEBE6; padding-bottom: 5px; font-weight: bold;">Atau transfer manual ke:</p>
                        <p style="margin: 5px 0; font-size: 15px; color: #22222E;"><strong>Bank Jago:</strong> 105481524829 </p>
                        <p style="margin: 5px 0 0 0; font-size: 14px; color: #22222E;"><strong>A.N:</strong> Riki Firmansyah </p>
                    </div>
                </div>
            </div>

            <div>
                <label class="form-label">Upload Bukti Pembayaran</label>
                <input type="file" name="payment_proof" accept="image/*" class="form-control" required style="padding: 9px 15px; background-color: #FAFAFA;">
            </div>

            <div>
                <label class="form-label">Pilihan Background / Catatan Tambahan (Opsional)</label>
                <textarea name="notes" rows="3" class="form-control" placeholder="Misal: Request background warna putih, gaya ceria, dll.">{{ old('notes') }}</textarea>
                <span class="form-text-info">💡 Studio kami memiliki 5 pilihan background menarik yang bisa dipilih saat sesi pemotretan.</span>
            </div>

            <button type="submit" class="btn-submit">Kirim Reservasi Sekarang</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let disableDates = @json($bookedDates ?? []);

            // Kalender Tanggal
            flatpickr("#reservation_date", {
                disable: disableDates,
                minDate: "today",
                dateFormat: "Y-m-d"
            });

            // Kalender Jam (Sesi)
            flatpickr("#reservation_time", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                minTime: "09:00",
                maxTime: "21:00",
                minuteIncrement: 60
            });
        });
    </script>
@endsection
