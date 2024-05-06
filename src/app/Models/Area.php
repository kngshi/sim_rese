<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    
    protected $guarded = [
        'id', 
    ];

    // 関連するショップを取得
    public function shops()
    {
        return $this->hasMany(Shop::class,'area_id');
    }
}