<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItems extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'order_items';
    protected $fillable = [
        'order_id',
        'product_id',
        'name',
        'price',
        'quantity'
    ];
}
