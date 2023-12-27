<?php

declare(strict_types=1);

namespace Src\Roulette\Users\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Src\Roulette\Play\Application\Save\PayRouletteUseCase;
use Src\Shared\Infrastructure\Laravel\ApiExceptionsHttpStatusCodeMapping;
use Src\Shared\Infrastructure\Laravel\SimpleApiController;

final class UserFindByUserIdController extends SimpleApiController
{
  public function __construct(
    ApiExceptionsHttpStatusCodeMapping  $exceptionHandler,
    private readonly PayRouletteUseCase $useCase
  )
  {
    parent::__construct($exceptionHandler);
  }

  public function __invoke(string $color): JsonResponse
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
