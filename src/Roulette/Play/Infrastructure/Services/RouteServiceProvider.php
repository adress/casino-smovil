<?php

namespace Src\Roulette\Play\Infrastructure\Services;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

final class RouteServiceProvider extends ServiceProvider
{
  protected $namespace = 'Src\Roulette\Play\Infrastructure\Controllers';

  public function map(): void
  {
    $this->mapApiRoutes();
  }

  public function mapApiRoutes(): void
  {
    Route::prefix('api/v1')
      ->middleware('api')
      ->namespace($this->namespace)
      ->group(base_path('src/Roulette/Play/Infrastructure/Routes/api.php'));
  }
}
