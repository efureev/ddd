<?php

declare(strict_types=1);

namespace ToDo\ToDo\Application\Create;

use ToDo\Shared\Domain\Bus\Event\EventBus;
use ToDo\ToDo\Domain\ToDo;
use ToDo\ToDo\Domain\ToDoRepository;
use ToDo\ToDo\Domain\ValueObject\ToDoCheck;
use ToDo\ToDo\Domain\ValueObject\ToDoId;
use ToDo\ToDo\Domain\ValueObject\ToDoName;

final class ToDoCreator
{
    public function __construct(private readonly ToDoRepository $repository, private readonly EventBus $bus)
    {
    }

    public function __invoke(ToDoId $id, ToDoName $name, ToDoCheck $check): void
    {
        $todo = ToDo::create($id, $name, $check);
        $this->repository->save($todo);

        $this->bus->publish(...$todo->pullDomainEvents());
    }
}
