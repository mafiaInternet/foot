<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function items(){
        return $this->hasMany(CartItem::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    use HasFactory;
}
