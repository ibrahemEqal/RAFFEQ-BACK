<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\WantedItemController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/materials', [MaterialController::class, 'index']);
Route::get('/materials/{id}', [MaterialController::class, 'show']); 
Route::get('/wanted-items', [WantedItemController::class, 'index']);
Route::post('/wanted-items/{id}/offer', [WantedItemController::class, 'offer']); 
Route::get('/services', [ServiceController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('/materials', [MaterialController::class, 'store']);
    Route::get('/my-materials', [MaterialController::class, 'myMaterials']);
    Route::put('/materials/{id}', [MaterialController::class, 'update']);
    Route::patch('/materials/{id}/sold', [MaterialController::class, 'markAsSold']);
    Route::delete('/materials/{id}', [MaterialController::class, 'destroy']);
    Route::post('/wanted-items', [WantedItemController::class, 'store']);
    
});