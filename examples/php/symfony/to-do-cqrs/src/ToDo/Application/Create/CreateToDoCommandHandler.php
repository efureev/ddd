<?php

declare(strict_types=1);

namespace ToDo\ToDo\Application\Create;

use ToDo\Shared\Domain\Bus\Command\CommandHandler;
use ToDo\ToDo\Domain\ValueObject\ToDoCheck;
use ToDo\ToDo\Domain\ValueObject\ToDoId;
use ToDo\ToDo\Domain\ValueObject\ToDoNameName;

final class CreateToDoCommandHandler implements CommandHandler
{
    public function __construct(private readonly ToDoCreator $creator)
    {
    }

    public function __invoke(CreateToDoCommand $command): void
    {
        $id = new ToDoId($command->id());
        $name = new ToDoNameName($command->name());
        $check = new ToDoCheck($command->check());

        $this->creator->__invoke($id, $name, $check);
    }
}
