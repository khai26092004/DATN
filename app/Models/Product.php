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
        'characteristics',
        'light',
        'watering',
        'usage',
        'meaning',
        'price',
        'image',
        'stock_quantity'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
