<?php

namespace Src\Roulette\Users\Application\Save;

use Src\Roulette\Transactions\Domain\Transaction;
use Src\Roulette\Transactions\Domain\TransactionService;
use Src\Roulette\Users\Domain\Contracts\UserRepositoryContract;
use Src\Roulette\Users\Domain\User;

class UserRegisterUseCase
{
  public function __construct(
    private readonly UserRepositoryContract $repository,
    private readonly TransactionService     $transactionService,
  )
  {
  }

  public function __invoke(string $name, string $email, string $password): void
  {
    $user = new User($name, $email, $password);
    $id = $this->repository->createUser($user);
    $this->transactionService->transaction($id, 1, 10000);
  }
}
