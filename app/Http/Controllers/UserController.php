<?php

namespace App\Http\Controllers;


use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $secretKey;
    public function __construct()
    {
        $this->secretKey = env('SECRET_KEY'); // Đặt bí mật từ .env
    }
    //
    public function index()
    {
        $query = User::query();
        $users = $query->paginate(10)->onEachSide(1);
        return inertia("User/Index", [
            "messager" => "Success!",
            "users" => $users
        ], 202);
    }

    public function login(LoginRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $request->authenticate();

        // Tạo payload cho JWT
        $payload = [
            'iat' => time(), // Thời gian tạo token
            'exp' => time() + 60 * 60, // Thời gian hết hạn (1 giờ)
            'sub' => Auth::id(), // ID người dùng
        ];

        // Tạo JWT
        $token = JWT::encode($payload, $this->secretKey, 'HS256');
    
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,

        ], 200);
    }

    public function profile(Request $request){
        $token = $request->bearerToken();
      
        if (!$token) {
            return response()->json(['error' => "Authenticated"], 401);
        }
        
    try {
        $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
        $user = User::find($decoded->sub);
        return response()->json([
            'user' => new UserResource($user)
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Token invalid'], 401);
    }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return inertia("User/Index",  [
            "message" => "Delete sser success!!"
        ]);
    }
}
