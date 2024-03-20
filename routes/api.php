<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BenefitController;
use App\Http\Controllers\BenefitsDeliveredController;
use App\Http\Controllers\MaximumAmountController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('auth', [AuthController::class, 'auth']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('logout', [AuthController::class, 'logout']);

    Route::get('users', [UserController::class, 'index']);

    Route::apiResource('benefits', BenefitController::class)->except([
        'create', 'edit'
    ]);

    Route::apiResource('benefits-delivered', BenefitsDeliveredController::class)->except([
        'create', 'edit'
    ]);

    Route::apiResource('max_amounts', MaximumAmountController::class)->except([
        'create', 'edit'
    ]);

    Route::apiResource('records', RecordController::class)->except([
        'create', 'edit'
    ]);

    Route::get('/misbeneficios/{rut}', [BenefitsDeliveredController::class, 'myBenefits']);
});