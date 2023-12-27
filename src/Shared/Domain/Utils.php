<?php

declare(strict_types=1);

namespace Src\Shared\Domain;

use DateTimeImmutable;
use DateTimeInterface;
use InvalidArgumentException;
use ReflectionClass;
use RuntimeException;
use Throwable;

use function Lambdish\Phunctional\filter;

final class Utils
{

  public const NO_DELETE_FROM_ORIGINAL = 0;
  public const DELETE_FROM_ORIGINAL = 1;


  public static function endsWith(string $needle, string $haystack): bool
  {
    $length = strlen($needle);
    if ($length === 0) {
      return true;
    }

    return (substr($haystack, -$length) === $needle);
  }

  public static function dateToString(DateTimeInterface $date): string
  {
    return $date->format(DateTimeInterface::ATOM);
  }

  public static function stringToDate(string $date): DateTimeImmutable
  {
    return new DateTimeImmutable($date);
  }

  public static function jsonEncode(array $values): string
  {
    return json_encode($values, JSON_THROW_ON_ERROR);
  }

  public static function jsonDecode(string $json): array
  {
    $data = json_decode($json, true);

    if (JSON_ERROR_NONE !== json_last_error()) {
      throw new RuntimeException('Unable to parse response body into JSON: ' . json_last_error());
    }

    return $data;
  }

  public static function toSnakeCase(string $text): string
  {
    return ctype_lower($text) ? $text : strtolower((string)preg_replace('/([^A-Z\s])([A-Z])/', "$1_$2", $text));
  }

  public static function toCamelCase(string $text): string
  {
    return lcfirst(str_replace('_', '', ucwords($text, '_')));
  }

  public static function dot(array $array, string $prepend = ''): array
  {
    $results = [];
    foreach ($array as $key => $value) {
      if (is_array($value) && !empty($value)) {
        $results = array_merge($results, static::dot($value, $prepend . $key . '.'));
      } else {
        $results[$prepend . $key] = $value;
      }
    }

    return $results;
  }

  public static function filesIn(string $path, string $fileType): array
  {
    return filter(
      static fn(string $possibleModule) => strstr($possibleModule, $fileType),
      scandir($path)
    );
  }

  public static function extractClassName(object $object): string
  {
    $reflect = new ReflectionClass($object);

    return $reflect->getShortName();
  }

  public static function iterableToArray(iterable $iterable): array
  {
    if (is_array($iterable)) {
      return $iterable;
    }

    return iterator_to_array($iterable);
  }

  /**
   * Creates an array of objects of the specified class.
   * this class is utils for instance array of VO.
   *
   * @param array $params of values with unique parameter for each object.
   * @param string $class Name of the class to which each element of the array will be converted.
   * @return array of objects of the specified class.
   */
  public static function toArrayType(array $params, string $class): array
  {
    if (!class_exists($class)) {
      throw new InvalidArgumentException("La clase {$class} no existe.");
    }
    $arrayType = [];
    foreach ($params as $uniqueParam) {
      try {
        $arrayType[] = new $class($uniqueParam);
      } catch (Throwable $e) {
        throw new InvalidArgumentException("El valor {$uniqueParam} no es válido para la clase {$class}.");
      }
    }
    return $arrayType;
  }

  /**
   * Transform an array by extracting a specified key and reindexing the output by that key.
   *
   * @param array $inputArray The array to be transformed.
   * @param string $keyForReindex The key whose value will be used to reindex the output array.
   * @param array $keysToRemove An array of keys to remove from each subarray.
   * @return array The transformed array.
   */
  public static function reindexSyncArray(array $inputArray, string $keyForReindex, array $keysToRemove = []): array
  {
    $outputArray = [];

    foreach ($inputArray as $item) {
      if (isset($item[$keyForReindex])) {
        $reindexValue = $item[$keyForReindex];
        unset($item[$keyForReindex]);
        foreach ($keysToRemove as $keyToRemove) {
          unset($item[$keyToRemove]);
        }
        $outputArray[$reindexValue] = $item;
      }
    }

    return $outputArray;
  }

  /**
   * Extracts an array by internal key from an array of arrays, and add related key as property of internal array,
   * internal array can be removed from original array.
   *
   * @param string $internalArrayKey
   * @param string $relatedKey
   * @param array $originalArr
   * @param int $deleteMethod
   * @return array
   */
  public static function splitArrayWithRelatedKey(string $internalArrayKey,
                                                  string $relatedKey,
                                                  array  &$originalArr,
                                                  int    $deleteMethod = self::NO_DELETE_FROM_ORIGINAL): array
  {
    if (empty($originalArr)) {
      return [];
    }

    $splitArray = [];

    foreach ($originalArr as $key => $item) {
      if (isset($item[$internalArrayKey])) {
        foreach ($item[$internalArrayKey] as $internalItem) {
          $splitArray[] = array_merge($internalItem, [$relatedKey => $item[$relatedKey]]);
        }
      }
    }

    if ($deleteMethod === self::DELETE_FROM_ORIGINAL) {
      foreach ($originalArr as $key => &$item) {
        unset($item[$internalArrayKey]);
      }
    }

    return $splitArray;
  }

  /**
   * Extracts specified keys from a given associative array and returns the extracted values
   * in an indexed array. The last item in the returned array will be an associative array
   * containing the rest of the data.
   *
   * @param array $data The associative array from which to extract data.
   * @param array $keys An indexed array of keys to extract from the input data.
   *
   * @return array  Returns an indexed array where the first N items are the values corresponding
   *                to the requested keys (in the order they were requested). The last item in the
   *                array is an associative array containing the rest of the original data.
   *
   * @example
   *   $data = ['key1' => 'value1', 'key2' => 'value2', 'key3' => 'value3'];
   *   list($first, $second, $rest) = extractKeys($data, ['key1', 'key2']);
   *   // $first will be 'value1', $second will be 'value2', $rest will be ['key3' => 'value3']
   */
  public static function extractKeys(array $data, array $keys): array
  {
    $results = [];
    foreach ($keys as $key) {
      $results[] = $data[$key] ?? null;
    }
    // se obtiene el resto de los valores que no fueron extraídos
    $rest = array_diff_key($data, array_flip($keys));
    $results[] = $rest;
    return $results;
  }

  public static function toSnakeArray(array $array, int $level = 1): array
  {
    $data = [];
    foreach ($array as $key => $value) {
      // Si la clave es numérica, mantenemos el valor tal cual.
      if (is_numeric($key)) {
        if (is_array($value) && $level > 1) {
          // Si el valor es un array y aún no hemos alcanzado el nivel máximo, aplicamos recursivamente.
          $data[$key] = self::toSnakeArray($value, $level - 1);
        } else {
          // Mantenemos el valor tal cual para arrays posicionales o en el último nivel.
          $data[$key] = $value;
        }
      } else {
        // Para claves no numéricas, aplicamos la conversión a snake case.
        $newKey = self::toSnakeCase($key);
        if (is_array($value) && $level > 1) {
          $data[$newKey] = self::toSnakeArray($value, $level - 1);
        } else {
          $data[$newKey] = $value;
        }
      }
    }
    return $data;
  }

  public static function toCamelArray(array $array, int $level = 1): array
  {
    $data = [];
    foreach ($array as $key => $value) {
      // Si la clave es numérica, mantenemos el valor tal cual.
      if (is_numeric($key)) {
        if (is_array($value) && $level > 1) {
          // Si el valor es un array y aún no hemos alcanzado el nivel máximo, aplicamos recursivamente.
          $data[$key] = self::toCamelArray($value, $level - 1);
        } else {
          // Mantenemos el valor tal cual para arrays posicionales o en el último nivel.
          $data[$key] = $value;
        }
      } else {
        // Para claves no numéricas, aplicamos la conversión a snake case.
        $newKey = self::toCamelCase($key);
        if (is_array($value) && $level > 1) {
          $data[$newKey] = self::toCamelArray($value, $level - 1);
        } else {
          $data[$newKey] = $value;
        }
      }
    }
    return $data;
  }

  /**
   * Assigns `null` to optional keys in an array if they are not already defined.
   *
   * @param array $definedValues Associative array containing definitively present values.
   * @param array $optionalKeys Array of keys that may or may not be present in $definedValues.
   * @return array Returns a new array combining $definedValues with $optionalKeys.
   *               Keys from $optionalKeys that are not in $definedValues are added with a value of `null`.
   *
   * Example:
   * $definedValues = ['key1' => 'value1', 'key2' => 'value2'];
   * $optionalKeys = ['key3', 'key4'];
   * $result = assignOptionalValuesWithNullFallback($definedValues, $optionalKeys);
   * // $result will be ['key1' => 'value1', 'key2' => 'value2', 'key3' => null, 'key4' => null]
   */
  public static function assignOptionalValuesWithNullFallback(array $definedValues, array $optionalKeys): array
  {
    foreach ($optionalKeys as $key) {
      if (!array_key_exists($key, $definedValues)) {
        $definedValues[$key] = null;
      }
    }

    return $definedValues;
  }


}
