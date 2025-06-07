<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseOrderItemController;
use App\Http\Controllers\ReceptionController;
use App\Http\Controllers\ReceptionItemController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProductLocationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Módulo Roles
Route::resource('roles', RoleController::class);
// Módulo Usuarios
Route::resource('users', UserController::class);
// Módulo Proveedores
Route::resource('suppliers', SupplierController::class);
// Módulo Categorías
Route::resource('categories', CategoryController::class);
// Módulo Productos	
Route::resource('products', ProductController::class);
// Módulo Compras
Route::resource('purchases', PurchaseOrderController::class);
// Detalle de compra
Route::resource('purchase_orders.items', PurchaseOrderItemController::class)
    ->shallow()
    ->only(['store', 'edit', 'update', 'destroy']);
// Módulo Recepciones
Route::resource('receptions', ReceptionController::class);
// Detalle de recepción
Route::resource('receptions.items', ReceptionItemController::class)
    ->shallow()
    ->only(['store', 'edit', 'update', 'destroy']);
// Módulo ubicaciones
    Route::resource('locations', LocationController::class);
// Modulo de productos por ubicación
Route::resource('product_locations', ProductLocationController::class);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
