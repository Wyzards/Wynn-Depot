<?php

use App\Http\Controllers\WynnItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WynnItemController::class, 'index'])->name('home');

Route::post('items/{item}', [WynnItemController::class, 'update'])->middleware('auth');

require __DIR__ . '/auth.php';
