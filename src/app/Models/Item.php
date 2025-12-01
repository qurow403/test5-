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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function isLikedBy($user)
    {
        if (!$user) return false;

        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
