<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'item_id',
        'buyer_id',
        'status',
        'seller_id',
        'status',
        'buyer_rating',
        'seller_rating',
        'buyer_rated_at',
        'seller_rated_at',
        'shipping_name',
        'shipping_postcode',
        'shipping_address',
        'shipping_tel',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }
}
