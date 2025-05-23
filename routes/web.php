<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
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

Route::get('detail-products', [ProductController::class, 'index'])->name('products.index');

Route::get('/checkout', [ProductController::class, 'checkout'])->name('products.checkout');

Route::get('/confirm', [ProductController::class, 'confirm'])->name('products.confirm');

Route::get('/wait', [ProductController::class, 'wait'])->name('products.wait');

Route::post('/order/save', function (\Illuminate\Http\Request $request) {
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
});

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
