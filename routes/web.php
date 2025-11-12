<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Redirect ke login jika belum login
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    // Redirect ke panel sesuai role
    $user = auth()->user();

    if ($user->hasRole('opd')) {
        return redirect('/opd');
    }

    if ($user->hasRole('verifikator')) {
        return redirect('/verifikator');
    }

    if ($user->hasRole('monitoring')) {
        return redirect('/monitoring');
    }

    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    // Redirect ke panel sesuai role
    $user = auth()->user();

    if ($user->hasRole('opd')) {
        return redirect('/opd');
    }

    if ($user->hasRole('verifikator')) {
        return redirect('/verifikator');
    }

    if ($user->hasRole('monitoring')) {
        return redirect('/monitoring');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';