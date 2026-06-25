<h1>Tambah Paket</h1>

<form action="{{ route('packages.store') }}" method="POST">
    @csrf

    <input type="text" name="name" placeholder="Nama Paket"><br>
    <textarea name="description" placeholder="Deskripsi"></textarea><br>
    <input type="number" name="price" placeholder="Harga"><br>
    <input type="text" name="duration" placeholder="Durasi"><br>

    <button type="submit">Simpan</button>
</form>

@if ($errors->any())
    <div style="color:rgb(95, 120, 124);">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
