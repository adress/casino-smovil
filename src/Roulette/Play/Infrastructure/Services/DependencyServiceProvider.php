<?php

namespace Src\Roulette\Play\Infrastructure\Services;

use Illuminate\Support\ServiceProvider;
use Src\Roulette\Play\Application\Find\RouletteHistoryUseCase;
use Src\Roulette\Play\Application\Save\PayRouletteUseCase;
use Src\Roulette\Play\Domain\Contracts\HistoryRouletteContract;
use Src\Roulette\Play\Infrastructure\Repositories\Eloquent\HistoryRouletteRepository;


class DependencyServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    $this->app
      ->when([PayRouletteUseCase::class, RouletteHistoryUseCase::class])
      ->needs(HistoryRouletteContract::class)
      ->give(HistoryRouletteRepository::class);
  }
}
