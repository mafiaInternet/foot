<?php

use Illuminate\Http\Request;

interface OrderItemDao {
    public function createOrderItem (Request $request);
}
?>