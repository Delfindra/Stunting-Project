<?php

use App\Http\Controllers\cekStatusController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerPage;
use App\Http\Controllers\sebaranController;
use App\Http\Controllers\tambahDataController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\ujiCobaController;

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

// Kelompok route dengan middleware 'auth' dan 'prevent-back-history'
Route::group(['middleware' => ['auth', 'prevent-back-history']], function () {
    Route::get('/', [ControllerPage::class, 'index'])->name('index');
    Route::get('/lihatData', [ControllerPage::class, 'lihatData'])->name('page.lihatData');
    
    // Route sebaran status gizi
    Route::get('/sebaranStatusGizi', [SebaranController::class, 'index']);
    Route::get('/sebaran/status-gizi', [SebaranController::class, 'getStatusGizi'])->name('sebaran.status.gizi');
    Route::get('/api/sebaran-data', [SebaranController::class, 'getSebaranData']);

    // Route tambah data
    Route::resource('tambahData', tambahDataController::class);
    Route::post('/tambahData', [tambahDataController::class, 'store'])->name('tambahData.store');
    Route::get('/tambahData/{id}', [tambahDataController::class, 'show'])->name('dataAnak.show');
    Route::put('/tambahData/{id}', [tambahDataController::class, 'update'])->name('dataAnak.update');
    Route::delete('/tambahData/{id}', [tambahDataController::class, 'destroy'])->name('dataAnak.destroy');
    Route::get('/lihatData', [ControllerPage::class, 'lihatData'])->name('page.lihatData');

    // Route cek status
    Route::resource('cekStatus', cekStatusController::class);
    Route::post('/storeGizi/{id}', [cekStatusController::class, 'store'])->name('storeGizi');
});

// Route login
Route::get('/login', [ControllerPage::class, 'login'])->name('login');
Route::post('/login', [loginController::class, 'authenticate'])->name('login.authenticate');

// Route untuk proses register
// Route::post('/register', [loginController::class, 'register'])->name('register');

// Route logout
Route::post('/logout', [loginController::class, 'logout'])->name('logout');


