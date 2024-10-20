<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['name', 'mobile', 'province', 'district', 'ward', 'description','user_id'];
    public $timestamps = false;
    public function user(){
        return $this->belongsTo(User::class);
    }
    use HasFactory;
}
