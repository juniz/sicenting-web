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
    } else {
        return view('welcome');
    }
});

Route::get('/auth/{provider}', [SocialiteController::class, 'redirectToProvider']);
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProvideCallback']);

Route::post('/login', App\Http\Controllers\LoginController::class);
// Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'index']);
// Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::post('/logout', App\Http\Controllers\Auth\LogoutController::class);

Route::get('/reload-captcha', [\App\Http\Controllers\Auth\RegisterController::class, 'reloadCaptcha']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index']);
    Route::get('/dashboard/kec/{id}', [App\Http\Controllers\DashboardKecController::class, 'index']);
    Route::get('/dashboard/kel/{id}', [App\Http\Controllers\DashboardKelController::class, 'index']);

    Route::get('/dashboard-stunting-kec/{id}', [App\Http\Controllers\DashboardKecController::class, 'stuntingPerKab']);
    Route::get('/dashboard-gizi-kec/{id}', [App\Http\Controllers\DashboardKecController::class, 'giziPerKab']);
    Route::get('/dashboard-badan-kec/{id}', [App\Http\Controllers\DashboardKecController::class, 'badanPerKab']);

    Route::get('/dashboard-stunting-kel/{id}', [App\Http\Controllers\DashboardKelController::class, 'stuntingPerKab']);
    Route::get('/dashboard-gizi-kel/{id}', [App\Http\Controllers\DashboardKelController::class, 'giziPerKab']);
    Route::get('/dashboard-badan-kel/{id}', [App\Http\Controllers\DashboardKelController::class, 'badanPerKab']);

    Route::get('/dashboard-perkembangan', [App\Http\Controllers\DashboardPerkembangan::class, 'index']);
    Route::get('/dashboard-balita-user', [App\Http\Controllers\DashboardController::class, 'getJmkBalitaPerUser']);
    Route::get('/dashboard-user', [App\Http\Controllers\DashboardPerkembangan::class, 'getUserJns']);
    Route::get('/dashboard-perkembangan-stunting', [App\Http\Controllers\DashboardPerkembangan::class, 'grafikPerkembangan']);
    Route::get('/dashboard-jenis-user', [App\Http\Controllers\DashboardPerkembangan::class, 'getJenisUser']);
    Route::get('/dashboard-stunting-kab', [App\Http\Controllers\DashboardController::class, 'stuntingPerKab']);
    Route::get('/dashboard-gizi-kab', [App\Http\Controllers\DashboardController::class, 'giziPerKab']);
    Route::get('/dashboard-badan-kab', [App\Http\Controllers\DashboardController::class, 'badanPerKab']);

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
    Route::get('/users-password/{id}', [App\Http\Controllers\UsersController::class, 'password']);
    Route::post('/users-password/{id}', [App\Http\Controllers\UsersController::class, 'ubahPassword']);

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

    Route::get('/team', [App\Http\Controllers\TeamController::class, 'index']);

    Route::post('/import-balita', [App\Http\Controllers\BalitaController::class, 'import']);

    Route::get('/giat', [App\Http\Controllers\KegiatanController::class, 'index']);
    Route::get('/giat/cetak', [App\Http\Controllers\KegiatanController::class, 'cetak']);

    Route::get('/balita-stunting', function () {
        return view('dashboard.stunting');
    });

    Route::get('/balita-konsul', function () {
        return view('balita.konsul');
    });
});
