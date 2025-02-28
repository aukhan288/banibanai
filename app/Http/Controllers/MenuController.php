<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Store;
use App\Models\Category;
use App\Models\MenuProduct;

use Auth;
use Illuminate\Support\Facades\Storage;


class MenuController extends Controller
{
    function index(){
        $title='Menu Mangement';
        $stores=Store::where('user_id',Auth::user()?->id)->get();
        $Categories=Category::where('user_id', Auth::user()?->id)->get();
        return view('menu-mangement',compact('title','stores','Categories'));
    }
    public function menuList(Request $request) {
        $storeIds = Store::where('user_id', Auth::user()?->id)->pluck('id')->toArray();
        $menus = Menu::whereIn('store_id',$storeIds)->paginate($request->input('length', 10));

        
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $menus->total(),
            'recordsFiltered' => $menus->total(),
            'data' => $menus->items(),
        ]);
    }

    public function store(Request $request) {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $menu = new Menu();
        $menu->name = $request->name;
        $menu->description = $request->description;
        $menu->store_id = $request->store_id;

        if ($request->hasFile('thumbnail')) {
            $menu->thumbnail = 'storage/'.$request->file('thumbnail')->store('thumbnails', 'public');
        }

        $menu->save();
        foreach (json_decode($request->products) as $productData) {
            
            
            $MenuProduct=new MenuProduct();
          $MenuProduct->menu_id=$menu->id;
        //   $MenuProduct->category_id=$product->category_id;
          $MenuProduct->product_id=$productData->product_id;

          $MenuProduct->save();
        }
        return response()->json(['success' => 'Menu created successfully.']);
    }

    public function edit($id) {
        $menu = Menu::findOrFail($id);
        return response()->json($menu);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $menu = Menu::findOrFail($id);
        $menu->name = $request->name;
        $menu->description = $request->description;

        if ($request->hasFile('thumbnail')) {
            // Optionally delete the old thumbnail if it exists
            if ($menu->thumbnail) {
                Storage::disk('public')->delete($menu->thumbnail);
            }
            $menu->thumbnail = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $menu->save();

        return response()->json(['success' => 'menu updated successfully.']);
    }

    public function destroy($id) {
        $menu = Menu::findOrFail($id);
        // Optionally delete the thumbnail if it exists
        if ($menu->thumbnail) {
            Storage::disk('public')->delete($menu->thumbnail);
        }
        $menu->delete();

        return response()->json(['success' => 'menu deleted successfully.']);
    }
}
