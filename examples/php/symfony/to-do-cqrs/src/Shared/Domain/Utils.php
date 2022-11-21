<?php

declare(strict_types=1);

namespace ToDo\Shared\Domain;

use DateTimeInterface;

final class Utils
{
    public static function filesIn(string $path, string $fileType): array
    {
        return array_filter(
            scandir($path),
            static fn(string $possibleModule) => strstr($possibleModule, $fileType),
            ARRAY_FILTER_USE_BOTH
        );
    }

    public static function dateToString(DateTimeInterface $date): string
    {
        return $date->format(DateTimeInterface::ATOM);
    }

    public static function reindex(callable $fn, iterable $coll): array
    {
        $result = [];

        foreach ($coll as $key => $value) {
            $result[$fn($value, $key)] = $value;
        }

        return $result;
    }

    public static function reduce(callable $fn, iterable $coll, $initial = null)
    {
        $acc = $initial;

        foreach ($coll as $key => $value) {
            $acc = $fn($acc, $value, $key);
        }

        return $acc;
    }

}
