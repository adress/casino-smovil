<?php

namespace Src\Shared\Infrastructure\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Src\Shared\Domain\Criteria\Criteria;
use Src\Shared\Domain\Criteria\FilterOperator;

trait CriteriaTrait
{
//  abstract protected array $criteriaFilterable;

  public function scopeCriteriaFilter(Builder $query, Criteria $criteria): Builder
  {
    $query->when($criteria->hasFilters(), function ($query) use ($criteria) {
      return $this->applyQueryFilters($criteria, $query);
    });
    return $query;
  }

  private function applyQueryFilters(Criteria $criteria, $query): Builder
  {
    $relationalFilters = collect($this->criteriaFilterable ?? []);
    foreach ($criteria->filters()->filters() as $filter) {
      $firstWhere = $relationalFilters->firstWhere('field', $filter->field()->value());
      if ($firstWhere) {
        $query->whereHas($firstWhere['relation'],
          fn($q) => $this->applyFilter($q, $filter));
        continue;
      }
      $this->applyFilter($query, $filter);
    }
    return $query;
  }

  private function applyFilter($query, $filter, $fieldToSnakeCase = true): Builder
  {
    $field = $fieldToSnakeCase
      ? Str::snake($filter->field()->value())
      : $filter->field()->value();
    $operator = $filter->operator()->value();
    $value = $filter->value()->value();

    if ($operator === FilterOperator::CONTAINS) {
      return $query->where($field, 'ilike', '%' . $value . '%');
    }

    if ($operator === FilterOperator::BETWEEN) {
      return $query->whereBetween($field, explode(',', $value));
    }

    if ($operator === FilterOperator::IN) {
      return $query->whereIn($field, explode(',', $value));
    }

    return $query->where($field, $operator, $value);
  }

  public function scopeCriteriaOrder(Builder $query, Criteria $criteria, bool $fieldToSnakeCase = true)
  {
    return $query->when($criteria->hasOrder(), function ($query) use ($criteria, $fieldToSnakeCase) {
      $query->orderBy(
        $fieldToSnakeCase
          ? Str::snake($criteria->order()->orderBy()->value())
          : $criteria->order()->orderBy()->value(),
        $criteria->order()->orderType()->value());
    });
  }

  public function scopeCriteriaPagination(Builder $query, Criteria $criteria): Builder
  {
    return $query->offset($criteria->offset() ?? 0)
      ->limit($criteria->limit() ?? 100);
  }

}
