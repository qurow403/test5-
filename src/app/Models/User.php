<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     // Item モデルとの 1対多 リレーション
    //  出品した商品（1対多）
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    // いいね（1対多） hasMany
    public function likes() {
        return $this->hasMany(Like::class);
    }

    // いいねした商品（多対多）
    // 中間テーブル likes を介した多対多(ユーザー ⇔ 商品)
    public function likedItems(){
        return $this->belongsToMany(Item::class, 'likes')->withTimestamps();
    }

    // コメント機能（1対多）
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // このユーザーがある商品に対して「いいね済み」か？
    public function hasLiked(Item $item)
    {
        return $this->likedItems()->where('item_id', $item->id)->exists();
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function purchasedItems()
    {
        return $this->belongsToMany(Item::class, 'purchases')->withTimestamps();
    }
}
