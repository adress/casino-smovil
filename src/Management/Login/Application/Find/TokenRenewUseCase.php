<?php

namespace Src\Management\Login\Application\Find;

use Src\Management\Login\Domain\Contracts\LoginRepositoryContract;
use Src\Management\Login\Domain\Exceptions\InvalidCredentialsException;
use Src\Management\Login\Domain\UserLogin;

final class TokenRenewUseCase
{
  public function __construct(
    private readonly LoginRepositoryContract $repository
  )
  {
  }

  public function __invoke(string $token): UserLogin
  {
    if ($token == null) throw new InvalidCredentialsException;
    $email = $this->repository->checkUserTokenReturnEmail($token);
    if ($email == null) throw new InvalidCredentialsException;
    $newToken = $this->repository->createUserToken($email);
    $name = $this->repository->userName($email);
    $isAdmin = $this->repository->isAdmin($email);

    return new UserLogin($name, $email, $newToken, $isAdmin);
  }
}
