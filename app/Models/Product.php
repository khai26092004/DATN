<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        // 'category_id',
        'name',
        'slug',
        'description',
        'price',
        'image',
        'stock_quantity'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }
}
