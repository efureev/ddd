<?php

declare(strict_types=1);

namespace ToDo\Shared\Infrastructure\Symfony;

use Php\Support\Helpers\Str;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use ToDo\Shared\Domain\DomainError;

final class ApiExceptionListener
{
    public function __construct(private readonly ApiExceptionsHttpStatusCodeMapping $exceptionHandler)
    {
    }

    public function onException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $event->setResponse(
            new JsonResponse(
                [
                    'code' => $this->exceptionCodeFor($exception),
                    'message' => $exception->getMessage(),
                ],
                $this->exceptionHandler->statusCodeFor($exception::class)
            )
        );
    }

    private function exceptionCodeFor(\Throwable $error): string
    {
        $domainErrorClass = DomainError::class;

        return $error instanceof $domainErrorClass
            ? $error->errorCode()
            : Str::toSnake(class_basename($error));
    }
}
