<?php

namespace Src\Roulette\Transactions\Domain;

use JsonSerializable;
use Src\Shared\Domain\Aggregate\AggregateUtilsTrait;

final class Transaction implements JsonSerializable
{

  use AggregateUtilsTrait;

  public function __construct(
    private readonly ?int    $id,
    private readonly int     $userId,
    private readonly int     $transactionType,
    private readonly int     $amount,
    private readonly string  $transactionTime,
    private readonly int     $oldBalance,
    private int              $balanceAfter = 0,
    private readonly ?string $description = null,
  )
  {
  }

  public function id(): ?int
  {
    return $this->id;
  }

  public function userId(): int
  {
    return $this->userId;
  }

  public function transactionType(): int
  {
    return $this->transactionType;
  }

  public function amount(): int
  {
    return $this->amount;
  }

  public function balanceAfter(): int
  {
    return $this->balanceAfter;
  }

  public function transactionTime(): string
  {
    return $this->transactionTime;
  }

  public function description(): ?string
  {
    return $this->description;
  }

  public static function create(
    int $userId,
    int $transactionType,
    int $amount,
    int $oldBalance,
  ): Transaction
  {
    $transactionTime = date('Y-m-d H:i:s');
    $transaction = new self(null, $userId, $transactionType, $amount, $transactionTime, $oldBalance);
    $transaction->calculateBalanceAfter();
    return $transaction;
  }

  public
  function calculateBalanceAfter(): void
  {
    $this->balanceAfter = $this->oldBalance + $this->amount;
  }

}
