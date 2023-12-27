<?php

declare(strict_types=1);

namespace Src\Roulette\Users\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Src\Roulette\Users\Application\Find\UserFindAllUseCase;
use Src\Shared\Infrastructure\Laravel\ApiExceptionsHttpStatusCodeMapping;
use Src\Shared\Infrastructure\Laravel\SimpleApiController;

final class UserFindAllController extends SimpleApiController
{
  public function __construct(
    ApiExceptionsHttpStatusCodeMapping  $exceptionHandler,
    private readonly UserFindAllUseCase $useCase
  )
  {
    parent::__construct($exceptionHandler);
  }

  public function __invoke(): JsonResponse
  {
    $userId = auth()->id();
    $response = $this->useCase->__invoke();
    return $this->jsonResponse($response);
  }

  protected function exceptions(): array
  {
    return [];
  }
}
