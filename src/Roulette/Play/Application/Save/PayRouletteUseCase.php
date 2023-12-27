<?php

namespace Src\Roulette\Play\Application\Save;

use Src\Roulette\Play\Domain\ColorsEnum;
use Src\Roulette\Play\Domain\Contracts\HistoryRouletteContract;
use Src\Roulette\Play\Domain\PlayRoulette;
use Src\Roulette\Transactions\Domain\TransactionService;

class PayRouletteUseCase
{
  public function __construct(
    private readonly HistoryRouletteContract $historyRepository,
    private readonly TransactionService      $transactionSaveService,
  )
  {
  }

  public function __invoke(int $userId, string $color): PlayRoulette
  {
    ColorsEnum::fromValue($color);
    $oldBalance = $this->transactionSaveService->getBalance($userId);
    $roulette = PlayRoulette::create($color, $oldBalance);
    $this->historyRepository->save($userId, $roulette);

    $this->transactionSaveService->transaction(
      userId: $userId,
      transactionType: 2,
      amount: $roulette->amount(),
    );
    return $roulette;
  }
}
