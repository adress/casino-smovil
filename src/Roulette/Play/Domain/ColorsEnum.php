<?php

namespace Src\Roulette\Play\Domain;

use InvalidArgumentException;

enum ColorsEnum: string
{
  case RED = 'rojo';
  case BLACK = 'negro';
  case GREEN = 'verde';


  public static function fromValue(string $value): self
  {
    foreach (self::cases() as $case) {
      if ($case->value === $value) {
        return $case;
      }
    }
    throw new InvalidArgumentException("Invalid value {$value} for Color");
  }
}
