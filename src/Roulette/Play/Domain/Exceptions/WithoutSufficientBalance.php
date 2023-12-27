<?php

namespace Src\Roulette\Play\Domain\Exceptions;


use RuntimeException;

class WithoutSufficientBalance extends RuntimeException
{
  public function __construct()
  {
    parent::__construct("No tienes suficiente saldo para jugar");
  }
}
