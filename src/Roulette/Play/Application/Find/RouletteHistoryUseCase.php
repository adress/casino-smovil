<?php

namespace Src\Roulette\Play\Application\Find;


use Src\Roulette\Play\Application\DTOs\History;
use Src\Roulette\Play\Domain\Contracts\HistoryRouletteContract;
use Src\Roulette\Transactions\Domain\TransactionService;

class RouletteHistoryUseCase
{
  public function __construct(
    private readonly HistoryRouletteContract $historyRepository,
    private readonly TransactionService      $transactionService,
  )
  {
  }

  public function __invoke(int $userId): History
  {
    $items = $this->historyRepository->getHistory($userId);
    $balance = $this->transactionService->getBalance($userId);
    return new History(
      balance: $balance,
      items: $items
    );
  }

}
