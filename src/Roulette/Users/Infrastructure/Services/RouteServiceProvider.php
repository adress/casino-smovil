<?php

namespace Src\Roulette\Users\Infrastructure\Services;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

final class RouteServiceProvider extends ServiceProvider
{
  protected $namespace = 'Src\Roulette\Users\Infrastructure\Controllers';

  public function map(): void
  {
    $this->mapApiRoutes();
  }

  public function mapApiRoutes(): void
  {
    Route::prefix('api/v1')
      ->middleware('api')
      ->namespace($this->namespace)
      ->group(base_path('src/Roulette/Users/Infrastructure/Routes/api.php'));
  }
}
