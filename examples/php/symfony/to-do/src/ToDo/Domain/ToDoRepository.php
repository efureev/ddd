<?php

declare(strict_types=1);

namespace App\ToDo\Domain;

interface ToDoRepository
{
    public function save(ToDo $item): void;

    public function searchAll(): array;
}
