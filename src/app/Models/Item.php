<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Userモデル
use App\Models\User;

// Likeモデル
use App\Models\Like;

// Commentモデル
use App\Models\Comment;

// Categoryモデル
use App\Models\Category;

// Conditionモデル
use App\Models\Condition;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'condition_id',
        'category_id',
        'is_sold',
        'user_id',
        'image'
    ];

    // 出品者（1対多） belongsTo
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // いいね（1対多） hasMany
    public function likes(){
        return $this->hasMany(Like::class);
    }

    // コメント（1対多） hasMany
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    // カテゴリ（多対多） belongsToMany
    // 中間テーブル：category_item
    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    // ログイン中のユーザーがこの商品をいいね済みか
    public function isLikedBy($user)
    {
        if (!$user) return false;

        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }
}
