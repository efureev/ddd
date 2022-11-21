<?php

declare(strict_types=1);

namespace ToDo\ToDo\Application;

use ToDo\Shared\Domain\Bus\Query\Response;

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
