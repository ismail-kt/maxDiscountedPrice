<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Homecontroller;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [Homecontroller::class, 'index'])->name('show.products');
Route::post('/addt_tocart', [Homecontroller::class, 'store'])->name('add.cart');
Route::delete('/delete/{id}', [Homecontroller::class, 'remove'])->name('remove.cart');
Route::get('/clear_cart', [Homecontroller::class, 'destroy'])->name('clear.cart');
Route::get('/update/cart/{id}', [Homecontroller::class, 'update'])->name('update.cart');


