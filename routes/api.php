<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoreController;



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

Route::get('/storeList', [StoreController::class, 'storeList']);
Route::post('/store-create', [StoreController::class, 'store'])->name('api.stores.store');
Route::get('/stores/{store}', [StoreController::class, 'show'])->name('api.stores.show');
Route::put('/stores/{store}', [StoreController::class, 'update'])->name('api.stores.update');
Route::delete('/stores/{store}', [StoreController::class, 'destroy'])->name('api.stores.destroy');