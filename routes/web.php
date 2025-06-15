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
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas y de Autenticación
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Carga las rutas de login, register, etc. desde auth.php
require __DIR__ . '/auth.php';


/*
|--------------------------------------------------------------------------
| Panel de Control (Rutas Protegidas por Autenticación)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // --- RUTAS COMUNES PARA TODOS LOS ROLES LOGUEADOS ---
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');


    // --- RUTAS DE GESTIÓN (Protegidas por Roles Específicos) ---

    // Grupo para acciones que solo el Supervisor puede realizar
    Route::middleware(['role:supervisor'])->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/notifications/create', [NotificationController::class, 'createManual'])->name('notifications.create-manual');
        Route::post('/notifications', [NotificationController::class, 'storeManual'])->name('notifications.store-manual');
    });
    
    // Grupo para Supervisor y Compras (Gestión de catálogos y compras)
    Route::middleware(['role:supervisor,purchasing'])->group(function () {
        Route::resource('suppliers', SupplierController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('purchases', PurchaseOrderController::class);

        Route::post('purchases/{purchase}/approve', [PurchaseOrderController::class, 'approve'])
            ->name('purchases.approve')
            ->middleware('role:supervisor'); // La aprobación sigue siendo solo del supervisor
    });

    // Grupo para Supervisor y Almacén (Gestión de stock físico)
    Route::middleware(['role:supervisor,warehouse'])->group(function () {
        Route::post('purchases/{purchase}/receive', [PurchaseOrderController::class, 'registerReception'])
            ->name('purchases.receive');
        
        Route::resource('entries', StockEntryController::class)->only(['create', 'store']);
        Route::resource('exits', StockExitController::class)->only(['create', 'store']);
        Route::resource('discrepancies', DiscrepancyReportController::class);

        Route::post('discrepancies/{discrepancy}/adjust', [DiscrepancyReportController::class, 'adjustStock'])
            ->name('discrepancies.adjust')
            ->middleware('role:supervisor'); // El ajuste final es solo del supervisor
    });

    // Grupo para rutas de solo lectura de historiales (accesibles para todos los roles logueados)
    Route::get('stock-entries', [StockEntryController::class, 'index'])->name('entries.index');
    Route::get('stock-entries/{stock_entry}', [StockEntryController::class, 'show'])->name('entries.show');
    Route::get('stock-exits', [StockExitController::class, 'index'])->name('exits.index');
    Route::get('stock-exits/{stock_exit}', [StockExitController::class, 'show'])->name('exits.show');
});