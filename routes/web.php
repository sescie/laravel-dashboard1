<?php

use App\Http\Controllers\ApplianceController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::resource('/appliances', ApplianceController::class)->only(['index','create','show','destroy','edit','update', "turnOnAppliance"])->middleware(['auth', 'verified']);
Route::resource('/reports', ReportController::class)->middleware(['auth', 'verified']);
Route::resource('/dashboard', Dashboard::class)->middleware(['auth', 'verified']);




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
