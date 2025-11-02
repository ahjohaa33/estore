<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public function products(){
        $this->belongsTo(Products::class, 'id', 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')
            ->select(['id','name','avatar']); // adjust columns
    }
}
