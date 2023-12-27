<?php

use Illuminate\Support\Facades\Route;
use Src\Roulette\Play\Infrastructure\Controllers\PayRouletteController;
use Src\Roulette\Play\Infrastructure\Controllers\RouletteHistoryController;

Route::middleware(['auth:sanctum'])->group(function () {
  Route::get('colors/{color}/roulette/play', PayRouletteController::class);
  Route::get('roulette/history', RouletteHistoryController::class);
});
