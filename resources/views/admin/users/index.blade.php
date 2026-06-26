@extends('layouts.admin')

@section('content')
    <!-- ==========================================
         PREMIUM STYLING UNTUK KELOLA AKUN
         ========================================== -->
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

        /* Badge Role Pastel */
        .badge-role {
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
            display: inline-block;
            letter-spacing: 0.5px;
        }
        .role-admin {
            background-color: rgba(52, 152, 219, 0.15);
            color: #2980b9;
        }
        .role-customer {
            background-color: rgba(112, 111, 142, 0.15);
            color: #706F8E;
        }

        /* Form Controls & Tombol */
        .form-select {
            padding: 7px 12px;
            border-radius: 6px;
            border: 1px solid #ADA9BA;
            font-size: 13.5px;
            color: #22222E;
            outline: none;
            background-color: #ffffff;
            font-family: inherit;
            font-weight: 500;
            cursor: pointer;
            transition: border-color 0.3s;
        }
        .form-select:focus { border-color: #3A3959; }

        .btn-action {
            padding: 7px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 700;
            color: white;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(58, 57, 89, 0.1);
        }
        .btn-green { background-color: #27ae60; }
        .btn-green:hover { background-color: #219653; transform: translateY(-1px); }

        .self-alert {
            font-size: 12.5px;
            color: #ADA9BA;
            font-style: italic;
            font-weight: 500;
        }

        .you-badge {
            font-size: 11px;
            color: #27ae60;
            font-weight: 700;
            margin-left: 6px;
            background: #EBF7EE;
            padding: 2px 6px;
            border-radius: 4px;
        }
    </style>

    <div class="dashboard-container">

        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div style="color: #27ae60; background-color: #EBF7EE; padding: 16px; margin-bottom: 25px; border-radius: 12px; font-weight: 700; border-left: 5px solid #27ae60; box-shadow: 0 4px 12px rgba(39, 174, 96, 0.05); font-size: 14.5px;">
                ✨ {{ session('success') }}
            </div>
        @endif

        <div class="box-container">
            <div class="table-header">
                <h3>👥 Kelola Hak Akses Pengguna</h3>
            </div>

            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 5%; text-align: center;">No</th>
                            <th style="width: 20%;">Nama</th>
                            <th style="width: 25%;">Email</th>
                            <th style="width: 15%;">No Telepon</th>
                            <th style="width: 15%; text-align: center;">Role Saat Ini</th>
                            <th style="width: 20%; text-align: center;">Ubah Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $user)
                            <tr>
                                <td align="center" style="font-weight: 600; color: #706F8E;">{{ $index + 1 }}</td>

                                <td>
                                    <span style="font-weight: 800; color: #3A3959; font-size: 15px;">{{ $user->name }}</span>
                                    @if(Auth::id() == $user->id)
                                        <span class="you-badge">(Kamu)</span>
                                    @endif
                                </td>

                                <td style="color: #495057;">{{ $user->email }}</td>

                                <td style="font-weight: 500; color: #706F8E;">
                                    {{ $user->no_telp ?? '-' }}
                                </td>

                                <td align="center">
                                    @if(strtolower($user->role) == 'admin')
                                        <span class="badge-role role-admin">Admin</span>
                                    @else
                                        <span class="badge-role role-customer">Customer</span>
                                    @endif
                                </td>

                                <td align="center">
                                    @if(Auth::id() == $user->id)
                                        <span class="self-alert">Tidak bisa edit diri sendiri</span>
                                    @else
                                        <!-- Pastikan rute action di bawah ini sesuai dengan rute aslimu ya! -->
                                        <form action="{{ route('admin.users.update_role', $user->id) }}" method="POST" style="display: flex; gap: 8px; justify-content: center; margin: 0;">
                                            @csrf
                                            <select name="role" required class="form-select">
                                                <option value="customer" {{ strtolower($user->role) == 'customer' ? 'selected' : '' }}>Customer</option>
                                                <option value="admin" {{ strtolower($user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                            <button type="submit" class="btn-action btn-green">Simpan</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" align="center" style="padding: 40px; color: #706F8E; font-weight: 500; font-size: 15px;">
                                    Belum ada data pengguna yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
