<?php

namespace Src\Roulette\Users\Domain;

use JsonSerializable;
use Src\Shared\Domain\Aggregate\AggregateUtilsTrait;

final class User implements JsonSerializable
{

  use AggregateUtilsTrait;

  public function __construct(
    private readonly string  $name,
    private readonly string  $email,
    private readonly ?string $password = null,
    private readonly int     $balance = 0,
    private readonly ?int    $id = null,
  )
  {
  }

  public function name(): string
  {
    return $this->name;
  }

  public function email(): string
  {
    return $this->email;
  }

  public function password(): string
  {
    return $this->password;
  }

  public function balance(): int
  {
    return $this->balance;
  }

  public function jsonSerialize(): array
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'email' => $this->email,
      'balance' => $this->balance,
    ];
  }
}
