<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'image',
        'name',
        'category',
        'description',
        'price',
        'duration',
    ];
    public function reservations()
{
    return $this->hasMany(Reservation::class);
}
}

