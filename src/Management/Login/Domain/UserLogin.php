<?php

namespace Src\Management\Login\Domain;

use JsonSerializable;

final class UserLogin implements JsonSerializable
{
  public function __construct(
    private readonly string $name,
    private readonly string $email,
    private readonly string $token,
    private readonly bool   $isAdmin = false,
  )
  {
  }

  public
  function jsonSerialize(): array
  {
    return [
      'name' => $this->name,
      'email' => $this->email,
      'token' => $this->token,
      'isAdmin' => $this->isAdmin,
    ];
  }
}
