<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
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
use App\Http\Controllers\DiscrepancyController;
use App\Http\Controllers\BatchController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
|
| Sólo la página de bienvenida queda accesible sin iniciar sesión.
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


/*
|--------------------------------------------------------------------------
| Autenticación (Login, Register, Password Reset…)
|--------------------------------------------------------------------------
|
| Estas rutas NO requieren que el usuario esté logueado.
|
*/
require __DIR__ . '/auth.php';


/*
|--------------------------------------------------------------------------
| Panel Administrativo
|--------------------------------------------------------------------------
|
| Todas estas rutas requieren que el usuario esté autenticado (y verificado,
| en el caso del dashboard). Si no quieres el middleware `verified`, bórralo.
|
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [HomeController::class, 'dashboard'])
        ->name('dashboard');

    // Perfil de Usuario
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // CRUD completos
    Route::resources([
        'roles' => RoleController::class,
        'users' => UserController::class,
        'suppliers' => SupplierController::class,
        'categories' => CategoryController::class,
        'products' => ProductController::class,
        'purchase_orders' => PurchaseOrderController::class,
        'receptions' => ReceptionController::class,
        'locations' => LocationController::class,
        'product_locations' => ProductLocationController::class,
        'discrepancies' => DiscrepancyController::class,
        'batches' => BatchController::class,
    ]);

    // Ítems de Purchase Orders (anidado + shallow)
    Route::resource('purchase_orders.items', PurchaseOrderItemController::class)
        ->shallow()
        ->only(['store', 'edit', 'update', 'destroy']);

    // Ítems de Receptions (anidado + shallow)
    Route::resource('receptions.items', ReceptionItemController::class)
        ->shallow()
        ->only(['store', 'edit', 'update', 'destroy']);
});
