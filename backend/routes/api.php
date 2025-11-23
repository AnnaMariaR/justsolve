<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DebtApiController;

Route::middleware(['auth.basic', 'admin'])->group(function () {
    Route::get('/debts', [DebtApiController::class, 'listAll']);
    Route::get('/debts/{debt}', [DebtApiController::class, 'view']);
    Route::get('/debts/{debt}/suggestion', [DebtApiController::class, 'showSuggestion']);
    Route::post('/debts/{debt}/apply-action', [DebtApiController::class, 'applyAction']);
});
