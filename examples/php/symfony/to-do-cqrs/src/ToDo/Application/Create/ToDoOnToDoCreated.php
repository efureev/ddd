<?php

declare(strict_types=1);

namespace ToDo\ToDo\Application\Create;

use ToDo\Shared\Domain\Bus\Event\DomainEventSubscriber;
use ToDo\ToDo\Domain\ToDoCreatedDomainEvent;

final class ToDoOnToDoCreated implements DomainEventSubscriber
{
    public function __construct(private readonly ToDoCreator $creator)
    {
    }

    public static function subscribedTo(): array
    {
        return [ToDoCreatedDomainEvent::class];
    }

    public function __invoke(ToDoCreatedDomainEvent $event): void
    {
        $this->creator->__invoke($event->aggregateId(), $event->name(), $event->check());
    }
}
