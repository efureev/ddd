<?php

declare(strict_types=1);

namespace ToDo\ToDo\Application\Create;

use ToDo\Shared\Domain\Bus\Command\Command;

final class CreateToDoCommand implements Command
{
    public function __construct(private readonly string $id, private readonly string $name, private readonly bool $check)
    {
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
