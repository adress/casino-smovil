<?php

namespace Src\Management\Login\Infrastructure\Services;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

final class RouteServiceProvider extends ServiceProvider
{
  protected $namespace = 'Src\Management\Login\Infrastructure\Controllers';

  public function map(): void
  {
    $this->mapApiRoutes();
  }

  public function mapApiRoutes(): void
  {
    Route::prefix('api')
      ->middleware('api')
      ->namespace($this->namespace)
      ->group(base_path('src/Management/Login/Infrastructure/Routes/api.php'));
  }
}
