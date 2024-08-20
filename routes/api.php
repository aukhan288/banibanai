<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/user-create', [App\Http\Controllers\UserController::class, 'createUser'])->name('user.create');
Route::post('/catering-create', [App\Http\Controllers\CateringController::class, 'createCatering'])->name('catering.create');
Route::post('/venu-create', [App\Http\Controllers\VenuController::class, 'createVenu'])->name('venu.create');
Route::get('/userList', [App\Http\Controllers\UserController::class, 'userList']);
Route::get('/cateringList', [App\Http\Controllers\CateringController::class, 'cateringList']);
Route::get('/venuList', [App\Http\Controllers\VenuController::class, 'venuList']);