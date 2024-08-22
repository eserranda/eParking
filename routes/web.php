<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ParkirController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\DataParkirController;
use App\Http\Controllers\TarifParkirController;
use App\Http\Controllers\StatusPalangPintuController;

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

Route::get('login', [UserController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('login', [UserController::class, 'login'])->middleware('guest');

Route::get('logout', [UserController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('parkir.index');
})->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
})->middleware('auth');

Route::prefix('data-parkir')->controller(DataParkirController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/store', 'store');
    Route::delete('/delete/{id}', 'destroy');
});

Route::prefix('parkir')->controller(ParkirController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{no_parkir}', 'findOneKodeParkir');
    Route::put('/{no_parkir}/update', 'update');
    Route::post('/store', 'store');
    Route::post('/update-data-parkir', 'updateDataParkir');
});

Route::prefix('tarif-parkir')->controller(TarifParkirController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}/edit', 'edit');
    Route::put('/{id}/update', 'update');
    Route::post('/store', 'store');
    Route::delete('/delete/{id}', 'destroy');
});

Route::prefix('status-palang')->controller(StatusPalangPintuController::class)->group(function () {
    Route::post('/update', 'update');
});
