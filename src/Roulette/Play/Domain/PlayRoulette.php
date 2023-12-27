<?php

namespace Src\Roulette\Play\Domain;

use JsonSerializable;
use Src\Roulette\Play\Domain\Exceptions\WithoutSufficientBalance;
use Src\Shared\Domain\Aggregate\AggregateUtilsTrait;

final class PlayRoulette implements JsonSerializable
{

  use AggregateUtilsTrait;

  public function __construct(
    private readonly string $betColor,
    private int             $balance,
    private readonly string $gameTime,
    private int             $amount = 0,
    private int             $betValue = 0,
    private bool            $isWinner = false,
    private ?string         $winColor = null,
  )
  {
  }

  public function betColor(): string
  {
    return $this->betColor;
  }

  public function balance(): int
  {
    return $this->balance;
  }

  public function gameTime(): string
  {
    return $this->gameTime;
  }

  public function amount(): int
  {
    return $this->amount;
  }

  public function winColor(): string
  {
    return $this->winColor;
  }

  public function betValue(): int
  {
    return $this->betValue;
  }

  public function isWinner(): bool
  {
    return $this->isWinner;
  }

  public static function create(string $betColor, $balance): PlayRoulette
  {
    $data['betColor'] = $betColor;
    $data['balance'] = $balance;
    $data['gameTime'] = date('Y-m-d H:i:s');
    $roulette = new self(...$data);

    if ($roulette->balance <= 0) throw new WithoutSufficientBalance();
    $roulette->balance < 1000 ? $roulette->allIn() : $roulette->calculatePercentage();

    $roulette->calculateWin();
    $roulette->updateBalance();

    return $roulette;
  }

  public function allIn(): void
  {
    $this->betValue = $this->balance;
  }

  public function calculatePercentage(): void
  {
    $percentage = rand(8, 15);
    $this->betValue = ($this->balance * $percentage) / 100;
  }

  public function calculateWin(): void
  {
    $randomNumber = rand(1, 100);
    if ($randomNumber <= 2) {
      $this->winColor = 'verde';
    } elseif ($randomNumber <= 51) {
      $this->winColor = 'rojo';
    } else {
      $this->winColor = 'negro';
    }
  }

//
  public function updateBalance(): void
  {
    if ($this->betColor === $this->winColor) {
      $this->isWinner = true;
      if ($this->betColor === 'verde') {
        $this->amount = $this->betValue * 15;
      } else {
        $this->amount = $this->betValue * 2;
      }
    } else {
      $this->amount = -$this->betValue;
    }
    $this->balance += $this->amount;
  }
}
