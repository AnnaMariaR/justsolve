<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DebtController;

Route::middleware(['auth.basic', 'admin'])->group(function () {
    Route::get('/debts', [DebtController::class, 'index']);
    Route::get('/debts/{debt}', [DebtController::class, 'show']);
    Route::get('/debts/{debt}/suggestion', [DebtController::class, 'suggestion']);
    Route::post('/debts/{debt}/apply-action', [DebtController::class, 'applyAction']);
});
