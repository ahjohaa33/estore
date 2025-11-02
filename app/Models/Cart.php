<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Cart extends Model
{
    protected $fillable = ['token','user_id','status','currency'];
    public function items(): HasMany { return $this->hasMany(CartItem::class); }

    protected static function booted() {
        static::creating(function (Cart $cart) {
            if (!$cart->token) $cart->token = (string) Str::uuid();
        });
    }

    public function totals(): array {
        $subtotal = (float) $this->items->sum(fn($i) => $i->qty * $i->unit_price);
        return ['subtotal'=>$subtotal, 'discount'=>0.0, 'shipping'=>0.0, 'tax'=>0.0, 'total'=>$subtotal];
    }
}
