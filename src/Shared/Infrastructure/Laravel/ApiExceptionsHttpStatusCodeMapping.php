<?php

declare(strict_types=1);

namespace Src\Shared\Infrastructure\Laravel;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use function Lambdish\Phunctional\get;

final class ApiExceptionsHttpStatusCodeMapping
{
  private const DEFAULT_STATUS_CODE = Response::HTTP_INTERNAL_SERVER_ERROR;
  private array $exceptions = [
    //TODO: uncomment this
    InvalidArgumentException::class => Response::HTTP_BAD_REQUEST,
    NotFoundHttpException::class => Response::HTTP_NOT_FOUND,
  ];

  public function register(string $exceptionClass, int $statusCode): void
  {
    $this->exceptions[$exceptionClass] = $statusCode;
  }

  public function strictStatusCodeFor(string $exceptionClass): ?int
  {
    return get($exceptionClass, $this->exceptions);
  }

  public function statusCodeFor(string $exceptionClass): int
  {
    $statusCode = get($exceptionClass, $this->exceptions, self::DEFAULT_STATUS_CODE);

    if ($statusCode === null) {
      throw new InvalidArgumentException("There are no status code mapping for <$exceptionClass>");
    }

    return $statusCode;
  }

}
