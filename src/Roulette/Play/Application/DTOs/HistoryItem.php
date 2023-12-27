<?php

namespace Src\Roulette\Play\Application\DTOs;

use JsonSerializable;
use Src\Shared\Domain\Aggregate\AggregateUtilsTrait;

class HistoryItem implements JsonSerializable
{
  use AggregateUtilsTrait;

  public function __construct(
    private readonly int    $betValue,
    private readonly string $gameTime,
    private readonly int    $amount,
  )
  {
  }

  public function betValue(): int
  {
    return $this->betValue;
  }

  public function gameTime(): string
  {
    return $this->gameTime;
  }

  public function amount(): int
  {
    return $this->amount;
  }
}
