<?php

use App\Http\Resources\OrderItemResource;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderItemService implements OrderItemDao{
    public function createOrderItem (Request $request){
        $validator = Validator::make($request->all(), [
            'method'=> 'required|string',
            'totalPrice' => 'required|integer',
            'status' => 'required|string',
            'address_id' => 'required|exists:address,id'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 442);
        }

        $data = $validator->validate();
        $orderItem = OrderItem::create($data);
        return response()->json([
            'message' => 'Create address by user',
            'address' => new OrderItemResource($orderItem)
        ], 202);
    }

}

?>
