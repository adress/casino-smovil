<?php

declare(strict_types=1);

namespace Src\Roulette\Users\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Roulette\Users\Application\Save\UserRegisterUseCase;
use Src\Roulette\Users\Application\Save\UserUpdateBalanceUseCase;
use Src\Shared\Infrastructure\Laravel\ApiExceptionsHttpStatusCodeMapping;
use Src\Shared\Infrastructure\Laravel\SimpleApiController;

final class UserUpdateBalanceController extends SimpleApiController
{
  public function __construct(
    ApiExceptionsHttpStatusCodeMapping        $exceptionHandler,
    private readonly UserUpdateBalanceUseCase $useCase
  )
  {
    parent::__construct($exceptionHandler);
  }

  public function __invoke(int $id, Request $request): JsonResponse
  {
    $rules = [
      'balance' => 'required|int|min:0|max:1000000',
    ];
    $this->validateRequest($request, $rules);

    $response = $this->useCase->__invoke(
      $id,
      $request->input('balance')
    );

    return $this->jsonResponse($response);
  }

  protected function exceptions(): array
  {
    return [];
  }
}
