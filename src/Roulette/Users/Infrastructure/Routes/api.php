<?php

use Illuminate\Support\Facades\Route;
use Src\Roulette\Users\Infrastructure\Controllers\UserFindAllController;
use Src\Roulette\Users\Infrastructure\Controllers\UserFindByUserIdController;
use Src\Roulette\Users\Infrastructure\Controllers\UserRegisterController;
use Src\Roulette\Users\Infrastructure\Controllers\UserUpdateBalanceController;

Route::middleware(['auth:sanctum', 'abilities:admin'])->group(function () {

  Route::post('/users', UserRegisterController::class);
  Route::put('/users/{id}/balance', UserUpdateBalanceController::class);
  Route::get('/users/{id}', UserFindByUserIdController::class);
  Route::get('/users', UserFindAllController::class);

});
