<?php

namespace Src\Roulette\Transactions\Domain\Contracts;


use Src\Roulette\Transactions\Domain\Transaction;

interface TransactionContract
{
  public function save(Transaction $transaction): void;

  public function getBalance(int $userId): int;
}
