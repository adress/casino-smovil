<?php

namespace Src\Roulette\Play\Application\DTOs;

use JsonSerializable;
use Src\Shared\Domain\Aggregate\AggregateUtilsTrait;

class History implements JsonSerializable
{
  use AggregateUtilsTrait;

  public function __construct(
    private readonly int   $balance,
    private readonly array $items,
  )
  {
  }

  public function balance(): int
  {
    return $this->balance;
  }

  public function items(): array
  {
    return $this->items;
  }
}
