<?php

use App\Http\Controllers\Api\AssociateController;
use App\Http\Controllers\Api\EnrollmentController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/associado')->group(function () {
    Route::get('/', [AssociateController::class, 'index']);
    Route::get('/{uuid}', [AssociateController::class, 'show']);
    Route::get('/buscar/{document}', [AssociateController::class, 'find']);
    Route::post('/salvar', [AssociateController::class, 'store']);
    Route::put('/atualizar/{uuid}', [AssociateController::class, 'update']);
});

Route::prefix('/produto')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{uuid}', [ProductController::class, 'show']);
    Route::post('/salvar', [ProductController::class, 'store']);
    Route::put('/atualizar/{uuid}', [ProductController::class, 'update']);
    Route::delete('/delete', [ProductController::class, 'delete']);
});

Route::prefix('/inscricao')->group(function () {
    Route::post('/salvar', [EnrollmentController::class, 'store']);
    Route::post('/atualiza/status/', [EnrollmentController::class, 'update']);
});
