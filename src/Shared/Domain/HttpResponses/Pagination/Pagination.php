<?php

namespace Src\Shared\Domain\HttpResponses\Pagination;

class Pagination
{
  public function __construct(
    private readonly int $currentPage,
    private readonly int $pageSize,
    private readonly int $totalPages,
    private readonly int $totalItems)
  {
  }

  public static function create(int $currentPage, int $perPage, int $totalItems): Pagination
  {
    $totalPages = (int)ceil($totalItems / $perPage);
    return new self($currentPage, $perPage, $totalPages, $totalItems);
  }


  public function currentPage(): int
  {
    return $this->currentPage;
  }

  public function pageSize(): int
  {
    return $this->pageSize;
  }

  public function totalPages(): int
  {
    return $this->totalPages;
  }

  public function totalItems(): int
  {
    return $this->totalItems;
  }

}
