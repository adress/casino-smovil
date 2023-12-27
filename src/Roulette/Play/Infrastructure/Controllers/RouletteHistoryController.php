<?php

declare(strict_types=1);

namespace Src\Roulette\Play\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;

use Src\Roulette\Play\Application\Find\RouletteHistoryUseCase;
use Src\Shared\Infrastructure\Laravel\ApiExceptionsHttpStatusCodeMapping;
use Src\Shared\Infrastructure\Laravel\SimpleApiController;

final class RouletteHistoryController extends SimpleApiController
{
  public function __construct(
    ApiExceptionsHttpStatusCodeMapping      $exceptionHandler,
    private readonly RouletteHistoryUseCase $useCase
  )
  {
    parent::__construct($exceptionHandler);
  }

  public function __invoke(): JsonResponse
  {
    $userId = auth()->id();
    $response = $this->useCase->__invoke($userId);
    return $this->jsonResponse($response);

  }

  protected function exceptions(): array
  {
    return [];
  }
}
