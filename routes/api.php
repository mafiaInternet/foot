<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::post('/products/create', [ProductController::class, 'store'])->name('products.store');
Route::get('categories/create', [CategoryController::class, 'create_factory'])->name('categories.create_factory');
Route::get('categories', [CategoryController::class, 'getCategories'])->name('categories.getCategories');

Route::get('products', [ProductController::class, 'getProducts'])->name('products.getProducts');
Route::get('product/{id}', [ProductController::class, 'getProductById'])->name('products.getProductById');

Route::post('login', [UserController::class, 'login'])->name('user.login');
Route::get('profile', [UserController::class, 'profile'])->name('user.profile');

Route::post('cart', [CartController::class, 'addItem'])->name('cart.addItem');
Route::get('cart', [CartController::class, 'getCart'])->name('cart.getCart');
Route::delete('cart/item/{id}/delete', [CartController::class, 'deleteItemToCart'])->name('cart.deleteItemToCart');
Route::put('cart/item/{id}/update', [CartController::class, 'update'])->name('cart.update');

Route::get('address', [AddressController::class, 'getAddresses'])->name('address.getAddresses');
Route::post('address', [AddressController::class, 'create'])->name('address.create');
Route::put('address/{id}/update', [AddressController::class, 'update'])->name('address.update');
Route::delete('address/{id}/delete', [AddressController::class, 'delete'])->name('address.delete');
