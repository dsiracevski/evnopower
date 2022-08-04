<?php

use App\Http\Controllers\LocationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OutageController;
use App\Jobs\SendPlannedOutagesMail;
use Illuminate\Support\Facades\Route;

Route::get('/sync-locations', [LocationController::class, 'syncLocations'])->name('location.sync-locations');
Route::get('/notifications', [NotificationController::class, 'chooseLocations'])->name('notification.choose-locations');
Route::post('/notifications', [NotificationController::class, 'setLocations'])->name('notification.set-locations');
Route::get('/get', [OutageController::class, 'importFile'])->name('outage.import-file');
Route::get('/', [OutageController::class, 'index'])->name('outage.index');

require __DIR__.'/auth.php';
