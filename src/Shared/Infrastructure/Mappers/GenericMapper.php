<?php

declare(strict_types=1);

namespace Src\Shared\Infrastructure\Mappers;

abstract class GenericMapper
{
  protected static array $mappings = [];
  protected static string $entityClass;

  public static function toArray(object $object): array
  {
    $data = [];
    foreach (static::$mappings as $objectProp => $arrayKey) {
      $data[$arrayKey] = $object->{$objectProp}();
    }
    return $data;
  }

  public static function toObject(array $data): object
  {
    $objectData = [];
    foreach (static::$mappings as $objectProp => $arrayKey) {
      $objectData[$objectProp] = $data[$arrayKey];
    }
    return new static::$entityClass(...array_values($objectData));
  }
}
