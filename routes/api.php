<?php

use App\Http\Controllers\ParkirController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\StatusPalangPintuController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(PrinterController::class)->group(function () {
    Route::get('print', 'store');
});

Route::controller(StatusPalangPintuController::class)->group(function () {
    Route::get('status', 'statusPalangKeluar');
    Route::post('update-status', 'updateStatus');
});

Route::controller(ParkirController::class)->group(function () {
    Route::get('/allUsers', 'allUsers'); // test react
});
