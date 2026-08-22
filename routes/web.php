<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SimulatorController;
use App\Http\Controllers\VehicleModelController;
use App\Http\Controllers\SimulationLogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [SimulatorController::class, 'index'])->name('simulator.index');

// API & AJAX Endpoints
Route::get('/api/model/stored', [VehicleModelController::class, 'getStoredModel'])->name('api.model.stored');
Route::post('/api/model/upload', [VehicleModelController::class, 'upload'])->name('api.model.upload');
Route::post('/api/log/interaction', [SimulationLogController::class, 'store'])->name('api.log.interaction');
