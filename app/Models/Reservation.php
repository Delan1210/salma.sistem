<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $guarded = ['id']; // Membolehkan semua kolom diisi kecuali ID

    // Reservasi ini milik siapa?
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Reservasi ini untuk paket apa?
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
