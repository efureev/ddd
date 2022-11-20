<?php

declare(strict_types=1);

namespace App\ToDo\Domain;

/**
 * @Entity
 */
class ToDo
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
