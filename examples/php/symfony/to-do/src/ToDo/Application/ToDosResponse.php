<?php

declare(strict_types=1);

namespace App\ToDo\Application;

use App\Shared\Domain\Response;

/**
 * @DTO
 */
class ToDosResponse implements Response
{
    private readonly array $items;

    public function __construct(ToDoResponse ...$todo)
    {
        $this->items = $todo;
    }

    public function items(): array
    {
        return $this->items;
    }
}
