<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
        use HasFactory;

    protected $fillable = [
        'customer_name',
        'phone',
        'email',
        'address',
        'shipping_address',
        'delivery_charge',
        'subtotal',
        'total',
        'status',
    ];

    /**
     * Relationships
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
