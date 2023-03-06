<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('lottery');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/{id}', [App\Http\Controllers\LotteryController::class, 'index'])->name('lotterySelect');
Route::post('lottery/create', [App\Http\Controllers\LotteryController::class, 'create'])->name('lotteryRegister');
Route::get('lottery/consultar_registro/{id}', [App\Http\Controllers\LotteryController::class, 'datos'])->name('lotteryDatos');
Route::get('lottery/datos/{id}', [App\Http\Controllers\LotteryController::class, 'consultar_registro'])->name('lotteryGetData');
Route::get('/lottery/competitor/all', [App\Http\Controllers\LotteryController::class, 'all'])->name('lottery.all');
Route::get('/lottery/competitor/allData', [App\Http\Controllers\LotteryController::class, 'allData'])->name('lottery.allData');
Route::get('/lottery/competitor/updateData', [App\Http\Controllers\LotteryController::class, 'updateData'])->name('lottery.updateData');

Route::get('event/admin', [App\Http\Controllers\EventController::class, 'index'])->name('EventAdmin');
Route::get('event/create', [App\Http\Controllers\EventController::class, 'create'])->name('EventRegister');
Route::post('event/add', [App\Http\Controllers\EventController::class, 'store'])->name('EventAdd');
Route::get('event/list', [App\Http\Controllers\EventController::class, 'list'])->name('EventList');