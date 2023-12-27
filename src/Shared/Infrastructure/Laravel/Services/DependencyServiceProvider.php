<?php

namespace Src\Shared\Infrastructure\Laravel\Services;

use Illuminate\Support\ServiceProvider;
use Src\Shared\Infrastructure\Laravel\ApiExceptionsHttpStatusCodeMapping;


class DependencyServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    $this->app->singleton(ApiExceptionsHttpStatusCodeMapping::class, function ($app) {
      return new ApiExceptionsHttpStatusCodeMapping();
    });
  }
}
