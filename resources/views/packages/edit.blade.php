<h1>Edit Paket</h1>

<form action="{{ route('packages.update', $package->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $package->name }}"><br>
    <textarea name="description">{{ $package->description }}</textarea><br>
    <input type="number" name="price" value="{{ $package->price }}"><br>
    <input type="text" name="duration" value="{{ $package->duration }}"><br>

    <button type="submit">Update</button>
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
