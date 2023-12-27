<?php

declare(strict_types=1);

namespace Src\Roulette\Users\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Roulette\Users\Application\Save\UserRegisterUseCase;
use Src\Shared\Infrastructure\Laravel\ApiExceptionsHttpStatusCodeMapping;
use Src\Shared\Infrastructure\Laravel\SimpleApiController;

final class UserRegisterController extends SimpleApiController
{
  public function __construct(
    ApiExceptionsHttpStatusCodeMapping   $exceptionHandler,
    private readonly UserRegisterUseCase $useCase
  )
  {
    parent::__construct($exceptionHandler);
  }

  public function __invoke(Request $request): JsonResponse
  {
    $rules = [
      'name' => 'required|string',
      'email' => 'required|email|unique:users',
      'password' => 'required|string|min:8',
    ];
    $this->validateRequest($request, $rules);

    $response = $this->useCase->__invoke(
      $request->input('name'),
      $request->input('email'),
      $request->input('password')
    );

    return $this->jsonResponse($response);
  }

  protected function exceptions(): array
  {
    return [];
  }
}
