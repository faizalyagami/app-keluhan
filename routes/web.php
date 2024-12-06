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

Route::get('/', [\App\Http\Controllers\User\UserController::class, 'index']);

Route::get('/keluhan',  [\App\Http\Controllers\User\UserController::class, 'keluhan'])->name('keluhan');
Route::post('/keluhan/kirim',  [\App\Http\Controllers\User\UserController::class, 'storekeluhan'])->name('keluhan.store');

Route::get('/login',  [\App\Http\Controllers\User\UserController::class, 'masuk']);
Route::get('/register',  [\App\Http\Controllers\User\UserController::class, 'daftar']);
Route::get('/tentang',  [\App\Http\Controllers\User\UserController::class, 'tentang']);

Route::middleware(['guest'])->group(function () {
    // Login mahasiswa
    Route::get('/login',  [\App\Http\Controllers\User\UserController::class, 'masuk'])->name('user.masuk');
    Route::post('/login/auth', [\App\Http\Controllers\User\UserController::class, 'login'])->name('user.login');

    // Register
    Route::get('/register', [\App\Http\Controllers\User\UserController::class, 'register'])->name('user.register');
    Route::post('/getdesa', [\App\Http\Controllers\IndoRegionController::class, 'getDesa'])->name('getdesa');
    Route::post('/getkota', [\App\Http\Controllers\IndoRegionController::class, 'getkota'])->name('getkota');
    Route::post('/getkecamatan', [\App\Http\Controllers\IndoRegionController::class, 'getkecamatan'])->name('getkecamatan');
    Route::post('/getkabupaten', [\App\Http\Controllers\IndoRegionController::class, 'getkabupaten'])->name('getkabupaten');
    Route::post('/register/auth', [\App\Http\Controllers\User\UserController::class, 'register_post'])->name('user.register-post');
});

Route::middleware(['isMahasiswa'])->group(function () {
    // Logout mahasiswa
    Route::get('/logout', [\App\Http\Controllers\User\UserController::class, 'logout'])->name('user.logout');


    Route::get('/laporan/{who?}', [\App\Http\Controllers\User\UserController::class, 'laporan'])->name('keluhan.laporan');
    Route::get('/keluhan-detail/{id_keluhan}', [\App\Http\Controllers\User\UserController::class, 'detailkeluhan'])->name('keluhan.detail');
});


Route::prefix('admin')->group(function () {
    Route::middleware('isAdmin')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('/petugas', \App\Http\Controllers\Admin\PetugasController::class);
        Route::resource('/mahasiswa', \App\Http\Controllers\Admin\MahasiswaController::class);

        Route::get('/laporan', [\App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan.index');
        Route::post('/laporan-get', [\App\Http\Controllers\Admin\LaporanController::class, 'laporan'])->name('laporan.get');
        Route::post('/laporan/export', [\App\Http\Controllers\Admin\LaporanController::class, 'export'])->name('laporan.export');
    });

    Route::middleware('isPetugas')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/logout', [\App\Http\Controllers\Admin\AdminController::class, 'logout'])->name('admin.logout');

        // keluhan
        Route::get('keluhan/{status}', [\App\Http\Controllers\Admin\KeluhanController::class, 'index'])->name('keluhan.index');
        Route::get('keluhan/show/{id_keluhan}', [\App\Http\Controllers\Admin\KeluhanController::class, 'show'])->name('keluhan.show');
        Route::delete('keluhan/delete/{id_keluhan}', [\App\Http\Controllers\Admin\KeluhanController::class, 'destroy'])->name('keluhan.delete');

        // Tanggapan
        Route::post('tanggapan', [\App\Http\Controllers\Admin\TanggapanController::class, 'response'])->name('tanggapan');
    });


    Route::middleware(['isGuest'])->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'formLogin'])->name('admin.masuk');
        Route::post('/login', [\App\Http\Controllers\Admin\AdminController::class, 'login'])->name('admin.login');
    });
});



// Route::get('/admin', function () {
//     return view('pages.admin.dashboard');
// });