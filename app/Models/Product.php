<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;
protected $table = 'product';

public $fillable = [
    'name',
    'slug',
    'price',
    'original_price',
    'description',
    'quantity',
    'size',
    'image_url',
    'status',
    'product_category_id',
];

public function categoryItem(){
    return $this->belongsTo(ProductCategory::class, 'product_category_id')->withTrashed();
}

}
