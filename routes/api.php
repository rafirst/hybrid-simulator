<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleModelController;
use App\Http\Controllers\SimulationLogController;

Route::get('/vehicle-model', [VehicleModelController::class, 'getStoredModel']);
Route::post('/vehicle-model/upload', [VehicleModelController::class, 'upload']);
Route::post('/simulation-log', [SimulationLogController::class, 'store']);
