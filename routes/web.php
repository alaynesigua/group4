<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


//inventory
Route::get('/inventory/user', [InventoryController::class, 'index'])->name('inventory.products');
Route::get('/inventory/admin', [InventoryController::class, 'admin'])->name('inventory.admin');
Route::get('/inventory/newProduct', [InventoryController::class, 'admin2'])->name('inventory.newProduct');
Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
Route::get('/inventory/edit/{inventory}', [InventoryController::class, 'edit'])->name('inventory.edit');
Route::put('/inventory/update/{inventory}', [InventoryController::class, 'update'])->name('inventory.update');
Route::delete('/inventory/destroy/{inventory}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
