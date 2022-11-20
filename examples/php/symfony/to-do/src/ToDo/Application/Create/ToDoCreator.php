<?php

declare(strict_types=1);

namespace App\ToDo\Application\Create;

use App\ToDo\Domain\ToDo;
use App\ToDo\Domain\ToDoRepository;

final class ToDoCreator
{
    public function __construct(private readonly ToDoRepository $repository)
    {
    }

    public function create(string $id, string $name, bool $check): void
    {
        $this->repository->save(new ToDo($id, $name, $check));
    }
}
