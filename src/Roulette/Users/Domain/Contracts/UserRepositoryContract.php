<?php

namespace Src\Roulette\Users\Domain\Contracts;

use Src\Roulette\Users\Domain\User;

interface UserRepositoryContract
{
  public function createUser(User $user): int;

  public function updateBalance($userId, $balance): bool;

  public function findAll(): array;
}
