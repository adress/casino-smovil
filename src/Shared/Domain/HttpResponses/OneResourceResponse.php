<?php

namespace Src\Shared\Domain\HttpResponses;

use Illuminate\Http\JsonResponse;

final class OneResourceResponse
{

  public function __construct(
    private readonly mixed $data,
    private readonly bool  $success,
    private readonly int   $statusCode,
  )
  {
  }

  public static function create(
    mixed $data,
    bool  $success = true,
    int   $statusCode = 200,
  ): self
  {
    return new self($data, $success, $statusCode);
  }

  public static function createSuccess(mixed $data, int $statusCode = 200): self
  {
    return new self($data, true, $statusCode);
  }

  public function data(): array
  {
    return $this->data;
  }

  public function success(): bool
  {
    return $this->success;
  }

  public function statusCode(): int
  {
    return $this->statusCode;
  }

  public function jsonResponse(): JsonResponse
  {
    return response()->json([
      'success' => $this->success,
      'data' => $this->data
    ], $this->statusCode);
  }
}
