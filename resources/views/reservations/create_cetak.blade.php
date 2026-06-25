@extends('layouts.main')

@section('content')
    <style>
        .reservation-container {
            max-width: 650px;
            margin: 60px auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(34, 34, 46, 0.05);
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
        .btn-submit:hover { background-color: #706F8E; }
        .alert-cetak {
            background-color: #eafaf1; color: #27ae60; padding: 15px; border-radius: 8px;
            border-left: 5px solid #27ae60; margin-bottom: 20px; font-weight: 500; font-size: 0.95rem;
        }
    </style>

    <div class="reservation-container">
        <h2 class="reservation-title">🖨️ Form Pemesanan Cetak Foto</h2>

        <form action="{{ route('reservations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="package_id" value="{{ $package->id }}">

            <!-- Input otomatis untuk database -->
            <input type="hidden" name="reservation_date" value="{{ date('Y-m-d') }}">
            <input type="hidden" name="reservation_time" value="00:00">
            <input type="hidden" name="location" value="Kirim File Online">

            <div class="package-summary">
                <p style="margin: 0; color: #706F8E; font-size: 14px; font-weight: bold;">Paket Pilihan Anda:</p>
                <h3 style="margin: 5px 0 10px 0; color: #3A3959; font-size: 1.6rem; font-weight: 800;">{{ $package->name }}</h3>
                <div style="background: #3A3959; color: #EAEBE6; display: inline-block; padding: 5px 15px; border-radius: 50px; font-weight: bold; font-size: 1.1rem;">
                    Rp {{ number_format($package->price, 0, ',', '.') }}
                </div>
            </div>

            <div class="alert-cetak">
                ℹ️ <b>Paket Cetak Foto</b> tidak memerlukan jadwal studio. Silakan langsung mengunggah foto yang ingin dicetak pada link Google Drive di bagian "Catatan", lalu selesaikan pembayaran.
            </div>

            <div class="payment-box">
                <h4 style="margin-top: 0; color: #3A3959; margin-bottom: 10px; font-weight: 800;">💳 Informasi Pembayaran</h4>
                <p style="font-size: 14px; color: #22222E; margin-bottom: 20px;">Silakan selesaikan pembayaran sebesar <strong>Rp {{ number_format($package->price, 0, ',', '.') }}</strong> dengan melakukan <i>scan</i> QRIS di bawah ini:</p>

                <div style="display: flex; justify-content: center; align-items: center; gap: 30px; flex-wrap: wrap;">
                    <img src="{{ asset('images/qris-studio.png') }}" alt="QRIS" style="max-width: 180px; border-radius: 12px; box-shadow: 0 4px 15px rgba(34, 34, 46, 0.1);">
                    <div style="text-align: left; min-width: 200px;">
                        <p style="margin: 0 0 10px 0; font-size: 13px; color: #706F8E; border-bottom: 1px solid #EAEBE6; padding-bottom: 5px; font-weight: bold;">Atau transfer manual ke:</p>
                        <p style="margin: 5px 0; font-size: 15px; color: #22222E;"><strong>BCA:</strong> 1234-5678-90</p>
                        <p style="margin: 5px 0; font-size: 15px; color: #22222E;"><strong>BSI:</strong> 0987-6543-21</p>
                        <p style="margin: 5px 0 0 0; font-size: 14px; color: #22222E;"><strong>A.N:</strong> Salma Studio</p>
                    </div>
                </div>
            </div>

            <div>
                <label class="form-label">Upload Bukti Pembayaran</label>
                <input type="file" name="payment_proof" accept="image/*" class="form-control" required style="padding: 9px 15px;">
            </div>

            <div>
                <label class="form-label">Catatan Link Foto</label>
                <textarea name="notes" rows="3" class="form-control" placeholder="Paste link Google Drive berisi foto yang ingin dicetak di sini..."></textarea>
            </div>

            <button type="submit" class="btn-submit">Kirim Pesanan Cetak</button>
        </form>
    </div>
@endsection
