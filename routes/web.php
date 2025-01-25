<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Artisan;

Route::get('/run-migration', function() {
    Artisan::call('optimize:clear');
    Artisan::call('migrate:refresh --seed');
    return "Migrations executed successfully";
});


Route::get('/', [ProductController::class, 'index']);

Route::get('/products/create', [ProductController::class, 'create'])->middleware('auth_user');

Route::post('/products', [ProductController::class, 'store'])->middleware('auth_user');


Route::post('/products/{product}/bid', [ProductController::class, 'placeBid'])->middleware('auth_user')->name('products.bid');

Route::post('/products/{product}/pay', [ProductController::class, 'pay'])->middleware('auth_user');

Route::post('/products/{product}/received', [ProductController::class, 'received'])->middleware('auth_user');

Route::get('/products/manage', [ProductController::class, 'manage'])->middleware('auth_user');

Route::get('/products/bids', [ProductController::class, 'bids'])->middleware('auth_user');



Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->middleware('auth_user');
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::put('/products/{product}', [ProductController::class, 'update'])->middleware('auth_user');
Route::delete('/products/{product}', [ProductController::class, 'delete'])->middleware('auth_user');



Route::get('/register', [UserController::class, 'register'])->middleware('guest');
Route::post('/users', [UserController::class, 'store'])->middleware('guest');
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth_user');

Route::get('/login', [UserController::class, 'login'])->middleware('guest')->name('login');
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

Route::get('/users/{user}/edit', [UserController::class, 'edit'])->middleware('auth_user');
Route::get('/users/{user}', [UserController::class, 'show'])->middleware('auth_user');

Route::put('/users/{user}', [UserController::class, 'update'])->middleware('auth_user');
Route::get('/users', [UserController::class, 'index'])->middleware('auth_admin');
Route::delete('/users/{user}', [UserController::class, 'delete'])->middleware('auth_user');

Route::get('/about', function () {
    return view('about');
});

