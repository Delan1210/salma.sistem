@extends('layouts.admin')

@section('content')
    <!-- ==========================================
         PREMIUM REPORT STYLING (WEB & PRINT)
         ========================================== -->
    <style>
        .dashboard-container {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #22222E;
            margin-top: 10px;
        }

        /* Kotak Filter Premium */
        .filter-card {
            background-color: white;
            padding: 25px 30px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(58, 57, 89, 0.05);
            border: 1px solid rgba(173, 169, 186, 0.15);
            margin-bottom: 30px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px dashed #EAEBE6;
            padding-bottom: 15px;
        }

        .filter-header h3 {
            margin: 0;
            color: #3A3959;
            font-size: 18px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Form Filter */
        .form-filter-group {
            display: flex;
            align-items: flex-end;
            gap: 20px;
            flex-wrap: wrap;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .input-group label {
            font-size: 13px;
            font-weight: 700;
            color: #706F8E;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            padding: 10px 15px;
            border-radius: 8px;
            border: 1px solid #ADA9BA;
            font-size: 14px;
            color: #22222E;
            outline: none;
            font-family: inherit;
            transition: all 0.3s;
            min-width: 180px;
        }
        .form-control:focus { border-color: #3A3959; box-shadow: 0 0 0 3px rgba(58, 57, 89, 0.1); }

        /* Area Laporan */
        .report-box {
            background-color: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(58, 57, 89, 0.04);
            border: 1px solid rgba(173, 169, 186, 0.15);
            margin-bottom: 40px;
        }

        .report-title-area {
            text-align: center;
            margin-bottom: 30px;
        }

        .report-title-area h2 {
            margin: 0 0 10px 0;
            color: #3A3959;
            font-size: 24px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .report-title-area p {
            margin: 0;
            color: #706F8E;
            font-size: 15px;
            font-weight: 500;
        }

        /* Tabel Modern */
        .table-responsive { overflow-x: auto; }
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
            font-size: 14px;
        }
        .admin-table th {
            background-color: #F8F9FA;
            padding: 14px;
            font-weight: 700;
            color: #3A3959;
            text-align: left;
            border-bottom: 2px solid #EAEBE6;
            font-size: 13px;
            text-transform: uppercase;
        }
        .admin-table td {
            padding: 14px;
            border-bottom: 1px solid #EAEBE6;
            color: #22222E;
            vertical-align: middle;
        }

        /* Badges */
        .badge { padding: 5px 12px; border-radius: 50px; font-size: 11px; font-weight: 700; display: inline-block; }
        .status-pending { background-color: #FFF9E6; color: #D35400; }
        .status-confirmed { background-color: #EBF5FF; color: #2980b9; }
        .status-completed { background-color: #EBF7EE; color: #27ae60; }
        .status-finished { background-color: #FFECEB; color: #3A3959; }

        /* Tombol */
        .btn-action {
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            color: white;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-dark { background-color: #3A3959; }
        .btn-dark:hover { background-color: #22222E; }
        .btn-outline { background-color: transparent; border: 2px solid #ADA9BA; color: #706F8E; }
        .btn-outline:hover { border-color: #3A3959; color: #3A3959; }
        .btn-print { background-color: #2980b9; box-shadow: 0 4px 15px rgba(41, 128, 185, 0.2); }
        .btn-print:hover { background-color: #1f6391; transform: translateY(-2px); }
        .btn-small { padding: 6px 12px; font-size: 12px; border-radius: 6px; background-color: #f39c12; }

        /* ==========================================
           CSS KHUSUS SAAT DICETAK (PRINT MEDIA)
           ========================================== */
        @media print {
            .no-print, .filter-card, .btn-action, .hide-on-print {
                display: none !important;
            }

            body, .dashboard-container, .main-content {
                background-color: white !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
            }

            .report-box {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .admin-table {
                width: 100% !important;
                border: 1px solid #000 !important;
            }
            .admin-table th, .admin-table td {
                border: 1px solid #000 !important;
                padding: 10px !important;
                color: #000 !important;
                background-color: transparent !important;
            }
            .admin-table th {
                background-color: #f0f0f0 !important;
                -webkit-print-color-adjust: exact;
            }
            a { text-decoration: none !important; color: #000 !important; }
        }
    </style>

    <div class="dashboard-container">

        <!-- BAGIAN 1: KOTAK FILTER -->
        <div class="filter-card no-print">
            <div class="filter-header">
                <h3>🔍 Filter Data Laporan</h3>
                <div style="display: flex; gap: 10px;">
                    <button onclick="window.print()" class="btn-action btn-print">🖨️ Cetak / Save PDF</button>
                    <a href="{{ route('admin.reservations.index') }}" class="btn-action btn-outline">Kembali ke Dashboard</a>
                </div>
            </div>

            <form action="{{ route('admin.reservations.report') }}" method="GET" class="form-filter-group">
                <div class="input-group">
                    <label for="start_date">Dari Tanggal</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>

                <div class="input-group">
                    <label for="end_date">Sampai Tanggal</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>

                <!-- TAMBAHAN: Dropdown Kategori -->
                <div class="input-group">
                    <label for="category">Kategori</label>
                    <select name="category" id="category" class="form-control">
                        <option value="">Semua Kategori</option>
                        <option value="photography" {{ request('category') == 'photography' ? 'selected' : '' }}>Photography</option>
                        <option value="cetak_foto" {{ request('category') == 'cetak_foto' ? 'selected' : '' }}>Cetak Foto</option>
                    </select>
                </div>

                <!-- TAMBAHAN: Dropdown Status -->
                <div class="input-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <!-- Menggunakan value="cancelled" tapi tampilannya "Finished" -->
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Finished</option>
                    </select>
                </div>

                <div style="display: flex; gap: 10px; margin-bottom: 2px;">
                    <button type="submit" class="btn-action btn-dark">Filter Data</button>
                    <a href="{{ route('admin.reservations.report') }}" class="btn-action btn-outline">Reset</a>
                </div>
            </form>
        </div>

        <!-- BAGIAN 2: KERTAS LAPORAN -->
        <div class="report-box">
            <div class="report-title-area">
                <h2>Laporan Data Reservasi Salma Photography</h2>
                <p>Periode:
                    @if(request('start_date') && request('end_date'))
                        <strong>{{ request('start_date') }}</strong> s/d <strong>{{ request('end_date') }}</strong>
                    @else
                        <strong>Semua Waktu</strong>
                    @endif
                </p>
            </div>

            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 5%; text-align: center;">No</th>
                            <th style="width: 15%;">Nama Pelanggan</th>
                            <th style="width: 15%;">Lokasi</th>
                            <th style="width: 12%;">Paket Pilihan</th>
                            <th style="width: 18%;">Catatan</th>
                            <th style="width: 12%; text-align: center;">Tgl Pemotretan</th>
                            <th style="width: 13%; text-align: center;">Bukti Bayar</th>
                            <th style="width: 10%; text-align: center;">Status</th>
                            <th class="hide-on-print" style="width: 10%; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reservations ?? [] as $index => $reservation)
                            <tr>
                                <td align="center" style="font-weight: 600;">{{ $index + 1 }}</td>

                                <td>
                                    @if(str_contains($reservation->notes, '[OFFLINE]'))
                                        <span style="font-weight: 700;">{{ str_replace('[OFFLINE] A/N: ', '', $reservation->notes) }}</span>
                                    @else
                                        <span style="font-weight: 700;">{{ $reservation->user->name ?? 'User Dihapus' }}</span>
                                    @endif
                                </td>

                                <td>{{ $reservation->location ?? '-' }}</td>

                                <td style="font-weight: 600;">{{ $reservation->package->name ?? '-' }}</td>

                                <td style="font-size: 13px; line-height: 1.4;">
                                    @if(!str_contains($reservation->notes, '[OFFLINE]'))
                                        {{ $reservation->notes ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td align="center" style="font-weight: 600;">{{ $reservation->reservation_date }}</td>

                                <td align="center">
                                    @if (str_contains($reservation->payment_proof, 'offline'))
                                        <span>Cash / COD</span>
                                    @elseif ($reservation->payment_proof)
                                        <a href="{{ asset('storage/' . $reservation->payment_proof) }}" target="_blank" style="color: #2980b9; font-weight: 600;">Lihat Foto</a>
                                    @else
                                        <span style="color: #706F8E;">Belum Ada</span>
                                    @endif
                                </td>

                                <td align="center">
                                    <!-- Logika untuk mengubah teks Cancelled menjadi Finished -->
                                    @if(strtolower($reservation->status) == 'cancelled')
                                        <span class="badge status-cancelled">FINISHED</span>
                                    @else
                                        <span class="badge status-{{ strtolower($reservation->status) }}">{{ strtoupper($reservation->status) }}</span>
                                    @endif
                                </td>

                                <td align="center" class="hide-on-print">
                                    <a href="{{ route('admin.reservations.index') }}" class="btn-action btn-small">Kelola</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" align="center" style="padding: 30px; color: #706F8E;">
                                    Tidak ada data laporan untuk kriteria pencarian ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
