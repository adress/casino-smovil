<?php

namespace Src\Management\Login\Infrastructure\Services;

use Illuminate\Support\ServiceProvider;
use Src\Management\Login\Application\Find\LoginAuthUseCase;
use Src\Management\Login\Application\Find\TokenRenewUseCase;
use Src\Management\Login\Domain\Contracts\LoginRepositoryContract;
use Src\Roulette\Users\Infrastructure\Repositories\Eloquent\UserRepository;

class DependencyServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    $this->app
      ->when([
        LoginAuthUseCase::class,
        TokenRenewUseCase::class
      ])
      ->needs(LoginRepositoryContract::class)
      ->give(UserRepository::class);
  }
}
