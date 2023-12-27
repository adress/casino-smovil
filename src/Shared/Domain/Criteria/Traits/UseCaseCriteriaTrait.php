<?php

namespace Src\Shared\Domain\Criteria\Traits;

use Src\Shared\Domain\Criteria\CriteriaBuilder;
use Src\Shared\Domain\HttpResponses\Pagination\PaginatedResponse;
use Src\Shared\Domain\HttpResponses\Pagination\Pagination;

trait UseCaseCriteriaTrait
{
//  protected $repository;

  public function __invoke($filters, ?string $orderBy, ?string $order, int $page, int $pageSize): PaginatedResponse
  {
    $criteria = CriteriaBuilder::paginatedCriteria($filters, $orderBy, $order, $page, $pageSize);
    $items = $this->repository->matching($criteria);
    $totalItems = $this->repository->matchingCount($criteria);
    $pagination = Pagination::create($page, $pageSize, $totalItems);
    return new PaginatedResponse($items, $pagination);
  }
}
