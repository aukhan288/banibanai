<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    public function index() {
        $title = "Products";
        return view('products', compact('title')); // Ensure the view name matches your structure
    }

    public function productList(Request $request) {
        $products = Product::paginate($request->input('length', 10));
        
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $products->total(),
            'recordsFiltered' => $products->total(),
            'data' => $products->items(),
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;

        if ($request->hasFile('thumbnail')) {
            $product->thumbnail = $request->file('thumbnail')->store('thumbnails', 'public');
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
        $product = Products::findOrFail($id);
        // Optionally delete the thumbnail if it exists
        if ($product->thumbnail) {
            Storage::disk('public')->delete($product->thumbnail);
        }
        $product->delete();

        return response()->json(['success' => 'product deleted successfully.']);
    }
}
