<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Item;

class Like extends Model
{
    protected $fillable = [
        'user_id',
        'item_id'
    ];

    // ユーザーとのリレーション
    public function user(){
        return $this->belongsTo(User::class);
    }

    // 商品とのリレーション
    public function item(){
        return $this->belongsTo(Item::class);
    }
}
