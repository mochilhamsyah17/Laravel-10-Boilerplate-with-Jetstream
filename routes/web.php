<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ToppingController;
use App\Http\Controllers\UserController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/home', [DashboardController::class, 'index'])->name('dashboard.index');

Route::get('/detail-products/{id}', [ProductController::class, 'index'])->name('products.index');

Route::get('/checkout', [ProductController::class, 'checkout'])->name('products.checkout');
Route::post('/checkout', [ProductController::class, 'store'])->name('checkout.store');

Route::get('/confirm', [ProductController::class, 'confirm'])->name('products.confirm');

Route::get('/wait', [ProductController::class, 'wait'])->name('products.wait');

Route::post('/order/save', function (Request $request) {
    session()->put('order', [
        'name' => $request->input('name'),
        'no_meja' => $request->input('no_meja'),
    ]);

    return redirect()->route('dashboard.index');
})->name('order.save');

Route::middleware([
    'auth:sanctum',
    'role:1',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/admin/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/admin/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/admin/user/create', [UserController::class, 'store'])->name('user.store');

    // Inventory
    Route::get('/admin/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/admin/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::get('/admin/inventory/edit/{id}', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::post('/admin/inventory/create', [InventoryController::class, 'store'])->name('inventory.store');
    Route::put('/admin/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/admin/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');

    // Toppings
    Route::get('/admin/topping', [ToppingController::class, 'index'])->name('topping.index');
    Route::get('/admin/topping/create', [ToppingController::class, 'create'])->name('topping.create');
    Route::post('/admin/topping/create', [ToppingController::class, 'store'])->name('topping.store');
});

// routes/web.php
Route::post('/order/add', [OrderController::class, 'addToOrder'])->name('order.add');
Route::post('/order/update-qty', [OrderController::class, 'updateQty'])->name('order.updateQty');

Route::post('/order/store', [ProductController::class, 'storeOrder'])->name('order.storeOrder');

Route::post('/guest/add', [GuestController::class, 'addToGuest'])->name('guest.add');

Route::get('/logout', function () {
    Auth::logout(); // Fungsi untuk logout user
    request()->session()->invalidate(); // Invalidasi sesi
    request()->session()->regenerateToken(); // Regenerasi token CSRF
    return redirect('/login');
});

Route::post('/logout', function () {
    Auth::logout(); // Fungsi untuk logout user
    request()->session()->invalidate(); // Invalidasi sesi
    request()->session()->regenerateToken(); // Regenerasi token CSRF
    return redirect('/login');
})->name('logout');
