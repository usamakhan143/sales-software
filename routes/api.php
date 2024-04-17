<?php

use App\Http\Controllers\Apis\BrandController;
use App\Http\Controllers\Apis\ClientController;
use App\Http\Controllers\Apis\EmailController;
use App\Http\Controllers\Apis\InvoiceController;
use App\Http\Controllers\Apis\PdfController;
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

// Client Controller
Route::post('add-client', [ClientController::class, 'addClient']);

// Brand Controller
Route::post('add-brand', [BrandController::class, 'createBrand']);

// Invoice Controller
Route::post('add-invoice', [InvoiceController::class, 'createInvoice']);

// PDF Controller
Route::get('generate-pdf/{id}', [PdfController::class, 'generatePDF']);

// Email Controller
Route::post('send-invoice', [EmailController::class, 'sendInvoiceToCustomer']);
