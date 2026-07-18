@extends('layouts.admin')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        /* Base Container Overrides */
        .dashboard-container {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #22222E;
            margin-top: -10px;
        }

        /* 1. Grid Layouts */
        .grid-layout {
            display: flex;
            gap: 24px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        /* 2. Sleek Minimalist Stat Cards */
        .card-stat {
            flex: 1;
            min-width: 220px;
            padding: 24px;
            border-radius: 16px;
            color: white;
            box-shadow: 0 10px 20px rgba(58, 57, 89, 0.05);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .card-stat:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(58, 57, 89, 0.12);
        }
        /* Elemen dekoratif lingkaran transparan di dalam card */
        .card-stat::after {
            content: '';
            position: absolute;
            width: 130px;
            height: 130px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -20px;
            right: -20px;
        }
        .card-stat h4 {
            margin: 0 0 12px 0;
            font-weight: 600;
            opacity: 0.85;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .card-stat h2 {
            margin: 0;
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .card-stat h2 span {
            font-size: 15px;
            font-weight: 500;
            opacity: 0.85;
        }

        /* Varian Warna Gradient Mewah */
        .bg-revenue { background: linear-gradient(135deg, #3A3959, #57557A); }
        .bg-total { background: linear-gradient(135deg, #706F8E, #9290B3); }
        .bg-pending { background: linear-gradient(135deg, #f39c12, #f1c40f); }
        .bg-completed { background: linear-gradient(135deg, #27ae60, #2ecc71); }

        /* 3. Modern Box Containers */
        .box-container {
            flex: 1;
            min-width: 320px;
            background-color: white;
            padding: 28px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(58, 57, 89, 0.04);
            border: 1px solid rgba(173, 169, 186, 0.15);
        }
        .box-title {
            margin-top: 0;
            margin-bottom: 20px;
            color: #3A3959;
            font-weight: 700;
            font-size: 18px;
            letter-spacing: -0.3px;
        }

        /* 4. Table Headers & Controls */
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
            flex-wrap: wrap;
            gap: 15px;
        }
        .table-header h3 {
            margin: 0;
            border-left: 5px solid #3A3959;
            padding-left: 14px;
            color: #3A3959;
            font-weight: 700;
            font-size: 20px;
        }
        .table-header.print h3 { border-left-color: #706F8E; }

        /* Tombol Aksi Premium */
        .btn-action {
            padding: 10px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 700;
            color: white;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 10px rgba(58, 57, 89, 0.1);
        }
        .btn-dark { background-color: #3A3959; }
        .btn-dark:hover { background-color: #22222E; transform: translateY(-2px); box-shadow: 0 6px 15px rgba(34, 34, 46, 0.2); }

        .btn-teal { background-color: #706F8E; }
        .btn-teal:hover { background-color: #57557A; transform: translateY(-2px); box-shadow: 0 6px 15px rgba(112, 111, 142, 0.2); }

        .btn-blue { background-color: #3498db; padding: 6px 12px; border-radius: 6px; box-shadow: none; }
        .btn-blue:hover { background-color: #2980b9; }

        .btn-red { background-color: #e74c3c; padding: 6px 12px; width: 100%; border-radius: 6px; font-weight: 600; box-shadow: none; }
        .btn-red:hover { background-color: #c0392b; }

        /* 5. Borderless Table System */
        .table-responsive {
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid rgba(173, 169, 186, 0.2);
        }
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1050px;
            font-size: 14px;
            background: white;
        }
        .admin-table th {
            background-color: #F8F9FA;
            padding: 16px 14px;
            font-weight: 700;
            color: #3A3959;
            text-align: center;
            border-bottom: 2px solid #EAEBE6;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .admin-table td {
            padding: 16px 14px;
            border-bottom: 1px solid #EAEBE6;
            color: #22222E;
            vertical-align: middle;
        }
        .admin-table tr:last-child td { border-bottom: none; }
        .admin-table tr:hover { background-color: #FAF9F5; }

        /* 6. Soft Pastel Badges */
        .badge {
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 700;
            display: inline-block;
            letter-spacing: 0.3px;
        }
        .badge-type-online { background-color: rgba(52, 152, 219, 0.15); color: #2980b9; }
        .badge-type-offline { background-color: rgba(230, 126, 34, 0.15); color: #d35400; }

        .status-pending { background-color: #FFF9E6; color: #D35400; }
        .status-confirmed { background-color: #EBF5FF; color: #2980b9; }
        .status-completed { background-color: #EBF7EE; color: #27ae60; }

        /* Ubah warna badge 'Finished' agar lebih netral (abu-abu) jika diinginkan, atau biarkan bawaannya */
        .status-cancelled { background-color: #EAEBE6; color: #3A3959; }

        /* Form Controls */
        .form-select {
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid #ADA9BA;
            font-size: 13px;
            color: #22222E;
            outline: none;
            background-color: #ffffff;
        }
        .form-select:focus { border-color: #3A3959; }

        /* Flatpickr Enhancements */
        .flatpickr-calendar {
            box-shadow: 0 10px 25px rgba(58, 57, 89, 0.08) !important;
            border: 1px solid rgba(173, 169, 186, 0.2) !important;
            border-radius: 12px !important;
        }
    </style>

    <div class="dashboard-container">

        <div class="grid-layout">
            <div class="card-stat bg-revenue">
                <h4>Total Pendapatan</h4>
                <h2>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
            </div>
            <div class="card-stat bg-total">
                <h4>Total Reservasi</h4>
                <h2>{{ $totalReservations }} <span>Pesanan</span></h2>
            </div>
            <div class="card-stat bg-pending">
                <h4>Menunggu Konfirmasi</h4>
                <h2>{{ $pendingReservations }} <span>Pesanan</span></h2>
            </div>
            <div class="card-stat bg-completed">
                <h4>Pesanan Selesai</h4>
                <h2>{{ $completedReservations }} <span>Pesanan</span></h2>
            </div>
        </div>

        <div class="grid-layout">
            <div class="box-container">
                <h3 class="box-title">📊 Analisis Penjualan Paket</h3>
                <div style="width: 100%; max-width: 310px; margin: 0 auto;">
                    <canvas id="myChart"></canvas>
                </div>
            </div>

            <div class="box-container">
                <h3 class="box-title">🗓️ Kalender Jadwal Studio</h3>
                <p style="text-align: center; font-size: 13px; color: #706F8E; margin-bottom: 15px;">Merah = Penuh | Kuning = Tersedia</p>
                <div style="display: flex; justify-content: center;">
                    <div id="admin-calendar"></div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div style="color: #27ae60; background-color: #EBF7EE; padding: 16px; margin-bottom: 25px; border-radius: 12px; font-weight: 700; border-left: 5px solid #27ae60; box-shadow: 0 4px 12px rgba(39, 174, 96, 0.05); font-size: 14.5px;">
                ✨ {{ session('success') }}
            </div>
        @endif

        <div class="box-container" style="margin-bottom: 35px; padding: 30px;">
            <div class="table-header">
                <h3>📷 Daftar Reservasi Jasa Fotografi</h3>
                <div style="display: flex; gap: 12px;">
                    <a href="{{ route('admin.reservations.create') }}" class="btn-action btn-dark">＋ Booking Offline</a>
                    <a href="{{ route('admin.reservations.report') }}" class="btn-action btn-teal">📄 Halaman Laporan</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th style="width: 100px;">Tipe</th>
                            <th style="text-align: left;">Nama Pelanggan</th>
                            <th>Lokasi / Link Foto</th>
                            <th style="text-align: left;">Paket Pilihan</th>
                            <th>Tanggal & Waktu</th>
                            <th>Bukti Bayar</th>
                            <th>Status</th>
                            <th style="width: 160px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($photoReservations as $index => $reservation)
                            <tr>
                                <td align="center" style="font-weight: 600; color: #706F8E;">{{ $index + 1 }}</td>
                                <td align="center">
                                    @if(str_contains($reservation->notes, '[OFFLINE]'))
                                        <span class="badge badge-type-offline">OFFLINE</span>
                                    @else
                                        <span class="badge badge-type-online">ONLINE</span>
                                    @endif
                                </td>
                                <td>
                                    @if(str_contains($reservation->notes, '[OFFLINE]'))
                                        <span style="font-weight: 700; color: #3A3959; font-size: 15px;">{{ str_replace('[OFFLINE] A/N: ', '', $reservation->notes) }}</span>
                                    @else
                                        <span style="font-weight: 700; color: #22222E; font-size: 15px;">{{ $reservation->user->name ?? 'User Dihapus' }}</span>
                                        @if($reservation->notes)
                                            <br><span style="font-size: 12px; color: #706F8E; font-weight: 500;">Catatan: {{ $reservation->notes }}</span>
                                        @endif
                                    @endif
                                </td>
                                <td align="center">
                                    @if ($reservation->gdrive_link)
                                        <a href="{{ $reservation->gdrive_link }}" target="_blank" style="color: #3498db; text-decoration: none; font-weight: 700;">📁 Folder Drive</a>
                                    @elseif ($reservation->location)
                                        <span style="font-weight: 500;">{{ $reservation->location }}</span>
                                    @else
                                        <span style="color: #ADA9BA;">-</span>
                                    @endif
                                </td>
                                <td style="font-weight: 600;">{{ $reservation->package->name ?? 'Paket Dihapus' }}</td>
                                <td align="center" style="font-weight: 600;">
                                    {{ $reservation->reservation_date }}<br>
                                    <span style="font-size: 12.5px; color: #706F8E; font-weight: 500;">⏰ {{ substr($reservation->reservation_time, 0, 5) ?? '' }} Wib</span>
                                </td>
                                <td align="center">
                                    @if (str_contains($reservation->payment_proof, 'offline'))
                                        <span style="color: #27ae60; font-weight: 700; font-size: 13px;">💵 Cash (COD)</span>
                                    @elseif ($reservation->payment_proof)
                                        <button type="button" onclick="lihatBukti('{{ route('payment.proof', $reservation->id) }}')" style="background: none; border: none; color: #3498db; text-decoration: none; font-weight: 700; cursor: pointer; padding: 0; font-size: 13.5px;">👁️ Lihat Struk</button>
                                    @else
                                        <span style="color: #e74c3c; font-weight: 600; font-size: 13px;">Belum Upload</span>
                                    @endif
                                </td>
                                <td align="center">
                                    <!-- Logika untuk menampilkan kata Finished di badge -->
                                    <span class="badge status-{{ $reservation->status }}">
                                        {{ $reservation->status == 'cancelled' ? 'Finished' : ucfirst($reservation->status) }}
                                    </span>
                                </td>
                                <td align="center">
                                    <div style="display: flex; flex-direction: column; gap: 8px;">
                                        <form action="{{ route('admin.reservations.update_status', $reservation->id) }}" method="POST" style="display: flex; gap: 6px; justify-content: center;">
                                            @csrf
                                            <select name="status" required class="form-select">
                                                <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="confirmed" {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                <option value="completed" {{ $reservation->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                <!-- Opsi ke-4: Disimpan sebagai 'cancelled' agar DB aman, tapi ditulis Finished -->
                                                <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>Finished</option>
                                            </select>
                                            <button type="submit" class="btn-action btn-blue">🔄</button>
                                        </form>
                                        <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data reservasi ini selamanya?')" style="width: 100%;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-red">🗑️ Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" align="center" style="padding: 35px; color: #706F8E; font-weight: 500;">Belum ada data reservasi Jasa Fotografi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box-container" style="padding: 30px;">
            <div class="table-header print">
                <h3>🖨️ Daftar Pesanan Cetak Foto</h3>
            </div>

            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th style="width: 100px;">Tipe</th>
                            <th style="text-align: left;">Nama Pelanggan</th>
                            <th style="text-align: left;">Catatan (Detail Cetak)</th>
                            <th style="text-align: left;">Paket Pilihan</th>
                            <th>Tanggal Pesan</th>
                            <th>Bukti Bayar</th>
                            <th>Status</th>
                            <th style="width: 160px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($printReservations as $index => $reservation)
                            <tr>
                                <td align="center" style="font-weight: 600; color: #706F8E;">{{ $index + 1 }}</td>
                                <td align="center">
                                    @if(str_contains($reservation->notes, '[OFFLINE]'))
                                        <span class="badge badge-type-offline">OFFLINE</span>
                                    @else
                                        <span class="badge badge-type-online">ONLINE</span>
                                    @endif
                                </td>
                                <td>
                                    @if(str_contains($reservation->notes, '[OFFLINE]'))
                                        <span style="font-weight: 700; color: #3A3959; font-size: 15px;">{{ str_replace('[OFFLINE] A/N: ', '', $reservation->notes) }}</span>
                                    @else
                                        <span style="font-weight: 700; color: #22222E; font-size: 15px;">{{ $reservation->user->name ?? 'User Dihapus' }}</span>
                                    @endif
                                </td>
                                <td style="font-weight: 500;">
                                    @if(!str_contains($reservation->notes, '[OFFLINE]'))
                                        {{ $reservation->notes ?? '-' }}
                                    @else
                                        <span style="color: #ADA9BA;">-</span>
                                    @endif
                                </td>
                                <td style="font-weight: 600;">{{ $reservation->package->name ?? 'Paket Dihapus' }}</td>
                                <td align="center" style="font-weight: 600;">{{ $reservation->reservation_date }}</td>
                                <td align="center">
                                    @if (str_contains($reservation->payment_proof, 'offline'))
                                        <span style="color: #27ae60; font-weight: 700; font-size: 13px;">💵 Cash (COD)</span>
                                    @elseif ($reservation->payment_proof)
                                        <button type="button" onclick="lihatBukti('{{ route('payment.proof', $reservation->id) }}')" style="background: none; border: none; color: #3498db; text-decoration: none; font-weight: 700; cursor: pointer; padding: 0; font-size: 13.5px;">👁️ Lihat Struk</button>
                                    @else
                                        <span style="color: #e74c3c; font-weight: 600; font-size: 13px;">Belum Upload</span>
                                    @endif
                                </td>
                                <td align="center">
                                    <!-- Logika untuk menampilkan kata Finished di badge -->
                                    <span class="badge status-{{ $reservation->status }}">
                                        {{ $reservation->status == 'cancelled' ? 'Finished' : ucfirst($reservation->status) }}
                                    </span>
                                </td>
                                <td align="center">
                                    <div style="display: flex; flex-direction: column; gap: 8px;">
                                        <form action="{{ route('admin.reservations.update_status', $reservation->id) }}" method="POST" style="display: flex; gap: 6px; justify-content: center;">
                                            @csrf
                                            <select name="status" required class="form-select">
                                                <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="confirmed" {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                <option value="completed" {{ $reservation->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                <!-- Opsi ke-4: Disimpan sebagai 'cancelled' agar DB aman, tapi ditulis Finished -->
                                                <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>Finished</option>
                                            </select>
                                            <button type="submit" class="btn-action btn-blue">🔄</button>
                                        </form>
                                        <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data pesanan ini selamanya?')" style="width: 100%;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-red">🗑️ Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" align="center" style="padding: 35px; color: #706F8E; font-weight: 500;">Belum ada pesanan Cetak Foto.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Scripts Khusus Admin Dashboard -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Fungsi pop-up SweetAlert
        function lihatBukti(imageUrl) {
            Swal.fire({
                title: 'Bukti Pembayaran',
                text: 'Mengambil data dari brankas rahasia (Private Storage)...',
                imageUrl: imageUrl,
                imageWidth: 400,
                imageAlt: 'Foto Bukti Pembayaran',
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#3A3959',
                backdrop: `rgba(34, 34, 46, 0.8)`
            });
        }

        document.addEventListener('DOMContentLoaded', function() {

            // Script Inisialisasi Chart.js (Grafik Penjualan)
            const ctx = document.getElementById('myChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($labels ?? []) !!},
                        datasets: [{
                            label: 'Jumlah Terpesan',
                            data: {!! json_encode($totals ?? []) !!},
                            backgroundColor: [
                                '#3A3959', '#706F8E', '#3498db', '#f39c12', '#e74c3c', '#2ecc71', '#9b59b6'
                            ],
                            borderWidth: 2,
                            borderColor: '#ffffff',
                            hoverOffset: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'bottom', labels: { font: { family: 'Segoe UI' } } }
                        }
                    }
                });
            }

            // Script Kalender Admin dengan Flatpickr
            let bookedData = {!! json_encode($bookedDatesData ?? []) !!};

            flatpickr("#admin-calendar", {
                inline: true,
                dateFormat: "Y-m-d",
                onDayCreate: function(dObj, dStr, fp, dayElem) {
                    let dateStr = fp.formatDate(dayElem.dateObj, "Y-m-d");

                    if (bookedData[dateStr]) {
                        let info = bookedData[dateStr];

                        if (info.status === 'full') {
                            dayElem.style.backgroundColor = '#FFECEB';
                            dayElem.style.color = '#c0392b';
                            dayElem.style.fontWeight = 'bold';
                            dayElem.title = 'Jadwal Penuh';
                        } else if (info.status === 'partial') {
                            dayElem.style.backgroundColor = '#FFF9E6';
                            dayElem.style.color = '#d35400';
                            dayElem.style.fontWeight = 'bold';
                            dayElem.title = 'Terisi Sebagian (' + info.booked_hours.length + ' sesi)';
                        }
                    }
                }
            });

            // Script AJAX Polling (Notifikasi Real-time)
            let currentPendingCount = {{ $pendingReservations ?? 0 }};

            function checkNewOrders() {
                fetch("{{ route('admin.check_orders') }}")
                    .then(response => response.json())
                    .then(data => {
                        if (data.pending_count > currentPendingCount) {
                            // Pop-up Notifikasi
                            Swal.fire({
                                title: 'Pesanan Baru Masuk!',
                                text: 'Ada pelanggan yang baru saja melakukan reservasi. Halaman akan dimuat ulang...',
                                icon: 'info',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                backdrop: `rgba(58, 57, 89, 0.4)`
                            }).then(() => {
                                window.location.reload();
                            });
                            currentPendingCount = data.pending_count;
                        }
                        else if (data.pending_count < currentPendingCount) {
                            currentPendingCount = data.pending_count;
                        }
                    })
                    .catch(error => console.error('Gagal mengecek pesanan:', error));
            }

            // Cek ke database setiap 10 detik
            setInterval(checkNewOrders, 10000);
        });
    </script>
@endsection
