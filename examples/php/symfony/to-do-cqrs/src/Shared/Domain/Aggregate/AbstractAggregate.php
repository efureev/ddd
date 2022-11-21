<?php

declare(strict_types=1);

namespace ToDo\Shared\Domain\Aggregate;

use ToDo\Shared\Domain\Bus\Event\DomainEvent;

abstract class AbstractAggregate
{
    private array $domainEvents = [];

    final public function pullDomainEvents(): array
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    final protected function record(DomainEvent $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }
}
