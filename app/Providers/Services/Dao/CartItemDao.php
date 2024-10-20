<?php
namespace App\Providers\Services\Dao;
use Illuminate\Http\Request;

interface CartItemDao {
    public function create(Request $request);
}

?>