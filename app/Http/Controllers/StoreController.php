<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\StoreType;

class StoreController extends Controller
{
    function index(){
        $title='Stores';
        $storeType = StoreType::select(['id', 'name'])->get();
        return View('stores',compact('title','storeType'));
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
}
