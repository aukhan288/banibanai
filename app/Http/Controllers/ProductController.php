<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Auth;

class ProductController extends Controller
{
    public function index() {
        $title = "Items";
        $categories=Category::where('user_id', Auth::user()?->id)->orderBy('name','asc')->get(['id','name']);
        return view('products', compact('title','categories')); // Ensure the view name matches your structure
    }

    public function productList(Request $request) {
        $categoriesId = Category::where('user_id', Auth::user()?->id)->pluck('id')->toArray();
        
        $products = Product::whereIn('category_id',$categoriesId)->paginate($request->input('length', 10));
        
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $products->total(),
            'recordsFiltered' => $products->total(),
            'data' => $products->items(),
        ]);
    }

    public function store(Request $request) {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        //     'category' => 'require|numeric',
        //     'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        // ]);
     
        $product = new Product();
        $product->name = $request->name;
        $product->category_id = $request->category;
        $product->description = $request->description;
        $product->minNumOfChoices = $request->minNumOfChoices;
        $product->maxNumOfChoices = $request->maxNumOfChoices;
        $product->choiceGroupName = $request->choiceGroupName;
        $product->minNumOfChoicesGroup = $request->minNumOfChoicesGroup;
        $product->maxNumOfChoicesGroup = $request->maxNumOfChoicesGroup;
        $product->itemVariations = json_encode($request->itemVariations);
        $product->customChoices = $request->customChoices;
        $product->flatChoices = $request->flatChoices;

        if ($request->hasFile('thumbnail')) {
            $product->thumbnail = 'storage/'.$request->file('thumbnail')->store('thumbnails', 'public');
        }
        $product->save();

        return response()->json(['success' => 'Product created successfully.']);
    }

    public function edit($id) {
        $product = Product::findOrFail($id);
        return response()->json($products);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->description = $request->description;

        if ($request->hasFile('thumbnail')) {
            // Optionally delete the old thumbnail if it exists
            if ($product->thumbnail) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            $product->thumbnail = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $product->save();

        return response()->json(['success' => 'product updated successfully.']);
    }

    public function destroy($id) {
        $product = Product::findOrFail($id);
        // Optionally delete the thumbnail if it exists
        if ($product->thumbnail) {
            Storage::disk('public')->delete($product->thumbnail);
        }
        $product->delete();

        return response()->json(['success' => 'product deleted successfully.']);
    }
    public function ProductsByCategory($category) {
        $category = Category::find($category);

        if (!$category) {
            return response()->json([
                'success' => false,
                'status' => 404,
                'message' => 'Category not found'
            ], 404);
        }
    
        // Get the products for the specified category
        $products = Product::where('category_id', $category->id)->get();
    
        // Check if products were found
        if ($products->isEmpty()) {
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'No products found for this category',
                'data' => []
            ]);
        }
    
        // Return the products as a JSON response
        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Products retrieved successfully',
            'data' => $products
        ]);
    }
}
