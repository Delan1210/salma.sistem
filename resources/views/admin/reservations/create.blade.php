@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div style="max-width: 600px; margin: 20px auto; background: white; padding: 35px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <h2 style="color: #3A3959; margin-top: 0; margin-bottom: 25px; border-bottom: 2px solid #f0f0f0; padding-bottom: 15px;">✍️ Input Reservasi Offline (Manual)</h2>

    @if(session('error'))
        <div style="background-color: #ffe8e8; color: #e74c3c; padding: 15px; border-radius: 8px; margin-bottom: 25px; font-weight: bold; border-left: 5px solid #e74c3c; font-size: 14px; display: flex; align-items: center; gap: 10px;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.reservations.store') }}" method="POST">
        @csrf

        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; display: block; margin-bottom: 5px; color: #22222E;">Nama Pelanggan Offline</label>
            <input type="text" name="customer_name" value="{{ old('customer_name') }}" required placeholder="Misal: Kak Dewi (via WhatsApp)" style="width: 100%; padding: 10px; border: 1px solid #ADA9BA; border-radius: 6px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; display: block; margin-bottom: 5px; color: #22222E;">Pilih Paket Studio</label>
            <select name="package_id" required style="width: 100%; padding: 10px; border: 1px solid #ADA9BA; border-radius: 6px; box-sizing: border-box;">
                <option value="">-- Pilih Paket Fotografi --</option>
                @foreach($packages as $package)
                    <option value="{{ $package->id }}" {{ old('package_id') == $package->id ? 'selected' : '' }}>{{ $package->name }} (Rp {{ number_format($package->price, 0, ',', '.') }})</option>
                @endforeach
            </select>
        </div>

        <div style="display: flex; gap: 15px; margin-bottom: 15px;">
            <div style="flex: 1;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px; color: #22222E;">Tanggal Booking</label>
                <input type="text" name="reservation_date" id="admin_date" value="{{ old('reservation_date') }}" required placeholder="Pilih tanggal..." style="width: 100%; padding: 10px; border: 1px solid #ADA9BA; border-radius: 6px; box-sizing: border-box; background: white; cursor: pointer;">
            </div>
            <div style="flex: 1;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px; color: #22222E;">Jam Mulai</label>
                <input type="text" name="reservation_time" id="admin_time" value="{{ old('reservation_time') }}" required placeholder="Pilih jam..." style="width: 100%; padding: 10px; border: 1px solid #ADA9BA; border-radius: 6px; box-sizing: border-box; background: white; cursor: pointer;">
            </div>
        </div>

        <div style="margin-bottom: 25px;">
            <label style="font-weight: bold; display: block; margin-bottom: 5px; color: #22222E;">Lokasi</label>
            <input type="text" name="location" value="{{ old('location', 'Studio Salma') }}" required style="width: 100%; padding: 10px; border: 1px solid #ADA9BA; border-radius: 6px; box-sizing: border-box;">
        </div>

        <button type="submit" style="width: 100%; background: #3A3959; color: white; padding: 12px; border: none; border-radius: 50px; font-weight: bold; font-size: 16px; cursor: pointer; transition: 0.3s;" onmouseover="this.style.backgroundColor='#706F8E'" onmouseout="this.style.backgroundColor='#3A3959'">
            Simpan Jadwal Offline
        </button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#admin_date", {
            minDate: "today",
            dateFormat: "Y-m-d"
        });

        flatpickr("#admin_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            minTime: "08:00",
            maxTime: "21:00"
        });
    });
</script>
@endsection
