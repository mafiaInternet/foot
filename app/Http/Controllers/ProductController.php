<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

use function Termwind\render;

class ProductController extends Controller
{

    public function index(){
        $query = Product::query();

        $products = $query->paginate(10)->onEachSide(1);
        return inertia('Product/Index', [
            'products'=> ProductResource::collection($products)
        ]);
    }

    public function show($id){
        $product = Product::find($id);
        $categories = Category::all();
        return Inertia::render('Product/Show', [
            'categories' => CategoryResource::collection($categories),
            "product" => $product
        ]);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'imageUrls' => 'nullable|array',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
            'discountedPrice' => 'nullable|numeric|min:0',
            'discountedPersent' => 'nullable|integer|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $validatedData = $validator->validated();

        $product = Product::findOrFail($id);
        $product->update($validatedData);
        return Inertia::location(route('product.index'));
    }
    public function create(){
        $categories = Category::all();
        
        return Inertia::render('Product/Show', [
            'categories' => CategoryResource::collection($categories),
            'product' =>  null
        ]);
    }



    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'imageUrls' => 'nullable|array',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
            'discountedPrice' => 'nullable|numeric|min:0',
            'discountedPersent' => 'nullable|integer|min:0|max:100',
            'description' => 'string|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $validatedData = $validator->validated();


        $product = Product::create($validatedData);

        return Inertia::location(route('product.index')); // Đúng

    }

    public function deleteProductById ($id){
     
        $product = Product::findOrFail($id);  // Tìm sản phẩm theo ID
    $product->delete();
    return Inertia::location(route('product.index'));
    }

    public function getProducts (){
        return response()->json(ProductResource::collection(Product::all()));
    }

    public function getProductById ($id) {
        return response()->json(Product::findOrFail($id));
    }
}
