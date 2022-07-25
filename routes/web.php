<?php

use App\Http\Controllers\OutageController;
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


Route::get('/get', [OutageController::class, 'importFile'])->name('outage.import-file');
Route::get('/', [OutageController::class, 'index'])->name('outage.index');
