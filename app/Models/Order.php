<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['method', 'totalPrice', 'status', 'address_id'];
    public function address(){
        return $this->belongsTo(Address::class);
    }

    public function items(){
        return $this->hasMany(OrderItem::class);
    }
    use HasFactory;
}
