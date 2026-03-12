<?php

use App\Http\Controllers\Api\V1\ClientApiController;
use App\Http\Controllers\Api\V1\InvoiceApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::apiResource('clients', ClientApiController::class);
        Route::apiResource('invoices', InvoiceApiController::class);
    });
});
