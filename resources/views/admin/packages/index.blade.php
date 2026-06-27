@extends('layouts.admin')

@section('content')
    <style>
        .dashboard-container {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #22222E;
            margin-top: 10px;
        }

        .box-container {
            background-color: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(58, 57, 89, 0.04);
            border: 1px solid rgba(173, 169, 186, 0.15);
            margin-bottom: 30px;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .table-header h3 {
            margin: 0;
            border-left: 5px solid #3A3959;
            padding-left: 14px;
            color: #3A3959;
            font-weight: 700;
            font-size: 22px;
        }

        /* Tombol Aksi */
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

        .btn-edit { background-color: #706F8E; padding: 7px 16px; border-radius: 6px; box-shadow: none; }
        .btn-edit:hover { background-color: #57557A; }

        .btn-delete { background-color: #e74c3c; padding: 7px 16px; border-radius: 6px; box-shadow: none; font-weight: 600; }
        .btn-delete:hover { background-color: #c0392b; }

        /* Tabel Minimalis Modern */
        .table-responsive {
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid rgba(173, 169, 186, 0.2);
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
            font-size: 14.5px;
            background: white;
        }

        .admin-table th {
            background-color: #F8F9FA;
            padding: 16px 14px;
            font-weight: 700;
            color: #3A3959;
            text-align: left;
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

        .badge-category {
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 700;
            background-color: rgba(58, 57, 89, 0.08);
            color: #3A3959;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>

    <div class="dashboard-container">

        @if (session('success'))
            <div style="color: #27ae60; background-color: #EBF7EE; padding: 16px; margin-bottom: 25px; border-radius: 12px; font-weight: 700; border-left: 5px solid #27ae60; box-shadow: 0 4px 12px rgba(39, 174, 96, 0.05); font-size: 14.5px;">
                ✨ {{ session('success') }}
            </div>
        @endif

        <div class="box-container">
            <div class="table-header">
                <h3>📦 Kelola Paket Studio</h3>
                <a href="{{ route('admin.packages.create') }}" class="btn-action btn-dark">＋ Tambah Paket Baru</a>
            </div>

            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 5%; text-align: center;">No</th>
                            <th style="width: 18%;">Nama Paket</th>
                            <th style="width: 15%; text-align: center;">Kategori</th>
                            <th style="width: 27%;">Deskripsi Singkat</th>
                            <th style="width: 15%;">Harga</th>
                            <th style="width: 10%;">Durasi</th>
                            <th style="width: 10%; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($packages as $index => $package)
                            <tr>
                                <td align="center" style="font-weight: 600; color: #706F8E;">{{ $index + 1 }}</td>
                                <td style="font-weight: 800; color: #3A3959; font-size: 15.5px;">{{ $package->name }}</td>
                                <td align="center">
                                    <span class="badge-category">
                                        {{ $package->category == 'photography' ? '📸 Fotografi' : '🖨️ Cetak Foto' }}
                                    </span>
                                </td>
                                <td style="color: #706F8E; font-size: 13.5px; line-height: 1.5;">
                                    {{ \Illuminate\Support\Str::limit($package->description, 60) }}
                                </td>
                                <td style="font-weight: 800; color: #27ae60; font-size: 15px;">
                                    Rp {{ number_format($package->price, 0, ',', '.') }}
                                </td>
                                <td style="font-weight: 600; color: #3A3959;">
                                    @if($package->duration == '-')
                                        <span style="color: #ADA9BA; font-style: italic; font-size: 13px;">(Tidak Ada)</span>
                                    @else
                                        ⌛ {{ $package->duration }}
                                    @endif
                                </td>
                                <td align="center">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <a href="{{ route('admin.packages.edit', $package->id) }}" class="btn-action btn-edit">Edit</a>
                                        <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus paket {{ $package->name }} ini secara permanen?')" style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" align="center" style="padding: 40px; color: #706F8E; font-weight: 500; font-size: 15px;">
                                    Belum ada data paket yang ditambahkan. Silakan klik "Tambah Paket Baru".
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
