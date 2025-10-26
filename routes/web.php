<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EtherscanController;

Route::get('/etherscan', [EtherscanController::class, 'index']);
Route::post('/etherscan/check', [EtherscanController::class, 'check'])->name('etherscan.check');

