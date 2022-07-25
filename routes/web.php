<?php

use App\Http\Controllers\OutageController;
use Illuminate\Support\Facades\Route;


Route::get('/get', [OutageController::class, 'importFile'])->name('outage.import-file');
Route::get('/', [OutageController::class, 'index'])->name('outage.index');
