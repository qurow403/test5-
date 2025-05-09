<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'user_id',
        'content',
    ];

    // 商品（Item）とのリレーション（多対1）
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // ユーザー（User）とのリレーション（多対1）
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
