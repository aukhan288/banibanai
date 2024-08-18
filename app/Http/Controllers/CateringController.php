<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catering;
use Illuminate\Support\Facades\Auth;

class CateringController extends Controller
{
    function index(){
        $title='Caterings';
        return View('caterings',compact('title'));
    }

    function createCatering(Request $request){
        $catering=Catering::create([
            'user_id' => $request->user_id,
            "name" => $request->name,
            "address" => $request->address,

        ]);
    }
    
    function cateringList(Request $request)
    {
        $catering = Catering::with('user')->paginate($request->input('length', 10)); // Default is 10 records per page
    
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $catering->total(),
            'recordsFiltered' => $catering->total(),
            'data' => $catering->items(),
        ]);
    }
}