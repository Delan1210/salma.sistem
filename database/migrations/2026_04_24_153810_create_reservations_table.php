<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::create('reservations', function (Blueprint $table) {
        $table->id();

        // Relasi ke tabel users (Siapa yang pesan)
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        // Relasi ke tabel packages (Paket apa yang dipesan)
        $table->foreignId('package_id')->constrained()->onDelete('cascade');

        // Detail pemotretan
        $table->date('reservation_date');
        $table->time('reservation_time');

        // Status reservasi (default-nya 'pending' saat pertama kali pesan)
        $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
