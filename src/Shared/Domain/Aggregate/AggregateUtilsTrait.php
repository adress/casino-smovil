<?php

namespace Src\Shared\Domain\Aggregate;

use Src\Shared\Domain\Utils;

trait AggregateUtilsTrait
{
  public function addOrReplaceToArrayKeys(): array
  {
    return [];
  }

  public function toArray(): array
  {
    $data = [];
    foreach ($this as $key => $value) {
      $data[$key] = $value;
    }
    foreach ($this->addOrReplaceToArrayKeys() as $key => $value) {
      $data[$key] = $value;
    }
    return $data;
  }

  public function jsonSerialize(): array
  {
    return $this->toArray();
  }

  public function toSnakeArray($level = 1, array $removeKeys = []): array
  {
    $array = $this->toArray();
    $result = $this->removeKeysRecursive($array, $removeKeys, $level);
    return Utils::toSnakeArray($result, $level);
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
