<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GameController::class, 'index'])->name('game.index');
Route::post('/game/play', [GameController::class, 'play'])->name('game.play');

Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
