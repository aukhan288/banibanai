<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    function index(){
        $title='Orders';
        return View('orders',compact('title'));
    }
}
