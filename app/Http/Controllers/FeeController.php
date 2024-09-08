<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fee;

class FeeController extends Controller
{
    function index(){
        $title='Fees';
        return View('fees',compact('title'));
    }

    function createFee(Request $request){
        $fee=Fee::create([
            "from" => $request->priceFrom,
            "to" => $request->priceTo,
            "commission" => $request->commision

        ]);
    }

    function feeList(Request $request)
    {
        $fees = Fee::paginate($request->input('length', 10)); // Default is 10 records per page
    
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $fees->total(),
            'recordsFiltered' => $fees->total(),
            'data' => $fees->items(),
        ]);
    }

    public function destroy(Fee $fee)
    {
        $fee->delete();
        return response()->json(['success' => true, 'message' => 'User deleted successfully']);
    }
}
