<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPlace extends Model
{
    use HasFactory;
    protected $table = 'order_place';

    protected $fillable = [
        'user_name',
        'address',
        'email',
        'phone',
        'note',
        'payment_method',
        'subtotal',
        'total'
    ];

        public function order_items()
    {
        return $this->hasMany(Cart::class, 'order_id');
    }
        public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
