<?php

use Illuminate\Support\Facades\Route;
use Src\Management\Login\Infrastructure\Controllers\LoginAuthController;
use Src\Management\Login\Infrastructure\Controllers\TokenRenewController;

Route::post('/auth/login', LoginAuthController::class);
Route::get('/auth/token/renew', TokenRenewController::class);
