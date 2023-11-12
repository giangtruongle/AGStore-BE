<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orders extends Model
{
    use HasFactory,SoftDeletes;
        protected $table = 'orders';

        const STATUS_PENDING = 'pending';
        const STATUS_SUCCESS = 'success';
        const STATUS_CANCEL = 'cancel';
        const STATUS_SHIPPING = 'shipping';
        const STATUS_FAILED = 'failed';

    protected $fillable = [
        'user_name',
        'address',
        'email',
        'phone',
        'note',
        'payment_method',
        'subtotal',
        'total',
        'status'
    ];
    public function order_items(){
        return $this->hasMany(OrderItems::class,'order_id','id');
    }
}
