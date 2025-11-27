<?php

use App\Http\Controllers\Api\AdminRequestController;
use App\Http\Controllers\Api\MailboxController;
use App\Http\Controllers\Api\MailboxRequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// User API Routes
Route::middleware('auth:web')->group(function () {
    Route::post('/request-mailbox', [MailboxRequestController::class, 'store']);
    Route::get('/requests', [MailboxRequestController::class, 'index']);
    Route::get('/mailboxes', [MailboxController::class, 'index']);
    Route::get('/mailboxes/{id}', [MailboxController::class, 'show']);
});

// Admin API Routes
Route::middleware('auth:admin')->prefix('admin')->group(function () {
    Route::get('/requests', [AdminRequestController::class, 'index']);
    Route::post('/requests/{id}/approve', [AdminRequestController::class, 'approve']);
    Route::post('/requests/{id}/reject', [AdminRequestController::class, 'reject']);
});
