<?php

namespace Src\Management\Login\Domain\Contracts;

interface LoginRepositoryContract
{
  public function checkUserPassword(string $email, string $password): bool;

  public function createUserToken(string $email): string;

  public function userName(string $email);

  public function checkUserTokenReturnEmail(string $token): ?string;

  public function isAdmin(string $email): bool;
}
