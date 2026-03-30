<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VerklaringController;
use App\Http\Controllers\WizardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('verklaringen.index');
});

Route::get('/dashboard', function () {
    return redirect()->route('verklaringen.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/verklaringen', [VerklaringController::class, 'index'])->name('verklaringen.index');
    Route::get('/verklaringen/alle', [VerklaringController::class, 'all'])->name('verklaringen.all');
    Route::get('/verklaringen/{verklaring}/edit', [VerklaringController::class, 'edit'])->name('verklaringen.edit');
    Route::put('/verklaringen/{verklaring}', [VerklaringController::class, 'update'])->name('verklaringen.update');
    Route::get('/verklaringen/{verklaring}/download', [VerklaringController::class, 'download'])->name('verklaringen.download');
    Route::delete('/verklaringen/{verklaring}', [VerklaringController::class, 'destroy'])->name('verklaringen.destroy');

    Route::get('/wizard', [WizardController::class, 'step1'])->name('wizard.step1');
    Route::post('/wizard/stap1', [WizardController::class, 'step1Store'])->name('wizard.step1.store');
    Route::get('/wizard/stap2', [WizardController::class, 'step2'])->name('wizard.step2');
    Route::post('/wizard/stap2', [WizardController::class, 'step2Store'])->name('wizard.step2.store');
    Route::get('/wizard/store', [WizardController::class, 'store'])->name('wizard.store');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [AdminController::class, 'index'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');
});

require __DIR__ . '/auth.php';
