<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeeController extends Controller
{
    function index(){
        $title='Fees';
        return View('fees',compact('title'));
    }
}
