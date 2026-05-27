<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ─── Público ─────────────────────────────────────────────────────
Route::get('/', fn() => redirect()->route('dashboard'));

// ─── Auth (Breeze) ────────────────────────────────────────────────
require __DIR__.'/auth.php';

// ─── Área autenticada ─────────────────────────────────────────────
Route::middleware(['auth', 'verified', 'active'])->group(function () {

    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ─── Artigos ─────────────────────────────────────────────────
    Route::resource('articles', \App\Http\Controllers\ArticleController::class);

    // ─── Admin ───────────────────────────────────────────────────
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users',  \App\Http\Controllers\Admin\UserController::class);
        Route::resource('groups', \App\Http\Controllers\Admin\GroupController::class);
        Route::resource('tags',   \App\Http\Controllers\Admin\TagController::class);
        Route::get('smtp',        [\App\Http\Controllers\Admin\SmtpController::class, 'edit'])->name('smtp.edit');
        Route::post('smtp',       [\App\Http\Controllers\Admin\SmtpController::class, 'update'])->name('smtp.update');
        Route::post('smtp/test',  [\App\Http\Controllers\Admin\SmtpController::class, 'test'])->name('smtp.test');
    });
});
