<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CampusController;
use App\Http\Controllers\Campus\CampusSetupController;


Route::get('/campus/setup', [CampusSetupController::class, 'create'])->name('auth.campus.create');
Route::post('/campus/setup', [CampusSetupController::class, 'store'])->name('auth.campus.store');

Route::resource('/campuses', CampusController::class);
