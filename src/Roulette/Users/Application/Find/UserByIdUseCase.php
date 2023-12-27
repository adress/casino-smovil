<?php

namespace Src\Roulette\Users\Application\Find;


use Src\Roulette\Users\Domain\Contracts\UserRepositoryContract;

class UserByIdUseCase
{
  public function __construct(
    private readonly UserRepositoryContract $repository,
  )
  {
  }

  public function __invoke(int $userId): void
  {

  }
}
