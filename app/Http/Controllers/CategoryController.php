<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index() {
        $title = "Categories";
        $categories = Category::all();
        return view('categories', compact('title','categories')); // Ensure the view name matches your structure
    }

    public function categoryList(Request $request) {
        $categories = Category::paginate($request->input('length', 10));
        
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $categories->total(),
            'recordsFiltered' => $categories->total(),
            'data' => $categories->items(),
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->parent_id = $request->parent_id;
        $category->description = $request->description;

        if ($request->hasFile('thumbnail')) {
            $category->thumbnail = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $category->save();

        return response()->json(['success' => 'Category created successfully.']);
    }

    public function edit($id) {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->description = $request->description;

        if ($request->hasFile('thumbnail')) {
            // Optionally delete the old thumbnail if it exists
            if ($category->thumbnail) {
                Storage::disk('public')->delete($category->thumbnail);
            }
            $category->thumbnail = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $category->save();

        return response()->json(['success' => 'Category updated successfully.']);
    }

    public function destroy($id) {
        $category = Category::findOrFail($id);
        // Optionally delete the thumbnail if it exists
        if ($category->thumbnail) {
            Storage::disk('public')->delete($category->thumbnail);
        }
        $category->delete();

        return response()->json(['success' => 'Category deleted successfully.']);
    }
}
