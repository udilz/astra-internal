<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\dataunitController;
use App\Http\Controllers\downloadController;
use App\Http\Controllers\kirimunitController;
use App\Http\Controllers\updatestatusKirimUnitController;
use App\Http\Controllers\prosesstnkController;
use App\Http\Controllers\prosespenagihanController;
use App\Http\Controllers\updatestatusesController;
use App\Http\Controllers\updatestatuspenagihanController;
use App\Http\Controllers\updatestatusStnkController;
use App\Http\Controllers\usermanagementController;
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
    return redirect('/login');
});

Route::controller(authController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSimpan')->name('register.simpan');
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAksi')->name('login.aksi');
    Route::get('logout', 'logout')
        ->middleware('auth')
        ->name('logout');
});

Route::get('downloadFile/{fileName}', [downloadController::class, 'download'])->name('download.file');

Route::middleware('auth')->group(function () {
    Route::controller(dashboardController::class)
        ->prefix('dashboard')
        ->group(function () {
            Route::get('', 'index')->name('dashboard');
        });

    Route::controller(dataunitController::class)
        ->prefix('dataunit')
        ->group(function () {
            Route::get('', 'index')->name('dataunit');
            Route::get('tambah', 'tambah')->name('dataunit.tambah');
            Route::post('tambah', 'simpan')->name('dataunit.tambah.simpan');
            Route::get('edit/{no_faktur}', 'edit')->name('dataunit.edit');
            Route::put('edit/{no_faktur}', 'update')->name('dataunit.update');
            Route::get('delete/{no_faktur}', 'delete')->name('dataunit.delete');
        });

    Route::controller(kirimunitController::class)
        ->prefix('kirimunit')
        ->group(function () {
            Route::get('', 'index')->name('kirimunit');
            Route::get('tambah', 'tambah')->name('kirimunit.tambah');
            Route::post('', 'simpan')->name('kirimunit.simpan');
            Route::post('tambah', 'simpan')->name('kirimunit.tambah.simpan');
            Route::get('edit/{no_rangka}', 'edit')->name('kirimunit.edit');
            Route::put('edit/{no_rangka}', 'update')->name('kirimunit.update');
            Route::get('delete/{no_rangka}', 'delete')->name('kirimunit.delete');
            Route::post('upload/{no_rangka}', 'upload')->name('kirimunit.upload');
            Route::post('update-dokumen/{no_rangka}', 'updateDokumen')->name('kirimunit.update.dokumen');
            Route::get('delete-status/{statusid}/{kirimunit_no_rangka}', 'deleteStatus')->name('kirimunit.delete-status');
            Route::put('updatestatustanggal', 'updatestatustanggal')->name('kirimunit.updatestatustanggal');
        });
    Route::get('kirimunit/{no_rangka}', [\App\Http\Controllers\updatestatusKirimUnitController::class, 'show']);
    Route::put('/kirimunit/save-status', [updatestatusKirimUnitController::class, 'save']);

    Route::controller(prosesstnkController::class)
        ->prefix('prosesstnk')
        ->group(function () {
            Route::get('', 'index')->name('prosesstnk');
            Route::get('tambah', 'tambah')->name('prosesstnk.tambah');
            Route::post('', 'simpan')->name('prosesstnk.simpan');
            Route::post('tambah', 'simpan')->name('prosesstnk.tambah.simpan');
            Route::get('edit/{plat_nomor}', 'edit')->name('prosesstnk.edit');
            Route::put('edit/{plat_nomor}', 'update')->name('prosesstnk.update');
            Route::get('delete/{plat_nomor}', 'delete')->name('prosesstnk.delete');
            Route::post('upload/{plat_nomor}', 'upload')->name('prosesstnk.upload');
            Route::post('update-dokumen/{plat_nomor}', 'updateDokumen')->name('prosesstnk.update.dokumen');
            Route::get('delete-status/{statusid}/{prosesstnk_plat_nomor}', 'deleteStatus')->name('prosesstnk.delete-status');
            Route::put('updatestatustanggal', 'updatestatustanggal')->name('prosesstnk.updatestatustanggal');
        });
    Route::get('prosesstnk/{plat_nomor}', [\App\Http\Controllers\updatestatusStnkController::class, 'show']);
    Route::put('/prosesstnk/save-status', [updatestatusStnkController::class, 'save']);

    Route::controller(prosespenagihanController::class)
        ->prefix('prosespenagihan')
        ->group(function () {
            Route::get('', 'index')->name('prosespenagihan');
            Route::get('tambah', 'tambah')->name('prosespenagihan.tambah');
            Route::post('tambah', 'simpan')->name('prosespenagihan.tambah.simpan');
            Route::get('edit/{no_tagihan}', 'edit')->name('prosespenagihan.edit');
            Route::put('edit/{no_tagihan}', 'update')->name('prosespenagihan.update');
            Route::get('delete/{no_tagihan}', 'delete')->name('prosespenagihan.delete');
            Route::post('upload/{no_tagihan}', 'upload')->name('prosespenagihan.upload');
            Route::post('update-dokumen/{no_tagihan}', 'updateDokumen')->name('prosespenagihan.update.dokumen');
            Route::get('delete-status/{statusid}/{prosespenagihan_no_tagihan}', 'deleteStatus')->name('prosespenagihan.delete-status');
            Route::put('updatestatustanggal', 'updatestatustanggal')->name('prosespenagihan.updatestatustanggal');
        });
    Route::get('prosespenagihan/{no_tagihan}', [\App\Http\Controllers\updatestatuspenagihanController::class, 'show']);
    Route::put('/prosespenagihan/save-status', [updatestatuspenagihanController::class, 'save']);

    Route::resource('user', usermanagementController::class);
});
