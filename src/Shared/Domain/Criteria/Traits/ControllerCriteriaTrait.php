<?php

namespace Src\Shared\Domain\Criteria\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Shared\Domain\HttpResponses\Pagination\PaginationDefaultConfig;

trait ControllerCriteriaTrait
{
//  protected $useCase;

  public function __invoke(Request $request): JsonResponse
  {
    $paginatedResponse = $this->useCase->__invoke(
      (array)$request->query('filters'),
      $request->query('orderBy'),
      $request->query('order'),
      (int)$request->query('page', PaginationDefaultConfig::DEFAULT_PAGE),
      (int)$request->query('pageSize', PaginationDefaultConfig::DEFAULT_PAGE_SIZE)
    );

    return response()->json($paginatedResponse->makeResponse());
  }
}
