<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartItemResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;
use App\Providers\Services\Dao\CartItemDao;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    //
    private $cartItemDao;
    private $secretKey;

    public function __construct(CartItemDao $cartItemDao){
        $this->cartItemDao = $cartItemDao;
        $this->secretKey = env('SECRET_KEY');
    }

    public function addItem(Request $request){
      
        $cartItem = $this->cartItemDao->create($request);
      
        return response()->json([
            "message" => "Add Item Success!!!",
            "cartItem" => $cartItem
        ]);
    }

    public function getCart(Request $request){
        $token = $request->bearerToken();
        try{

            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            $cart = Cart::where('user_id', $decoded->sub)->first();
            $cartItems = CartItem::where('cart_id', $cart->id)->get();
            return response()->json([
                "cartItems" => CartItemResource::collection($cartItems)
                // "cart" => $cartItems
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Token invalid'], 401);
        }
       
    }

    public function deleteItemToCart($id, Request $request){
        $token = $request->bearerToken();
        try{

            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            $user = User::find($decoded->sub);
            CartItem::find($id)->delete();
     
            return response()->json([
                "message" => "Delete Item Success!!!"
           
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Token invalid'], 401);
        }
    }

    public function update($id, Request $request){
        $token = $request->bearerToken();
        try{

            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            $user = User::find($decoded->sub);
            $cartItem = CartItem::find($id);
            $cartItem->update(['quantity' => $request->quantity, 'status' => $request->status]);
            return response()->json([
                "message" => "Update Item Success!!!"
                
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Token invalid'], 401);
        }
    }
}
