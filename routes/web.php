<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookLoanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OverdueReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'public.home')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::middleware(['auth', 'active.user'])->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('can:manage-library')->group(function () {
        Route::resource('genres', GenreController::class)->except(['show']);
        Route::resource('books', BookController::class);
        Route::resource('members', MemberController::class);
        Route::resource('loans', BookLoanController::class)->only(['index', 'create', 'store', 'destroy']);
        Route::patch('loans/{loan}/return', [BookLoanController::class, 'returnBook'])->name('loans.return');
        Route::patch('loans/{loan}/settle-fine', [BookLoanController::class, 'settleFine'])->name('loans.settle-fine');
        Route::get('reports/overdue', [OverdueReportController::class, 'index'])->name('reports.overdue');
        Route::get('reports/overdue/export', [OverdueReportController::class, 'export'])->name('reports.overdue.export');
    });

    Route::middleware('can:manage-users')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });

    Route::get('activity-logs', [ActivityLogController::class, 'index'])->middleware('can:manage-users')->name('activity.index');
});
