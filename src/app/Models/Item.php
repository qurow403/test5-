<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Condition;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
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

    public function isLikedBy($user)
    {
        if (!$user) return false;

        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
