<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\MemberAuthController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Member\BookController as MemberBookController;
use App\Http\Controllers\Member\LoanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public / Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('member.books.index');
});

// Member Auth
Route::middleware('guest')->group(function () {
    Route::get('/login',    [MemberAuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [MemberAuthController::class, 'login'])->name('login.post');
    Route::get('/register', [MemberAuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[MemberAuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [MemberAuthController::class, 'logout'])
    ->middleware('auth:web')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Member Routes (auth:web)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:web')->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [LoanController::class, 'dashboard'])->name('dashboard');
    Route::get('/loans',     [LoanController::class, 'index'])->name('loans.index');
    Route::post('/loans',    [LoanController::class, 'store'])->name('loans.store');
    Route::patch('/loans/{loan}/return', [LoanController::class, 'return'])->name('loans.return');
});

// Books accessible without login (search/browse), borrow requires auth
Route::prefix('books')->name('member.books.')->group(function () {
    Route::get('/',     [MemberBookController::class, 'index'])->name('index');
    Route::get('/{book}', [MemberBookController::class, 'show'])->name('show');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Auth (guest to admin)
    Route::get('/login',  [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout',[AdminAuthController::class, 'logout'])->name('logout');

    // Protected admin routes
    Route::middleware(\App\Http\Middleware\AdminAuth::class)->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Books CRUD
        Route::resource('books', AdminBookController::class);

        // Members
        Route::get('/members',             [AdminMemberController::class, 'index'])->name('members.index');
        Route::get('/members/{member}',    [AdminMemberController::class, 'show'])->name('members.show');
        Route::delete('/members/{member}', [AdminMemberController::class, 'destroy'])->name('members.destroy');
        Route::post('/members/{member}/force-delete', [AdminMemberController::class, 'forceDelete'])->name('members.force-delete');
    });
});
