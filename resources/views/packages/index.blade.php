<h1>Daftar Paket</h1>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<a href="{{ route('packages.create') }}">Tambah Paket</a>

<table border="1">
    <tr>
        <th>Nama</th>
        <th>Harga</th>
        <th>Durasi</th>
        <th>Aksi</th>
    </tr>

    @foreach($packages as $p)
    <tr>
        <td>{{ $p->name }}</td>
        <td>Rp {{ number_format($p->price, 0, ',', '.') }}</td>
        <td>{{ $p->duration }}</td>
        <td>
            <a href="{{ route('packages.edit', $p->id) }}">Edit</a>

            <form action="{{ route('packages.destroy', $p->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
@if(session('success'))
    <div style="color: rgb(133, 201, 247);">
        {{ session('success') }}
    </div>
@endif
</table>
