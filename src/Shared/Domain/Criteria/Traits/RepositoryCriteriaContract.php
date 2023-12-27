<?php

namespace Src\Shared\Domain\Criteria\Traits;

use Src\Shared\Domain\Criteria\Criteria;

interface RepositoryCriteriaContract
{
  public function matching(Criteria $criteria): array;

  public function matchingCount(Criteria $criteria): int;


}
