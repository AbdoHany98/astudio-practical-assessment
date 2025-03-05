<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\AttributeController;
use App\Http\Controllers\API\AttributeValueController;




Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('attribute-values', AttributeValueController::class);
    Route::apiResource('attributes', AttributeController::class);
    Route::apiResource('attribute-values', AttributeValueController::class);
});
