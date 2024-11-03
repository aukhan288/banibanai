<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuProductController extends Controller
{
    function store(Request $request) {
        dd($request->all());
    }
}
