<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\StoreType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    function index(){
        $title='Stores';
        $storeType = StoreType::select(['id', 'name'])->get();
        $storeStatuses = DB::select('select * from store_statuses');
        return View('stores',compact('title','storeType','storeStatuses'));
    }


    
    function storeList(Request $request)
    {
        $users = Store::with('storeType')->paginate($request->input('length', 10)); // Default is 10 records per page
    
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $users->total(),
            'recordsFiltered' => $users->total(),
            'data' => $users->items(),
        ]);
    }
    
    public function store(Request $request)
    {

        // Handle the image upload
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
    
            // Check if the file is valid before calling store()
            if ($thumbnail && $thumbnail->isValid()) {
                $thumbnailPath = $thumbnail->store('thumbnails', 'public');
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid file upload.'
                ], 400);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No file was uploaded.'
            ], 400);
        }

        $store = Store::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'store_type_id' => $request->store_type_id,
            'thumbnail' => Storage::url($thumbnailPath), // Save the path to the database
            'min_delevery_time' => $request->min_delevery_time,
            'min_order' => $request->min_order,
            'rating' => $request->rating,
            'opning_time' => $request->opning_time,
            'address' => $request->address,
            'lat' => $request->lat,
            'long' => $request->long,
            'ntn' => $request->ntn,
            'delivery_type' => $request->delivery_type,
            'delivery_fee' => $request->delivery_fee,
            'delivery_radius' => $request->delivery_radius,
            'commission' => $request->commission,
            'platform_fee' => $request->platform_fee,
            'venu_fee' => $request->venu_fee,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Store created successfully.',
            'data' => $store
        ], 201);
    }

    public function update(Request $request, Store $store)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'store_type_id' => 'required|integer',
            'thumbnail' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate the image if it's present
            // Add validation rules for other fields
        ]);

        // Handle the image upload
        if ($request->hasFile('thumbnail')) {
            // Delete the old thumbnail if it exists
            if ($store->thumbnail) {
                Storage::disk('public')->delete($store->thumbnail);
            }

            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $store->thumbnail = $thumbnailPath;
        }

        $store->update([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'store_type_id' => $request->store_type_id,
            'min_delevery_time' => $request->min_delevery_time,
            'min_order' => $request->min_order,
            'rating' => $request->rating,
            'opning_time' => $request->opning_time,
            'address' => $request->address,
            'lat' => $request->lat,
            'long' => $request->long,
            'ntn' => $request->ntn,
            'delivery_type' => $request->delivery_type,
            'delivery_fee' => $request->delivery_fee,
            'delivery_radius' => $request->delivery_radius,
            'commission' => $request->commission,
            'platform_fee' => $request->platform_fee,
            'venu_fee' => $request->venu_fee,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Store updated successfully.',
            'data' => $store
        ]);
    }
    
    public function destroy(Store $store)
    {
        $store->delete();
        return response()->json(['success' => true, 'message' => 'User deleted successfully']);
    }
}
