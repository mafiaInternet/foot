<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'title',
        'imageUrls',
        'category_id',
        'quantity',
        'price',
        'discountedPrice',
        'discountedPersent',
        'description'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    protected $casts = [
        'imageUrls' => 'array', // Chuyển đổi trường imageUrl sang mảng
    ];

    public $timestamps = false;
    use HasFactory;
}
