<?php

namespace Src\Shared\Domain\Criteria;

class CriteriaBuilder
{
  public static function simpleCriteria(?array $filter, ?string $orderBy, ?string $order, ?int $offset, ?int $limit): Criteria
  {
    $filter = self::transformFilter($filter);
    $filters = Filters::fromValues($filter);
    $order = Order::fromValues($orderBy, $order);
    return new Criteria($filters, $order, $offset, $limit);
  }

  public static function paginatedCriteria($filters, $orderBy, $order, $page, $pageSize): Criteria
  {
    $offset = ($page - 1) * $pageSize;
    $limit = $pageSize;
    $filters = Filters::fromValues($filters);
    $order = Order::fromValues($orderBy, $order);
    return new Criteria($filters, $order, $offset, $limit);
  }

  public static function simplePaginatedCriteria($filter, $orderBy, $order, $page, $pageSize): Criteria
  {
    $offset = ($page - 1) * $pageSize;
    $limit = $pageSize;
    $filters = Filters::fromValues(self::transformFilter($filter));
    $order = Order::fromValues($orderBy, $order);
    return new Criteria($filters, $order, $offset, $limit);
  }

  private static function transformFilter(?array $filter): ?array
  {
    return empty($filter) ? $filter : [$filter];
  }
}
