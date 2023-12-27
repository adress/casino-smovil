<?php

namespace Src\Roulette\Play\Infrastructure\Repositories\Eloquent;

use App\Models\RouletteGame;
use Src\Roulette\Play\Application\DTOs\HistoryItem;
use Src\Roulette\Play\Domain\Contracts\HistoryRouletteContract;
use Src\Roulette\Play\Domain\PlayRoulette;

final class HistoryRouletteRepository implements HistoryRouletteContract
{
  public function __construct(
    private readonly RouletteGame $model,
  )
  {
  }

  public function save(int $userId, PlayRoulette $roulette): void
  {
    $data = array_merge(
      $roulette->toSnakeArray(),
      ['user_id' => $userId]
    );
    $this->model->create($data);
  }

  public function getHistory(int $userId): array
  {
    return $this->model->where('user_id', $userId)
      ->get()
      ->map(fn($item) => new HistoryItem(
        $item->bet_value,
        $item->game_time,
        $item->amount,
      ))
      ->toArray();
  }
}
