<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    // モデルと関連しているテーブル名
    protected $guarded = [
        'id', 
    ];

    // 関連するショップを取得
    public function shops()
    {
        return $this->hasMany(Shop::class, 'genre_id');
    }
}
