<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['name', 'imageUrl', 'quantity', 'price', 'price', 'discounted', 'order_id'];
    public $timestamps = false;
    public function order(){
        return $this->belongsTo(Order::class);
    }
    use HasFactory;
}
