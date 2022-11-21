<?php

declare(strict_types=1);

namespace ToDo\ToDo\Domain;

use ToDo\Shared\Domain\Aggregate\AbstractAggregate;
use ToDo\ToDo\Domain\ValueObject\ToDoCheck;
use ToDo\ToDo\Domain\ValueObject\ToDoId;
use ToDo\ToDo\Domain\ValueObject\ToDoName;

/**
 * @Entity
 */
class ToDo extends AbstractAggregate
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly bool   $check
    )
    {
    }

    /**
     * @param array{id:string, name:string, check:bool} $primitives
     * @return ToDo
     */
    public static function make(array $primitives): ToDo
    {
        return new self($primitives['id'], $primitives['name'], $primitives['check']);
    }

    public static function create(ToDoId $id, ToDoName $name, ToDoCheck $check): self
    {
        $todo = new self($id->value(), $name->value(), $check->value());

        $todo->record(new ToDoCreatedDomainEvent($id->value(), $name->value(), $check->value()));

        return $todo;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'check' => $this->check,
        ];
    }

    public function id(): string
    {
        return $this->id;
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
