<?php

namespace Src\Roulette\Transactions\Infrastructure\Repositories\Eloquent;

use App\Models\Transaction as TransactionModel;
use Src\Roulette\Transactions\Domain\Contracts\TransactionContract;
use Src\Roulette\Transactions\Domain\Transaction;

final class TransactionRepository implements TransactionContract
{
  public function __construct(
    private readonly TransactionModel $model,
  )
  {
  }

  public function save(Transaction $transaction): void
  {
    $data = array_merge(
      $transaction->toSnakeArray(removeKeys: ['id', 'oldBalance']),
    );
    $this->model->create($data);
  }

  public function getBalance(int $userId): int
  {
    $balance = $this->model->where('user_id', $userId)->orderBy('id', 'desc')->first();
    return $balance ? $balance->balance_after : 0;
  }
}
