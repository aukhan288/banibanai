<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;


class MenuController extends Controller
{
    function index(){
        $title='Menu Mangement';
        return view('menu-mangement',compact('title'));
    }
    public function menuList(Request $request) {
        $menus = Menu::paginate($request->input('length', 10));
        
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $menus->total(),
            'recordsFiltered' => $menus->total(),
            'data' => $menus->items(),
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $menu = new Menu();
        $menu->name = $request->name;
        $menu->description = $request->description;

        if ($request->hasFile('thumbnail')) {
            $menu->thumbnail = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $menu->save();

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