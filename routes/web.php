<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\SocialiteController;

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

Route::get('/auth/{provider}', [SocialiteController::class, 'redirectToProvider']);
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProvideCallback']);

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
    Route::post('/balita', [App\Http\Controllers\BalitaController::class, 'store']);

    Route::get('/users', [App\Http\Controllers\UsersController::class, 'index']);
    Route::get('/users/tambah', [App\Http\Controllers\UsersController::class, 'tambah']);
    Route::delete('/users/{id}', [App\Http\Controllers\UsersController::class, 'hapus']);
    Route::get('/users/{id}', [App\Http\Controllers\UsersController::class, 'detail']);
    Route::post('/users/edit/{id}', [App\Http\Controllers\UsersController::class, 'edit']);
    Route::post('/users', [App\Http\Controllers\UsersController::class, 'simpan']);

    Route::get('/units', [App\Http\Controllers\UnitsController::class, 'index']);

    Route::get('/roles', [App\Http\Controllers\RoleController::class, 'index']);
    Route::get('/roles/add', [App\Http\Controllers\RoleController::class, 'create']);
    Route::get('/roles/{id}', [App\Http\Controllers\RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{id}', [App\Http\Controllers\RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->name('roles.destroy');
    Route::post('/roles', [App\Http\Controllers\RoleController::class, 'store'])->name('roles.store');

    Route::get('/permissions', [App\Http\Controllers\PermissionsController::class, 'index']);
    Route::get('/permissions/add', [App\Http\Controllers\PermissionsController::class, 'create']);
    Route::get('/permissions/{id}', [App\Http\Controllers\PermissionsController::class, 'edit']);
    Route::put('/permissions/{id}', [App\Http\Controllers\PermissionsController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions/{id}', [App\Http\Controllers\PermissionsController::class, 'destroy'])->name('permissions.destroy');
    Route::post('/permissions', [App\Http\Controllers\PermissionsController::class, 'store'])->name('permissions.store');

    Route::get('/report', [App\Http\Controllers\ReportController::class, 'index'])->name('report');

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index']);
});

