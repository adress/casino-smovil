<?php

namespace Src\Management\Login\Application\Find;

use Src\Management\Login\Domain\Contracts\LoginRepositoryContract;
use Src\Management\Login\Domain\Exceptions\InvalidCredentialsException;
use Src\Management\Login\Domain\UserLogin;

final class LoginAuthUseCase
{
  public function __construct(
    private readonly LoginRepositoryContract $repository
  )
  {
  }

  public function __invoke(string $email, string $password): UserLogin
  {
    if (!$this->repository->checkUserPassword($email, $password)) {
      throw new InvalidCredentialsException;
    }

    $token = $this->repository->createUserToken($email);
    $name = $this->repository->userName($email);
    $isAdmin = $this->repository->isAdmin($email);

    return new UserLogin($name, $email, $token, $isAdmin);
  }
}
