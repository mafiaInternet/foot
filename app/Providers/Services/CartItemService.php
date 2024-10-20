<?php
namespace App\Providers\Services;
use App\Models\CartItem;
use App\Providers\Services\Dao\CartItemDao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartItemService implements CartItemDao{
    public function  create(Request $request){   
       
      $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:255',
        'imageUrl' => 'required|string',
        'quantity' => 'required|integer',
        'product_id' => 'required|exists:products,id',
        'cart_id' => 'required|exists:carts,id'
      ]);
      
      if($validator->fails()){
        return response()->json([
          "message" => "Validation error",
          "error" => $validator->errors()
        ], 422);
      }
      $data = $validator->validated();
      $data['product_id'] = $request->input('product_id');
      $cartItem = CartItem::create($data);

      return $cartItem;
    } 
}

?>