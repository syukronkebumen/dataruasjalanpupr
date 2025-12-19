<?php

use App\Http\Controllers\DataRuasJalanController;
use Illuminate\Support\Facades\Route;

Route::get('/ruasjalan', [DataRuasJalanController::class, 'index']);