<?php

declare(strict_types=1);

namespace App\Shared\Domain;

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
}
