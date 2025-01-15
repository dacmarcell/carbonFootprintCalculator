<?php

use App\Http\Controllers\CarbonFootprintController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post("/calculate", [CarbonFootprintController::class, 'calculate']);
