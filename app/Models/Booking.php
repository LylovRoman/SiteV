<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'bookings';
    protected $guarded = [];

    function from()
    {
        $this->hasOne(Flight::class, 'id', 'flight_from');
    }

    function back()
    {
        $this->hasOne(Flight::class, 'id', 'flight_back');
    }
}
