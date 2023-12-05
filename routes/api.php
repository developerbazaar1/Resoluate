<?php

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
// vendor
Route::post('/user/edit-contract/{type}/{id}', [App\Http\Controllers\ContractEditController::class, 'edit_contract'])->name('user-api-edit-contract');
Route::get('/user/test/create_vendor', [App\Http\Controllers\ContractEditController::class, 'create_vendor'])->name('user-api-create-vendor');


// Route::get('/pdf-file', 'PdfController@show');
Route::get('/pdf-file/{type}/{id}', [App\Http\Controllers\PdfController::class, 'show']);
// Route::get('/pdf-file', [App\Http\Controllers\PdfController::class, 'show']);