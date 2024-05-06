<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','shop_id','date', 'time', 'number'];


    public function reservations()
    {
    return $this->belongsToMany(User::class, 'user_reservation', 'shop_id', 'user_id')->withPivot('date', 'time', 'number');

    return $this->belongsToMany(Shop::class, 'user_reservation', 'user_id', 'shop_id')->withPivot('date', 'time', 'number');

    }


}
