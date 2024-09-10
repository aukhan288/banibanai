<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/user-create', [UserController::class, 'createUser'])->name('user.create');
Route::get('/userList', [UserController::class, 'userList']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);
Route::get('/users/{user}', [UserController::class, 'show']);
Route::put('/users/{user}', [UserController::class, 'update']);
Route::get('/feeList', [App\Http\Controllers\FeeController::class, 'feeList']);
Route::post('/fee-create', [App\Http\Controllers\FeeController::class, 'createFee'])->name('fee.create');
Route::delete('/fees/{fee}', [App\Http\Controllers\FeeController::class, 'destroy']);
Route::get('/fees/{fee}', [App\Http\Controllers\FeeController::class, 'show']);
Route::put('/fees/{fee}', [App\Http\Controllers\FeeController::class, 'update']);
