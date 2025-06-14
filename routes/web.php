<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\StockEntryController;
use App\Http\Controllers\StockExitController;
use App\Http\Controllers\DiscrepancyReportController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación
|--------------------------------------------------------------------------
|
| Login, registro (solo para el primer usuario), reseteo de contraseña, etc.
|
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Panel de Control (Rutas Protegidas)
|--------------------------------------------------------------------------
|
| Todas estas rutas requieren que el usuario haya iniciado sesión.
|
*/
Route::middleware(['auth'])->group(function () {

    // --- RUTAS COMUNES PARA TODOS LOS ROLES ---
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });


    // --- RUTAS SOLO PARA EL SUPERVISOR ---
    // El Supervisor tiene control total sobre la gestión de usuarios.
    Route::middleware(['role:supervisor'])->group(function () {
        Route::resource('users', UserController::class);
    });


    // --- RUTAS PARA COMPRAS Y SUPERVISOR ---
    // Estos roles gestionan los catálogos y el proceso de compra.
    Route::middleware(['role:supervisor,purchasing'])->group(function () {
        Route::resource('suppliers', SupplierController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('purchases', PurchaseOrderController::class);

        // Ruta específica para que el Supervisor apruebe una orden de compra
        Route::post('purchases/{purchase}/approve', [PurchaseOrderController::class, 'approve'])
            ->name('purchases.approve')
            ->middleware('role:supervisor');
    });


    // --- RUTAS PARA ALMACÉN Y SUPERVISOR ---
    Route::middleware(['role:supervisor,warehouse'])->group(function () {
        Route::post('purchases/{purchase}/receive', [PurchaseOrderController::class, 'registerReception'])
            ->name('purchases.receive');
        
        // --- RUTAS CORREGIDAS Y UNIFICADAS ---
        Route::resource('exits', StockExitController::class)->only(['index', 'create', 'store']);
        Route::resource('discrepancies', DiscrepancyReportController::class);
        Route::get('entries/create', [StockEntryController::class, 'create'])->name('entries.create');
        Route::post('entries', [StockEntryController::class, 'store'])->name('entries.store');
        
        Route::post('discrepancies/{discrepancy}/adjust', [DiscrepancyReportController::class, 'adjustStock'])
            ->name('discrepancies.adjust')
            ->middleware('role:supervisor');
    });

    // --- RUTAS DE CONSULTA ---
    // Rutas que solo muestran información y podrían ser accesibles para más roles
    Route::get('entries', [StockEntryController::class, 'index'])->name('entries.index');

});
