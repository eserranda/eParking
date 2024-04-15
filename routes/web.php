<?php

use App\Http\Controllers\DataParkirController;
use App\Http\Controllers\ParkirController;
use App\Http\Controllers\PrinterController;
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

Route::controller(DataParkirController::class)->group(function () {
    Route::get('/data-parkir', 'index');
});

Route::controller(ParkirController::class)->group(function () {
    Route::get('/parkir', 'index');
});

Route::controller(PrinterController::class)->group(function () {
    Route::get('print/{text}', 'printToPrinter');
});
