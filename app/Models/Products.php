<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
     

    protected $fillable = [
        'name',
        'images',
        'category',
        'price',
        'color',
        'offer_price',
        'offer_duration',
        'sale_count',
        'size',
        'specification',
        'is_fav',
        'is_featured',
        'in_stock',
        'status',
    ];

    protected $casts = [
        'images' => 'array', // since it's stored as JSON
        'is_fav' => 'integer',
        'size' => 'array',
        'color' => 'array',
        'in_stock' => 'integer'
    ];

    /**
     * Relationships
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'id')->latest();
    }

    /**
     * Get average rating
     */
    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }


}

