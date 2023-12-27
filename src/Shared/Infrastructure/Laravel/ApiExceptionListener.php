<?php

declare(strict_types=1);

namespace Src\Shared\Infrastructure\Laravel;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use ReflectionClass;
use Src\Shared\Domain\DomainError;
use Src\Shared\Domain\Utils;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class ApiExceptionListener
{
  public function __construct(private readonly ApiExceptionsHttpStatusCodeMapping $exceptionHandler)
  {
  }

  public function handle(Throwable $exception, Request $request): ?JsonResponse
  {
    $statusCode = $this->exceptionHandler->strictStatusCodeFor($exception::class);

    // Si no se espera una respuesta JSON, deja que Laravel maneje la excepción de manera predeterminada
    if ($statusCode === null) return null;

    return new JsonResponse(
      [
        'code' => $this->exceptionCodeFor($exception),
        'message' => $exception->getMessage(),
      ],
      $statusCode
    );
  }

  private function exceptionCodeFor(Throwable $error): string
  {
    $domainErrorClass = DomainError::class;

    return $error instanceof $domainErrorClass
      ? $error->errorCode()
      : Utils::toSnakeCase($this->extractClassName($error));
  }

  private function extractClassName(object $object): string
  {
    $reflect = new ReflectionClass($object);

    return $reflect->getShortName();
  }

}
