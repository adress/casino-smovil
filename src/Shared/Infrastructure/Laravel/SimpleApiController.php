<?php

namespace Src\Shared\Infrastructure\Laravel;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Shared\Domain\HttpResponses\OneResourceResponse;
use Symfony\Component\HttpFoundation\Response;
use function Lambdish\Phunctional\each;

abstract class SimpleApiController
{
  use ValidatesRequests;

  public function __construct(
    ApiExceptionsHttpStatusCodeMapping $exceptionHandler
  )
  {
    each(
      fn(int $httpCode, string $exceptionClass) => $exceptionHandler->register($exceptionClass, $httpCode),
      $this->exceptions()
    );
  }

  abstract protected function exceptions(): array;

  /**
   * Validate the given request with the given rules.
   *
   * @param Request $request
   * @param array $rules
   * @return array
   */
  protected function validateRequest(Request $request, array $rules): array
  {
    $validator = $this->getValidationFactory()->make($request->all(), $rules);

    if ($validator->fails()) {
      $this->failedValidation($validator);
    }

    return $validator->validated();
  }

  /**
   * Handle a failed validation attempt.
   *
   * @param \Illuminate\Contracts\Validation\Validator $validator
   * @return void
   *
   * @throws \Illuminate\Http\Exceptions\HttpResponseException
   */
  protected function failedValidation(Validator $validator): void
  {
    $response = new JsonResponse([
      'success' => false,
      'message' => 'Error de validación',
      'code' => 'validation_error',
      'errors' => $validator->errors(),
    ], Response::HTTP_UNPROCESSABLE_ENTITY);

    throw new HttpResponseException($response);
  }

  protected function jsonResponse(mixed $data = [], int $httpCode = Response::HTTP_OK, bool $success = true): JsonResponse
  {
    return OneResourceResponse::create($data, $success, $httpCode)->jsonResponse();
  }


}
