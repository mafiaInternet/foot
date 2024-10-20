<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $category;
    public function __construct()
    {
        $this->category = new Category();
    }
    public function index()
    {
        $query = Category::query();
        $categories = $query->paginate(10)->onEachSide(1);

        return inertia("Category/Index", [
            "categories" => CategoryResource::collection($categories)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'name_id' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $validatedata = $validator->validate();

        $category = Category::create($validatedata);

        return Inertia::render('Category/Index', [
            'message' => "Create category success!!!",
            'categories' => CategoryResource::collection(Category::all())
        ]);
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $category = Category::findOrFail($id);
        return Inertia::render('Category/Show', [
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|boolean', // Kiểm tra giá trị status
        ]);
        $category = Category::findOrFail($id);
        Log::info('Status: ' . $request->status);
        $category->status = $request->status;
        $category->save();
        return redirect()->route('category.index')->with('success', 'Category update successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category deleted successfully!');
    }

    public function create_factory()
    {
        $query = Category::query();
        $categories = $query->insert([
            [
                'name_id' => 'san-pham',
                'name' => 'Tất cả sản phẩm'
            ],
            [
                'name_id' => 'qua-tang',
                'name' => 'Quà tặng'
            ],
            [
                'name_id' => 'trai-cay-tuoi-fresh-fruit',
                'name' => 'Trái cây tươi - fresh fruit'
            ]
        ]);
        return response()->json([
            'status' => 200,
            'message' => "Success categories!",
            'categories' => $categories
        ]);
 
    }

    public function getCategories(){
        return response()->json(
            CategoryResource::collection(Category::all())
        );
    } 
}
