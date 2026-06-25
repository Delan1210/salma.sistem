<div style="background: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 8px 25px rgba(34, 34, 46, 0.05); display: flex; flex-direction: column; transition: transform 0.3s, box-shadow 0.3s; text-align: center;"
     onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 15px 35px rgba(34, 34, 46, 0.1)'"
     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(34, 34, 46, 0.05)'">

    <div style="width: 100%; height: 220px; overflow: hidden; background-color: #EAEBE6; display: flex; align-items: center; justify-content: center;">
        @if($package->image)
            <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->name }}" style="width: 100%; height: 100%; object-fit: cover;">
        @else
            <svg width="50" height="50" viewBox="0 0 24 24" fill="#ADA9BA">
                <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
            </svg>
        @endif
    </div>

    <div style="padding: 25px; display: flex; flex-direction: column; flex: 1;">

        <h3 style="margin-top: 0; color: #3A3959; font-size: 1.5rem; font-weight: 800;">{{ $package->name }}</h3>

        <p style="color: #22222E; height: 65px; font-size: 1rem; overflow-y: auto; line-height: 1.6; margin-bottom: 10px;">
            {{ $package->description }}
        </p>

        <h2 style="color: #706F8E; margin: 10px 0 15px 0; font-size: 1.4rem;">
            Rp {{ number_format($package->price, 0, ',', '.') }}
        </h2>

        @if($package->duration && $package->duration != '-')
            <div>
                <span style="font-size: 14px; color: #3A3959; font-weight: bold; background-color: #EAEBE6; padding: 6px 15px; border-radius: 50px; display: inline-block;">
                    ⏱️ Durasi: {{ $package->duration }}
                </span>
            </div>
        @else
            <div style="height: 31px; margin: 0;"></div>
        @endif

        <hr style="border: 0; border-top: 1px solid #ADA9BA; opacity: 0.3; margin: 20px 0;">

        <a href="{{ route('reservations.create', ['package_id' => $package->id]) }}" style="text-decoration: none; margin-top: auto;">
            <button style="width: 100%; background-color: #3A3959; color: #EAEBE6; padding: 12px; border: none; border-radius: 50px; cursor: pointer; font-weight: bold; font-size: 1.1rem; transition: background-color 0.3s;"
                    onmouseover="this.style.backgroundColor='#706F8E'"
                    onmouseout="this.style.backgroundColor='#3A3959'">
                {{ $buttonText ?? 'Pesan Sekarang' }}
            </button>
        </a>

    </div>
</div>
