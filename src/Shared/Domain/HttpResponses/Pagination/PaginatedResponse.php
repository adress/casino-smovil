<?php

namespace Src\Shared\Domain\HttpResponses\Pagination;

class PaginatedResponse
{
  private array $items;
  private Pagination $pagination;

  public function __construct(array $items, Pagination $pagination)
  {
    $this->items = $items;
    $this->pagination = $pagination;
  }

  public function items(): array
  {
    return $this->items;
  }

  public function pagination(): Pagination
  {
    return $this->pagination;
  }

  public function makeResponse(): array
  {
    return [
      'success' => true,
      'code' => 200,
      'data' => $this->items,
      'pagination' => [
        'currentPage' => $this->pagination->currentPage(),
        'pageSize' => $this->pagination->pageSize(),
        'totalPages' => $this->pagination->totalPages(),
        'totalItems' => $this->pagination->totalItems()
      ]
    ];
  }

}
