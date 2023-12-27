<?php

namespace Src\Roulette\Users\Application\Save;

use Src\Roulette\Transactions\Domain\TransactionService;
use Src\Roulette\Users\Domain\Contracts\UserRepositoryContract;

class UserUpdateBalanceUseCase
{
  public function __construct(
    private readonly TransactionService $transactionService,
  )
  {
  }

  public function __invoke($userId, $amount): void
  {
    $this->transactionService->transaction($userId, 1, $amount);
  }

}
