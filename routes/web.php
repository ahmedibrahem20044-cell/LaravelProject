<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Product Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/category/{category}', [ProductController::class, 'byCategory'])->name('products.byCategory');
Route::post('/products', [ProductController::class, 'store'])->middleware(['auth', 'admin'])->name('products.store');
Route::get('/products/create', [ProductController::class, 'create'])->middleware(['auth', 'admin'])->name('products.create');
Route::put('/products/{product}', [ProductController::class, 'update'])->middleware(['auth', 'admin'])->name('products.update');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->middleware(['auth', 'admin'])->name('products.edit');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->middleware(['auth', 'admin'])->name('products.destroy');

// Category Routes
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::post('/categories', [CategoryController::class, 'store'])->middleware(['auth', 'admin'])->name('categories.store');
Route::get('/categories/create', [CategoryController::class, 'create'])->middleware(['auth', 'admin'])->name('categories.create');
Route::put('/categories/{category}', [CategoryController::class, 'update'])->middleware(['auth', 'admin'])->name('categories.update');
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->middleware(['auth', 'admin'])->name('categories.edit');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->middleware(['auth', 'admin'])->name('categories.destroy');

// Cart Routes
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
});

// Order Routes
Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);
    Route::get('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
