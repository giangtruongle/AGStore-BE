<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use HasFactory, Notifiable,SoftDeletes;
    protected $table = "product_category";

      public $fillable = [
        'id',
        'name',
        'slug',
        'image_url_pc',
        'status',

    ];

    public function products(){
        return $this->hasMany(Product::class, 'product_category_id')->withTrashed();
    }
}
