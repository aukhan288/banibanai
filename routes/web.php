<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MenuController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::post('/store-create', [StoreController::class, 'store']);
Route::post('/user-create', [UserController::class, 'createUser'])->name('user.create');
// Route::middleware(['checkStore'])->group(function () {
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
Route::get('/stores', [StoreController::class, 'index'])->name('stores');
Route::get('/storeList', [StoreController::class, 'storeList']);

Route::get('/stores/{id}', [StoreController::class, 'show']);
Route::put('/stores/{id}', [StoreController::class, 'update']);
Route::delete('/stores/{id}', [StoreController::class, 'destroy']);
Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders');
Route::get('/fees', [App\Http\Controllers\FeeController::class, 'index'])->name('fees');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::get('/categoryList', [CategoryController::class, 'CategoryList']);
Route::post('/category-create', [CategoryController::class, 'store']);
Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/category/{id}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/productList', [ProductController::class, 'ProductList']);
Route::post('/product-create', [ProductController::class, 'store']);
Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/product/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('/menu-mangement', [MenuController::class, 'index'])->name('menu-mangement');
Route::get('/menuList', [MenuController::class, 'menuList']);
Route::post('/menu-create', [MenuController::class, 'store']);
Route::get('/menu/{id}/edit', [MenuController::class, 'edit'])->name('menu.edit');
Route::put('/menu/{id}', [MenuController::class, 'update'])->name('menu.update');
Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

// });