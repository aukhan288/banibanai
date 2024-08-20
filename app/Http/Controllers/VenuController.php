<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venu;
class VenuController extends Controller
{
    function index(){
        $title='Venus';
        return View('venus',compact('title'));
    }

    function createVenu(Request $request){
        $venu=Venu::create([
            'user_id' => $request->user_id,
            "name" => $request->name,
            "address" => $request->address,

        ]);
    }
    
    function venuList(Request $request)
    {
        $venu = Venu::with('user')->paginate($request->input('length', 10)); // Default is 10 records per page
    
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $venu->total(),
            'recordsFiltered' => $venu->total(),
            'data' => $venu->items(),
        ]);
    }
}
