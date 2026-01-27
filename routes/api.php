<?php

use App\Http\Controllers\DataRuasJalanController;
use App\Http\Controllers\JembatanController;
use Illuminate\Support\Facades\Route;

Route::get('/ruasjalan', [DataRuasJalanController::class, 'index']);
Route::get('/ruasjalan/detail/{id}', [DataRuasJalanController::class, 'ruasDetail']);
Route::get('/batas-wilayah', [DataRuasJalanController::class, 'batasWilayah']);
Route::get('/batas-kecamatan', [DataRuasJalanController::class, 'batasKecamatan']);
Route::get('/batas-kelurahan', [DataRuasJalanController::class, 'batasKelurahan']);
Route::get('/ruasjalan/search', [DataRuasJalanController::class, 'search']);
Route::get('/ruasjalan/export', [DataRuasJalanController::class, 'export']);
// Jembatan
Route::get('/jembatan/list', [JembatanController::class, 'list']);
Route::get('/jembatan/search', [JembatanController::class, 'search']);