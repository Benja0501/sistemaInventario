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
        // Aquí podrían ir rutas de configuración general del sistema.
    });


    // --- RUTAS PARA COMPRAS Y SUPERVISOR ---
    // Estos roles gestionan los catálogos y el proceso de compra.
    Route::middleware(['role:supervisor,purchasing'])->group(function () {
        Route::resource('suppliers', SupplierController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('purchases', PurchaseOrderController::class);

        // Ruta específica para que el Supervisor apruebe una orden de compra
        Route::post('purchase-orders/{purchase_order}/approve', [PurchaseOrderController::class, 'approve'])
            ->name('purchase-orders.approve')
            ->middleware('role:supervisor');
    });


    // --- RUTAS PARA ALMACÉN Y SUPERVISOR ---
    // Estos roles gestionan el inventario físico y los movimientos.
    Route::middleware(['role:supervisor,warehouse'])->group(function () {
        // Ruta para registrar la recepción de una orden de compra
        Route::post('purchase-orders/{purchase_order}/receive', [PurchaseOrderController::class, 'registerReception'])
            ->name('purchase-orders.receive');

        // Rutas para registrar salidas manuales (merma, etc.)
        Route::resource('exits', StockExitController::class)->only(['create', 'store']);

        // Rutas para los informes de discrepancia
        Route::resource('discrepancy-reports', DiscrepancyReportController::class);

        // Ruta para que el Supervisor apruebe el ajuste de stock de un informe
        Route::post('discrepancy-reports/{discrepancy_report}/adjust', [DiscrepancyReportController::class, 'adjustStock'])
            ->name('discrepancy-reports.adjust')
            ->middleware('role:supervisor');
        Route::get('stock-entries/create', [StockEntryController::class, 'create'])->name('stock-entries.create');
        Route::post('stock-entries', [StockEntryController::class, 'store'])->name('stock-entries.store');
    });

    // --- RUTAS DE CONSULTA ---
    // Rutas que solo muestran información y podrían ser accesibles para más roles
    Route::get('entries', [StockEntryController::class, 'index'])->name('entries.index');
    Route::get('exits', [StockExitController::class, 'index'])->name('exits.index');

});