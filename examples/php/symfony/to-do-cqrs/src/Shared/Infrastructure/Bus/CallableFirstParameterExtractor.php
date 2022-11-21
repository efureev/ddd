<?php

declare(strict_types=1);

namespace ToDo\Shared\Infrastructure\Bus;

use LogicException;
use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType;
use ToDo\Shared\Domain\Bus\Event\DomainEventSubscriber;
use ToDo\Shared\Domain\Utils;

final class CallableFirstParameterExtractor
{
    public static function forCallables(iterable $callables): array
    {
        return mapValue(self::unflatten(), Utils::reindex(self::classExtractor(new self()), $callables));
    }

    public static function forPipedCallables(iterable $callables): array
    {
        return Utils::reduce(self::pipedCallablesReducer(), $callables, []);
    }

    private static function classExtractor(CallableFirstParameterExtractor $parameterExtractor): callable
    {
        return static fn(callable $handler): ?string => $parameterExtractor->extract($handler);
    }

    private static function pipedCallablesReducer(): callable
    {
        return static function ($subscribers, DomainEventSubscriber $subscriber): array {
            $subscribedEvents = $subscriber::subscribedTo();

            foreach ($subscribedEvents as $subscribedEvent) {
                $subscribers[$subscribedEvent][] = $subscriber;
            }

            return $subscribers;
        };
    }

    private static function unflatten(): callable
    {
        return static fn($value) => [$value];
    }

    public function extract($class): ?string
    {
        $reflector = new ReflectionClass($class);
        $method = $reflector->getMethod('__invoke');

        if ($this->hasOnlyOneParameter($method)) {
            return $this->firstParameterClassFrom($method);
        }

        return null;
    }

    private function firstParameterClassFrom(ReflectionMethod $method): string
    {
        /** @var ReflectionNamedType $fistParameterType */
        $fistParameterType = $method->getParameters()[0]->getType();

        if (null === $fistParameterType) {
            throw new LogicException('Missing type hint for the first parameter of __invoke');
        }

        return $fistParameterType->getName();
    }

    private function hasOnlyOneParameter(\ReflectionMethod $method): bool
    {
        return $method->getNumberOfParameters() === 1;
    }
}
