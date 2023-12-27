<?php

declare(strict_types=1);

namespace Src\Management\Login\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Management\Login\Application\Find\LoginAuthUseCase;
use Src\Management\Login\Application\Find\TokenRenewUseCase;
use Src\Management\Login\Domain\Exceptions\InvalidCredentialsException;
use Src\Shared\Infrastructure\Laravel\ApiExceptionsHttpStatusCodeMapping;
use Src\Shared\Infrastructure\Laravel\SimpleApiController;
use Symfony\Component\HttpFoundation\Response;

final class TokenRenewController extends SimpleApiController
{
  public function __construct(
    ApiExceptionsHttpStatusCodeMapping $exceptionHandler,
    private readonly TokenRenewUseCase $useCase
  )
  {
    parent::__construct($exceptionHandler);
  }

  public function __invoke(Request $request): JsonResponse
  {
    $token = $request->bearerToken();
    $response = $this->useCase->__invoke($token);

    return $this->jsonResponse($response);
  }

  protected function exceptions(): array
  {
    return [InvalidCredentialsException::class => Response::HTTP_UNAUTHORIZED];
  }
}
