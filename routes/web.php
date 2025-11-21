<?php

use App\Http\Controllers\MutasiController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PendudukController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/mutasi', MutasiController::class);
Route::resource('/penduduk', PendudukController::class);

// Family-based routes for Penduduk
Route::prefix('penduduk')->name('penduduk.')->group(function () {
    Route::get('family/{kartuKeluargaId}', [PendudukController::class, 'familyShow'])->name('family.show');
    Route::get('family/{kartuKeluargaId}/edit', [PendudukController::class, 'familyEdit'])->name('family.edit');
    Route::put('family/{kartuKeluargaId}', [PendudukController::class, 'familyUpdate'])->name('family.update');
    Route::delete('family/{kartuKeluargaId}', [PendudukController::class, 'familyDestroy'])->name('family.destroy');
});