<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Artisan;

// Route::get('/welcome', function () {
//     return view('welcome');
// })->middleware('guest');

Route::get('/run-migration', function() {
    Artisan::call('optimize:clear');
    Artisan::call('migrate:refresh --seed');
    return "Migrations executed successfully";
});


// All Products
Route::get('/', [ProductController::class, 'index']);


// Show Create Form
Route::get('/products/create', [ProductController::class, 'create'])->middleware('auth_user');

// Store Product Data
Route::post('/products', [ProductController::class, 'store'])->middleware('auth_user');


// Place a Bid on a Product
Route::post('/products/{product}/bid', [ProductController::class, 'placeBid'])->middleware('auth_user')->name('products.bid');

// Pay for a Product
Route::post('/products/{product}/pay', [ProductController::class, 'pay'])->middleware('auth_user');

// Mark a Product as Received
Route::post('/products/{product}/received', [ProductController::class, 'received'])->middleware('auth_user');


// Manage Products
Route::get('/products/manage', [ProductController::class, 'manage'])->middleware('auth_user');

// Manage Bids
Route::get('/products/bids', [ProductController::class, 'bids'])->middleware('auth_user');



// Edit Single Product
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->middleware('auth_user');

// Show Single Product
Route::get('/products/{product}', [ProductController::class, 'show']);

// Update Single Product
Route::put('/products/{product}', [ProductController::class, 'update'])->middleware('auth_user');

// Delete Single Product
Route::delete('/products/{product}', [ProductController::class, 'delete'])->middleware('auth_user');



// Show Register Form
Route::get('/register', [UserController::class, 'register'])->middleware('guest');

// Store New User Data
Route::post('/users', [UserController::class, 'store'])->middleware('guest');

// Log User Out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth_user');

// Show Login Form
Route::get('/login', [UserController::class, 'login'])->middleware('guest')->name('login');

// Log User In
Route::post('/users/authenticate', [UserController::class, 'authenticate']);


// Edit Single Product
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->middleware('auth_user');

// // Edit Single Product
// Route::get('/users/{user}/products', [UserController::class, 'products'])->middleware('auth_user');

// Show Profile Page
Route::get('/users/{user}', [UserController::class, 'show'])->middleware('auth_user');

// Update Single Product
Route::put('/users/{user}', [UserController::class, 'update'])->middleware('auth_user');

// Store New User Data
Route::get('/users', [UserController::class, 'index'])->middleware('auth_admin');

// Delete Single Product
Route::delete('/users/{user}', [UserController::class, 'delete'])->middleware('auth_user');

Route::get('/about', function () {
    return view('about');
});

