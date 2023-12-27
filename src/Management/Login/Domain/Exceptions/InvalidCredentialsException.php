<?php

namespace Src\Management\Login\Domain\Exceptions;

use RuntimeException;

final class InvalidCredentialsException extends RuntimeException
{

  public function __construct()
  {
    parent::__construct('Invalid credentials');
  }
}
