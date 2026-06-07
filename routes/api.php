<?php

use App\Http\Controllers\Api\CronController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BookController;
use App\Http\Controllers\Api\V1\LoanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — /api/v1/
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->name('api.v1.')->group(function () {

    // Auth (public)
    Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/auth/login',    [AuthController::class, 'login'])->name('auth.login');

    // Auth (protected)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::get('/me',           [AuthController::class, 'me'])->name('me');
    });

    // Books (public)
    Route::get('/books',      [BookController::class, 'index'])->name('books.index');
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

    // Loans (protected)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/loans',                   [LoanController::class, 'index'])->name('loans.index');
        Route::post('/loans',                  [LoanController::class, 'store'])->name('loans.store');
        Route::patch('/loans/{loan}/return',   [LoanController::class, 'return'])->name('loans.return');
    });
});

/*
|--------------------------------------------------------------------------
| Cron Endpoint (called by Vercel cron)
|--------------------------------------------------------------------------
*/
Route::get('/cron/update-overdue', [CronController::class, 'updateOverdue'])->name('cron.update-overdue');
