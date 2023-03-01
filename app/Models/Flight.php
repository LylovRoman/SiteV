<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $table = 'flights';
    protected $guarded = [];

    function from()
    {
        return $this->hasOne(Airport::class, 'id', 'from_id');
    }
    function to()
    {
        return $this->hasOne(Airport::class, 'id', 'to_id');
    }
}
