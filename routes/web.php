<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    if (Auth::check()) {
        return redirect('/dashboard');
    }else{
        return view('welcome');
    }
});

Route::post('/login', App\Http\Controllers\LoginController::class);
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'index']);
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::post('/logout', App\Http\Controllers\Auth\LogoutController::class);

Route::middleware('auth')->group(function(){
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index']);

    Route::get('/standart/tbu-laki', [App\Http\Controllers\Standart\TBULakiController::class, 'index']);
    Route::get('/standart/tbu-perempuan', [App\Http\Controllers\Standart\TBULakiController::class, 'index']);
    Route::get('/standart/bbu-laki', [App\Http\Controllers\Standart\BBULakiController::class, 'index']);
    Route::get('/standart/bbu-perempuan', [App\Http\Controllers\Standart\BBUPerempuanController::class, 'index']);
    Route::get('/standart/pbu-laki', [App\Http\Controllers\Standart\TBULakiController::class, 'index']);
    Route::get('/standart/pbu-perempuan', [App\Http\Controllers\Standart\TBUPerempuanController::class, 'index']);

    Route::get('/balita', [App\Http\Controllers\BalitaController::class, 'index']);
    Route::get('/balita/tambah', [App\Http\Controllers\BalitaController::class, 'tambah']);
    Route::delete('/balita/{id}', [App\Http\Controllers\BalitaController::class, 'hapus']);
    Route::get('/balita/{id}', [App\Http\Controllers\BalitaController::class, 'detail']);
});

