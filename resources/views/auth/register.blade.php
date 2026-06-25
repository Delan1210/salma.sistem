@extends('layouts.main')

@section('content')
<style>
    .auth-container {
        max-width: 450px; margin: 80px auto; background: #ffffff; padding: 40px;
        border-radius: 20px; box-shadow: 0 8px 25px rgba(34, 34, 46, 0.05);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; text-align: center;
    }
    .auth-title { color: #3A3959; font-size: 2rem; font-weight: 800; margin-top: 0; margin-bottom: 10px; }
    .auth-subtitle { color: #706F8E; font-size: 1rem; margin-bottom: 30px; }
    .form-group { text-align: left; margin-bottom: 20px; }
    .form-label { display: block; font-weight: bold; color: #22222E; font-size: 0.95rem; margin-bottom: 8px; }
    .form-control {
        width: 100%; padding: 12px 15px; border: 1px solid #ADA9BA; border-radius: 8px;
        box-sizing: border-box; background-color: #fff; color: #22222E; transition: 0.3s;
    }
    .form-control:focus { outline: none; border-color: #3A3959; box-shadow: 0 0 0 3px rgba(58, 57, 89, 0.1); }
    .btn-auth {
        width: 100%; background-color: #3A3959; color: #EAEBE6; padding: 15px; border: none;
        border-radius: 50px; cursor: pointer; font-weight: bold; font-size: 1.1rem;
        transition: 0.3s; margin-top: 10px;
    }
    .btn-auth:hover { background-color: #706F8E; transform: scale(1.02); }
    .auth-link { display: inline-block; margin-top: 25px; color: #706F8E; font-size: 0.95rem; text-decoration: none; }
    .auth-link b { color: #3A3959; }
    .auth-link:hover b { text-decoration: underline; }
    .alert-error {
        background-color: #ffe8e8; color: #e74c3c; padding: 12px; border-radius: 8px;
        margin-bottom: 20px; font-size: 0.9rem; text-align: left;
    }
</style>

<div class="auth-container">
    <h2 class="auth-title">Daftar Akun Baru</h2>
    <p class="auth-subtitle">Lengkapi data diri Anda untuk mulai melakukan pemesanan.</p>

    @if ($errors->any())
        <div class="alert-error">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Contoh: Budi Santoso">
        </div>

        <div class="form-group">
            <label class="form-label">Alamat Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="nama@email.com">
        </div>

        <div class="form-group">
            <label class="form-label">Nomor WhatsApp/Telepon</label>
            <input type="text" name="no_telp" class="form-control" value="{{ old('no_telp') }}" required placeholder="Contoh: 0812xxxxxxx">
        </div>

        <div class="form-group">
            <label class="form-label">Password (Min. 6 Karakter)</label>
            <input type="password" name="password" class="form-control" required placeholder="Buat password aman">
        </div>

        <button type="submit" class="btn-auth">Daftar Akun</button>
    </form>

    <a href="{{ route('login') }}" class="auth-link">
        Sudah punya akun? <b>Login di sini</b>
    </a>
</div>
@endsection
