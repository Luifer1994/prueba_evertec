<?php

use App\Http\Controllers\Clients\ClientController;
use App\Http\Controllers\DocumentTypes\DocumentTypeController;
use App\Http\Controllers\Orders\OrderController;
use App\Http\Controllers\Products\ProductController;
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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */


Route::controller(OrderController::class)->group(function () {
    Route::post('order-create', 'store');
    Route::get('order-show/{uuid}', 'show');
    Route::get('order-retry-payment/{uuid}', 'retryPayment');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('products-list', 'index');
    Route::get('products-detail/{id}', 'show');
});

Route::controller(ClientController::class)->group(function () {
    Route::get('client-by-email', 'findEmail');
    Route::get('client-get-orders', 'getOrders');
});

Route::controller(DocumentTypeController::class)->group(function () {
    Route::get('document-type-list', 'index');
});
