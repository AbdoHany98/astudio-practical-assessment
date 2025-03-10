<?php

use App\Http\Controllers\Api\TimesheetController;
use App\Http\Middleware\AdminCheck;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\AttributeController;
use App\Http\Controllers\API\AttributeValueController;




Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('attribute-values', AttributeValueController::class);
    Route::apiResource('attributes', AttributeController::class)->except(['store', 'update', 'destroy']);
    Route::apiResource('timesheets', TimesheetController::class);
    Route::apiResource('projects', ProjectController::class)->except(['store', 'update', 'destroy']);
       
    Route::middleware(AdminCheck::class)->group(function () {
        Route::post('/projects', [ProjectController::class, 'store']);
        Route::put('/projects/{project}', [ProjectController::class, 'update']);
        Route::delete('/projects/{project}', [ProjectController::class, 'destroy']);
        Route::post('/attributes', [AttributeController::class, 'store']);
        Route::put('/attributes/{attribute}', [AttributeController::class, 'update']);
        Route::delete('/attributes/{attribute}', [AttributeController::class, 'destroy']);
    });
});
