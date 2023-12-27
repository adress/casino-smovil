<?php

namespace Src\Roulette\Transactions\Domain;

use Src\Roulette\Transactions\Domain\Contracts\TransactionContract;

class TransactionService
{
  public function __construct(
    private readonly TransactionContract $repository,
  )
  {
  }

  public function transaction($userId, $transactionType, $amount): void
  {
    $transaction = Transaction::create(
      userId: $userId,
      transactionType: $transactionType,
      amount: $amount,
      oldBalance: $this->getBalance($userId)
    );

    $this->repository->save($transaction);
  }

  public function getBalance(int $userId): int
  {
    return $this->repository->getBalance($userId);
  }
}
