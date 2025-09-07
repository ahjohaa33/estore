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
        'size',
        'specification',
        'is_fav',
        'in_stock',
        'status',
    ];

    protected $casts = [
        'images' => 'array', // since it's stored as JSON
        'is_fav' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get average rating
     */
    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }
}
