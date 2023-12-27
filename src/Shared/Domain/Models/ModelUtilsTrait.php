<?php

namespace Src\Shared\Domain\Models;

use Src\Shared\Domain\Utils;

trait ModelUtilsTrait
{
  public function toCamelArray(int $level = 1, bool $withTimestamps = false, array $removeKeys = []): array
  {
    $array = $this->toArray();

    if (!$withTimestamps) {
      $removeKeys = array_merge(
        $removeKeys,
        ['created_at', 'updated_at', 'deleted_at']
      );
    }

    $result = $this->removeKeysRecursive($array, $removeKeys, $level);

    return Utils::toCamelArray($result, $level);
  }

  private function removeKeysRecursive(array $array, array $removeKeys, int $level): array
  {
    if ($level <= 0) {
      return $array;
    }

    foreach ($array as $key => &$value) {
      if (in_array($key, $removeKeys)) {
        unset($array[$key]);
      } elseif (is_array($value)) {
        $value = $this->removeKeysRecursive($value, $removeKeys, $level - 1);
      }
    }

    return $array;
  }

}
