<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('reservations', function (Blueprint $table) {
        // Kita tambahkan kolom location setelah reservation_time
        $table->string('location')->nullable()->after('reservation_time');
    });
}

public function down(): void
{
    Schema::table('reservations', function (Blueprint $table) {
        $table->dropColumn('location');
    });
}
};
