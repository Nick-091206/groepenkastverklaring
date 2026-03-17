<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WizardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('wizard.step1');
});

Route::get('/dashboard', function () {
    return redirect()->route('wizard.step1');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Groepenkast verklaring wizard
    Route::get('/wizard',          [WizardController::class, 'step1'])->name('wizard.step1');
    Route::post('/wizard/stap1',   [WizardController::class, 'step1Store'])->name('wizard.step1.store');
    Route::get('/wizard/stap2',    [WizardController::class, 'step2'])->name('wizard.step2');
    Route::post('/wizard/stap2',   [WizardController::class, 'step2Store'])->name('wizard.step2.store');
    Route::get('/wizard/pdf',      [WizardController::class, 'generatePdf'])->name('wizard.pdf');
});

require __DIR__.'/auth.php';
