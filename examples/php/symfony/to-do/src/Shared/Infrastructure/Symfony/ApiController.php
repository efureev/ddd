<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony;

abstract class ApiController
{
    public function __construct(ApiExceptionsHttpStatusCodeMapping $exceptionHandler)
    {
        eachValue(
            fn(int $httpCode, string $exceptionClass) => $exceptionHandler->register($exceptionClass, $httpCode),
            $this->exceptions()
        );
    }

    protected function exceptions(): array
    {
        return [];
    }
}
