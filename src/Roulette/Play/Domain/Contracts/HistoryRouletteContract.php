<?php

namespace Src\Roulette\Play\Domain\Contracts;


use Src\Roulette\Play\Domain\PlayRoulette;

interface HistoryRouletteContract
{
  public function save(int $userId, PlayRoulette $roulette): void;

  public function getHistory(int $userId): array;
}
