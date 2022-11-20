<?php

declare(strict_types=1);

namespace App\ToDo\Application\SearchAll;

use App\ToDo\Application\ToDoResponse;
use App\ToDo\Application\ToDosResponse;
use App\ToDo\Domain\ToDo;
use App\ToDo\Domain\ToDoRepository;

final class ToDoAllSearcher
{
    public function __construct(private readonly ToDoRepository $repository)
    {
    }

    public function searchAll(): ToDosResponse
    {
        return new ToDosResponse(
            ...mapValue($this->toResponse(), $this->repository->searchAll())
        );
    }

    private function toResponse(): callable
    {
        return static fn(ToDo $todo) => new ToDoResponse(
            $todo->id(),
            $todo->name(),
            $todo->check()
        );
    }
}
