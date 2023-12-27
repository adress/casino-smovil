<?php

namespace Src\Roulette\Users\Infrastructure\Services;

use Illuminate\Support\ServiceProvider;
use Src\Roulette\Transaction\Application\Save\TransactionFindByIdUseCase;
use Src\Roulette\Transactions\Domain\TransactionService;
use Src\Roulette\Transactions\Infrastructure\Repositories\Eloquent\TransactionRepository;
use Src\Roulette\Users\Application\Find\UserByIdUseCase;
use Src\Roulette\Users\Application\Find\UserFindAllUseCase;
use Src\Roulette\Users\Application\Save\UserRegisterUseCase;
use Src\Roulette\Users\Application\Save\UserUpdateBalanceUseCase;
use Src\Roulette\Users\Domain\Contracts\TransactionContract;
use Src\Roulette\Users\Domain\Contracts\UserRepositoryContract;
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
        UserByIdUseCase::class,
        UserFindAllUseCase::class,
        UserRegisterUseCase::class,
        UserUpdateBalanceUseCase::class
      ])
      ->needs(UserRepositoryContract::class)
      ->give(UserRepository::class);
  }
}
