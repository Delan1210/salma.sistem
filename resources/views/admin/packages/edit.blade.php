@extends('layouts.admin')

@section('content')
<style>

    .dashboard-container {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #22222E;
        display: flex;
        justify-content: center;
        margin-top: 20px;
        margin-bottom: 40px;
    }

    .admin-form-box {
        background-color: white;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(58, 57, 89, 0.04);
        border: 1px solid rgba(173, 169, 186, 0.15);
        width: 100%;
        max-width: 700px;
    }

    .form-header {
        margin-bottom: 30px;
        border-bottom: 2px dashed #EAEBE6;
        padding-bottom: 20px;
    }

    .form-header h3 {
        margin: 0;
        color: #3A3959;
        font-size: 22px;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-group { margin-bottom: 24px; }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #706F8E;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 14px 16px;
        border-radius: 8px;
        border: 1px solid #ADA9BA;
        font-size: 14.5px;
        color: #22222E;
        outline: none;
        font-family: inherit;
        transition: all 0.3s ease;
        background-color: #FAFAFA;
        box-sizing: border-box;
    }

    .form-control:focus {
        border-color: #3A3959;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(58, 57, 89, 0.1);
    }

    .form-text {
        display: block;
        color: #ADA9BA;
        font-size: 12.5px;
        margin-top: 6px;
        font-weight: 500;
    }

    .btn-action {
        padding: 12px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14.5px;
        font-weight: 700;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-submit {
        background-color: #3A3959;
        color: white;
        box-shadow: 0 4px 15px rgba(58, 57, 89, 0.15);
        min-width: 150px;
    }

    .btn-submit:hover {
        background-color: #22222E;
        transform: translateY(-2px);
    }

    .btn-cancel {
        background-color: transparent;
        color: #706F8E;
        border: 2px solid #EAEBE6;
        margin-left: 12px;
    }

    .btn-cancel:hover {
        border-color: #ADA9BA;
        color: #22222E;
    }

    .error-box {
        background-color: #FFECEB;
        color: #c0392b;
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 25px;
        border-left: 4px solid #e74c3c;
        font-size: 14px;
    }

    /* Style Preview Gambar */
    .image-preview-box {
        margin-top: 10px;
        margin-bottom: 15px;
        display: inline-block;
        padding: 8px;
        border: 1px dashed #ADA9BA;
        border-radius: 8px;
        background: #FAFAFA;
    }

    .image-preview-box img {
        max-height: 150px;
        border-radius: 6px;
        display: block;
    }
</style>

<div class="dashboard-container">
    <div class="admin-form-box">
        <div class="form-header">
            <h3>✏️ Edit Paket Studio</h3>
        </div>

        @if ($errors->any())
            <div class="error-box">
                <strong style="display: block; margin-bottom: 8px;">Terdapat Kesalahan:</strong>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Nama Paket</label>
                <input type="text" name="name" value="{{ $package->name }}" class="form-control" required>
            </div>

            <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                <div class="form-group" style="flex: 1; min-width: 200px;">
                    <label class="form-label">Kategori Paket</label>
                    <select name="category" id="kategori" class="form-control" onchange="aturDurasi()" required>
                        <option value="photography" {{ $package->category == 'photography' ? 'selected' : '' }}>Paket Photography</option>
                        <option value="cetak" {{ $package->category == 'cetak' ? 'selected' : '' }}>Paket Cetak Foto</option>
                    </select>
                </div>

                <div class="form-group" style="flex: 1; min-width: 200px;">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ $package->price }}" class="form-control" required>
                </div>
            </div>

            <div class="form-group" id="bungkus-durasi">
                <label class="form-label">Durasi Pemotretan</label>
                <input type="text" name="duration" id="input-durasi" value="{{ $package->duration }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi & Fasilitas</label>
                <textarea name="description" rows="4" class="form-control" required>{{ $package->description }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Foto Contoh Paket (Opsional)</label>

                @if($package->image)
                    <div class="image-preview-box">
                        <img src="{{ asset('storage/' . $package->image) }}" alt="Preview Paket">
                    </div>
                @endif

                <input type="file" name="image" accept="image/*" class="form-control" style="padding: 11px 15px; background-color: #ffffff;">
                <span class="form-text">Biarkan kosong jika tidak ingin mengubah foto yang sudah ada.</span>
            </div>

            <div style="margin-top: 35px; padding-top: 25px; border-top: 1px solid #EAEBE6; display: flex; align-items: center;">
                <button type="submit" class="btn-action btn-submit">Update Paket</button>
                <a href="{{ route('admin.packages.index') }}" class="btn-action btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
    function aturDurasi() {
        let kategori = document.getElementById('kategori').value;
        let bungkusDurasi = document.getElementById('bungkus-durasi');
        let inputDurasi = document.getElementById('input-durasi');

        if (kategori === 'cetak') {
            bungkusDurasi.style.display = 'none';
            inputDurasi.removeAttribute('required');
            if(inputDurasi.value === '') {
                 inputDurasi.value = '-';
            }
        } else {
            bungkusDurasi.style.display = 'block';
            inputDurasi.setAttribute('required', 'required');
            if(inputDurasi.value === '-') {
                inputDurasi.value = '';
            }
        }
    }

    window.onload = function() {
        aturDurasi();
    };
</script>
@endsection
