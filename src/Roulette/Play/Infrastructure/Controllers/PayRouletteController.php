<?php

declare(strict_types=1);

namespace Src\Roulette\Play\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Src\Management\Login\Application\Find\LoginAuthUseCase;
use Src\Management\Login\Domain\Exceptions\InvalidCredentialsException;
use Src\Roulette\Play\Application\Save\PayRouletteUseCase;
use Src\Roulette\Play\Domain\Exceptions\WithoutSufficientBalance;
use Src\Shared\Infrastructure\Laravel\ApiExceptionsHttpStatusCodeMapping;
use Src\Shared\Infrastructure\Laravel\SimpleApiController;
use Symfony\Component\HttpFoundation\Response;

final class PayRouletteController extends SimpleApiController
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
    $response = $this->useCase->__invoke($userId, $color);
    return $this->jsonResponse($response);
  }

  protected function exceptions(): array
  {
    return [
      WithoutSufficientBalance::class => Response::HTTP_BAD_REQUEST,
    ];
  }
}
