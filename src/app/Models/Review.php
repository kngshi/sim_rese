<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'shop_id', 'rating', 'comment'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function getRatingTextAttribute()
    {
        $ratings = [
            5 => '5:非常に良い',
            4 => '4:良い',
            3 => '3:普通',
            2 => '2:不満',
            1 => '1:非常に不満',
        ];

        return $ratings[$this->rating] ?? '不明';
    }

}
