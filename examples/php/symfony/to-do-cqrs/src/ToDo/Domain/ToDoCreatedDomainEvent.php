<?php

declare(strict_types=1);

namespace ToDo\ToDo\Domain;

use ToDo\Shared\Domain\Bus\Event\DomainEvent;

final class ToDoCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        string                  $id,
        private readonly string $name,
        private readonly bool   $check,
        string                  $eventId = null,
        string                  $occurredOn = null
    )
    {
        parent::__construct($id, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'todo.created';
    }

    public static function fromPrimitives(
        string $aggregateId,
        array  $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent
    {
        return new self($aggregateId, $body['name'], $body['check'], $eventId, $occurredOn);
    }

    public function toPrimitives(): array
    {
        return [
            'name' => $this->name,
            'check' => $this->check,
        ];
    }

    public function name(): string
    {
        return $this->name;
    }

    public function check(): bool
    {
        return $this->check;
    }
}
