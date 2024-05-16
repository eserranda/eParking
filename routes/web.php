<?php

use App\Http\Controllers\DataParkirController;
use App\Http\Controllers\ParkirController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\TarifParkirController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
});

Route::prefix('data-parkir')->controller(DataParkirController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/store', 'store');
    Route::delete('/delete/{id}', 'destroy');
});

Route::controller(ParkirController::class)->group(function () {
    Route::get('/parkir', 'index');
});

Route::prefix('tarif-parkir')->controller(TarifParkirController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}/edit', 'edit');
    Route::put('/{id}/update', 'update');
    Route::post('/store', 'store');
    Route::delete('/delete/{id}', 'destroy');
});