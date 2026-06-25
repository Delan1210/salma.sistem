<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('reservations', function (Blueprint $table) {
        // Kita gunakan text karena URL seringkali panjang, dan nullable karena hanya untuk paket cetak
        $table->text('gdrive_link')->nullable()->after('location');
    });
}

public function down(): void
{
    Schema::table('reservations', function (Blueprint $table) {
        $table->dropColumn('gdrive_link');
    });
}
};
