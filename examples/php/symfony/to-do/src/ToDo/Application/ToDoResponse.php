<?php

declare(strict_types=1);

namespace App\ToDo\Application;

use App\Shared\Domain\Response;

/**
 * @DTO
 */
final class ToDoResponse implements Response
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly bool   $check)
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
