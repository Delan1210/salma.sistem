@extends('layouts.main')

@section('content')

    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="color: #2c3e50; margin: 0;">Riwayat Reservasi Saya</h2>
            <a href="{{ route('catalog') }}"> <!-- Diarahkan ke katalog agar user pilih paket dulu -->
                <button class="btn-primary">+ Buat Reservasi Baru</button>
            </a>
        </div>

        @if (session('success'))
            <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                <strong>Sukses!</strong> {{ session('success') }}
            </div>
        @endif

        <div style="background-color: #e2f3f5; padding: 15px; border-left: 5px solid #17a2b8; margin-bottom: 20px; border-radius: 4px;">
            <strong style="color: #0c5460;">💳 Informasi Paket:</strong><br>
            <span style="color: #333;">Pastikan pembayaran sudah sesuai dengan harga katalog yang dipilih. Jika dirasa ingin mengubah paket, silakan hubungi admin.</span><br>
            <strong style="font-size: 16px; color: #0056b3;">Admin: +62 822-5552-4446 a.n. Salma Photography atau klik logo WhatsApp bagian paling bawah.</strong><br>
            <span style="color: #333; font-size: 14px;">Tolong jika ingin melakukan perubahan harap menghubungi admin minimal 24 jam sebelum tanggal reservasi.</span>
        </div>

        <div style="overflow-x: auto;">
            <table width="100%" style="border-collapse: collapse; min-width: 800px;">
                <thead style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                    <tr>
                        <th style="padding: 12px; text-align: left;">No</th>
                        <th style="padding: 12px; text-align: left;">Paket Pilihan</th>
                        <th style="padding: 12px; text-align: left;">Tanggal & Jam</th>
                        <th style="padding: 12px; text-align: left;">Lokasi / Drive</th>
                        <th style="padding: 12px; text-align: left;">Catatan Saya</th>
                        <th style="padding: 12px; text-align: left;">Status</th>
                        <th style="padding: 12px; text-align: left;">Bukti Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reservations as $index => $reservation)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 12px;">{{ $index + 1 }}</td>
                            <td style="padding: 12px; font-weight: bold; color: #2c3e50;">{{ $reservation->package->name ?? 'Paket Tidak Ditemukan' }}</td>
                            <td style="padding: 12px;">
                                {{ $reservation->reservation_date }} <br>
                                @if($reservation->reservation_time && $reservation->reservation_time != '00:00:00')
                                    <span style="color: #7f8c8d; font-size: 13px;">{{ substr($reservation->reservation_time, 0, 5) }} Wib</span>
                                @endif
                            </td>

                            <td style="padding: 12px;">
                                @if ($reservation->gdrive_link)
                                    <a href="{{ $reservation->gdrive_link }}" target="_blank" style="color: #3498db; text-decoration: none; font-weight: bold;">📁 Buka Folder Drive</a>
                                @elseif ($reservation->location)
                                    {{ $reservation->location }}
                                @else
                                    -
                                @endif
                            </td>

                            <td style="padding: 12px; font-size: 13px; color: #555;">{{ $reservation->notes ?? '-' }}</td>

                            <td style="padding: 12px;">
                                @if($reservation->status == 'pending')
                                    <span style="background-color: #fff3cd; color: #856404; padding: 5px 10px; border-radius: 20px; font-size: 13px; font-weight: bold;">Pending</span>
                                @elseif($reservation->status == 'confirmed')
                                    <span style="background-color: #cce5ff; color: #004085; padding: 5px 10px; border-radius: 20px; font-size: 13px; font-weight: bold;">Confirmed</span>
                                @elseif($reservation->status == 'completed')
                                    <span style="background-color: #d4edda; color: #155724; padding: 5px 10px; border-radius: 20px; font-size: 13px; font-weight: bold;">Selesai</span>
                                @else
                                    <span style="background-color: #f8d7da; color: #721c24; padding: 5px 10px; border-radius: 20px; font-size: 13px; font-weight: bold;">Dibatalkan</span>
                                @endif
                            </td>

                            <td style="padding: 12px;">
                                @if($reservation->status == 'pending')
                                    @if($reservation->payment_proof == null)
                                        <form action="{{ route('reservations.upload_payment', $reservation->id) }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 5px;">
                                            @csrf
                                            <input type="file" name="payment_proof" required style="font-size: 12px;">
                                            <button type="submit" style="background-color: #28a745; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; font-size: 12px;">Upload</button>
                                        </form>
                                    @else
                                        <span style="color: #28a745; font-weight: bold; font-size: 13px;">✔ Terkirim</span><br>
                                        <!-- REVISI: Mengubah link asset menjadi route payment.proof -->
                                        <a href="javascript:void(0);" onclick="lihatBukti('{{ route('payment.proof', $reservation->id) }}')" style="font-size: 13px; color: #0056b3; text-decoration: underline; cursor: pointer;">Lihat Bukti</a>
                                    @endif
                                @else
                                    <!-- Jika status sudah dikonfirmasi/selesai, pelanggan tetap bisa melihat struknya -->
                                    <a href="javascript:void(0);" onclick="lihatBukti('{{ route('payment.proof', $reservation->id) }}')" style="font-size: 13px; color: #0056b3; text-decoration: underline; cursor: pointer;">Lihat Bukti</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" align="center" style="padding: 30px; color: #6c757d;">Kamu belum memiliki riwayat reservasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Script SweetAlert2 untuk memunculkan pop-up gambar -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function lihatBukti(imageUrl) {
            Swal.fire({
                title: 'Bukti Pembayaran',
                text: 'Berikut adalah bukti transfer yang Anda unggah.',
                imageUrl: imageUrl,
                imageWidth: 400, // Lebar pop-up
                imageAlt: 'Foto Bukti Pembayaran',
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#3A3959',
                backdrop: `rgba(34, 34, 46, 0.8)` // Background abu-abu gelap transparan
            });
        }
    </script>

@endsection
