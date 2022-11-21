<?php

declare(strict_types=1);

namespace ToDo\ToDo\Domain;

use ToDo\Shared\Domain\Criteria\Criteria;

interface ToDoRepository
{
    public function save(ToDo $item): void;

    public function searchAll(): array;

    public function matching(Criteria $criteria): array;
}
