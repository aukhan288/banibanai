<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\StoreType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    function index(){
        $title='Stores';
        // $storeType = StoreType::select(['id', 'name'])->get();
        $storeStatuses = DB::select('select * from store_statuses');
        return View('stores',compact('title','storeStatuses'));
    }


    
    function storeList(Request $request)
    {
        $users = Store::when(Auth::user()->role->slug == 'catering', function($q) {
            return $q->where('user_id', Auth::id());
        })
        ->with('storeStatus')
        ->paginate($request->input('length', 10)); // Default is 10 records per page
        
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $users->total(),
            'recordsFiltered' => $users->total(),
            'data' => $users->items(),
        ]);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'ntn' => 'required|numeric',
            'thumbnail' => 'nullable|image',
            'opning_time' => 'required|date_format:H:i',
            'address' => 'required|string',
            'long' => 'required|numeric',
            'lat' => 'required|numeric',
            'min_delevery_time' => 'required|string',
            'min_order' => 'required|numeric',
            'delivery_type' => 'required|string',
            'delivery_radius' => 'required|numeric',
            'commission' => 'required|numeric',
            'platform_fee' => 'required|numeric',
            'delivery_fee' => 'required|numeric',
            'venu_fee' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $store = new Store($request->except('thumbnail'));

        if ($request->hasFile('thumbnail')) {
            $store->thumbnail = $request->file('thumbnail')->store('thumbnails');
        }


        $store->user_id=Auth::id();
        $store->save();

        return response()->json(['message' => 'Store created successfully'], 201);
    }

    // Display the specified resource
    public function show($id)
    {
        $store = Store::with('storeType')->findOrFail($id);
        return response()->json($store);
    }

    // Update the specified resource in storage
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'store_type_id' => 'required|exists:store_types,id',
            'ntn' => 'required|numeric',
            'thumbnail' => 'nullable|image',
            'opning_time' => 'required',
            'address' => 'required|string',
            'long' => 'required|numeric',
            'lat' => 'required|numeric',
            'min_delevery_time' => 'required|string',
            'min_order' => 'required|numeric',
            'delivery_type' => 'required|string',
            'delivery_radius' => 'required|numeric',
            'commission' => 'required|numeric',
            'platform_fee' => 'required|numeric',
            'delivery_fee' => 'required|numeric',
            'venu_fee' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $store = Store::findOrFail($id);
        $store->fill($request->except('thumbnail'));

        if ($request->hasFile('thumbnail')) {
            if ($store->thumbnail) {
                Storage::delete($store->thumbnail);
            }
            $store->thumbnail = $request->file('thumbnail')->store('thumbnails');
        }

        $store->save();

        return response()->json(['message' => 'Store updated successfully']);
    }

    // Remove the specified resource from storage
    public function destroy($id)
    {
        $store = Store::findOrFail($id);

        if ($store->thumbnail) {
            Storage::delete($store->thumbnail);
        }

        $store->delete();

        return response()->json(['message' => 'Store deleted successfully']);
    }
}
