<?php

use App\Http\Controllers\Apis\BrandController;
use App\Http\Controllers\Apis\ClientController;
use App\Http\Controllers\Apis\InvoiceController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Add Client
Route::post('add-client', [ClientController::class, 'addClient']);
Route::post('add-brand', [BrandController::class, 'createBrand']);
Route::post('add-invoice', [InvoiceController::class, 'createInvoice']);
