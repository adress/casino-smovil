<?php

namespace Src\Roulette\Transactions\Infrastructure\Services;

use Illuminate\Support\ServiceProvider;
use Src\Roulette\Transactions\Domain\TransactionService;
use Src\Roulette\Transactions\Infrastructure\Repositories\Eloquent\TransactionRepository;
use Src\Roulette\Transactions\Domain\Contracts\TransactionContract;


class DependencyServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    $this->app
      ->when([TransactionService::class])
      ->needs(TransactionContract::class)
      ->give(TransactionRepository::class);
  }
}
