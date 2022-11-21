<?php

declare(strict_types=1);

namespace ToDo\Shared\Infrastructure\Symfony;

use ToDo\Shared\Domain\Bus\Command\Command;
use ToDo\Shared\Domain\Bus\Command\CommandBus;
use ToDo\Shared\Domain\Bus\Query\Query;
use ToDo\Shared\Domain\Bus\Query\QueryBus;
use ToDo\Shared\Domain\Bus\Query\Response;

abstract class ApiController
{
    public function __construct(
        private readonly QueryBus          $queryBus,
        private readonly CommandBus        $commandBus,
        ApiExceptionsHttpStatusCodeMapping $exceptionHandler
    )
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

    protected function ask(Query $query): ?Response
    {
        return $this->queryBus->ask($query);
    }

    protected function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }
}
