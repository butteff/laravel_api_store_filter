<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Route::middleware(['auth:sanctum'])->group(function () {
    Route::controller(ApiController::class)->group(function () {
        Route::get('/products', 'store');
    });
//});
