<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return view('welcome');
});

// Módulo Roles: ahora incluye show
    Route::resource('roles', RoleController::class);