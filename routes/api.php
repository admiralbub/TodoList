<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;

use App\Http\Controllers\Api\TodoListController;
Route::get('/user', function (Request $request) {
    return $request->user();
    
})->middleware('auth:sanctum');
Route::group(['prefix' => 'todolists'], function () {
    Route::get('/',[TodoListController::class, 'index'])->middleware('auth:sanctum');
    Route::post('/create',[TodoListController::class, 'create'])->middleware('auth:sanctum');
    Route::put('/update/{id}',[TodoListController::class, 'update'])->middleware(['auth:sanctum']);
    Route::delete('/delete/{id}',[TodoListController::class, 'delete'])->middleware(['auth:sanctum']);
    Route::put('/update_status/{id}',[TodoListController::class, 'update_status'])->middleware(['auth:sanctum']);

});

Route::post('/login',[LoginController::class, 'login']);

