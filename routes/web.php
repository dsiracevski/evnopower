<?php

use App\Http\Controllers\LocationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OutageController;
use App\Http\Livewire\LiveTable;
use Illuminate\Support\Facades\Route;

Route::get('/sync-locations', [LocationController::class, 'syncLocations'])->name('location.sync-locations');
Route::get('/notifications', [NotificationController::class, 'chooseLocations'])->name('notification.choose-locations');
Route::post('/notifications', [NotificationController::class, 'setLocations'])->name('notification.set-locations');
Route::get('/get', [OutageController::class, 'importFile'])->name('outage.import-file');
Route::get('/', [OutageController::class, 'index'])->name('outage.index');
Route::get('/li', [LiveTable::class, 'render'])->name('live-table.index.index');

require __DIR__.'/auth.php';
