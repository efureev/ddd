<?php

declare(strict_types=1);

namespace App\ToDo\Infrastructure\Repository;

use App\ToDo\Domain\ToDo;
use App\ToDo\Domain\ToDoRepository;
use Ramsey\Uuid\Uuid;

final class DummyToDoRepository implements ToDoRepository
{
    public function save(ToDo $item): void
    {
    }

    public function searchAll(): array
    {
        return mapValue($this->toEntity(), $this->receiveDummy());
    }

    private function receiveDummy(): array
    {
        return [
            [
                'id' => (string)Uuid::uuid4(),
                'name' => 'Test note #1',
                'check' => false
            ], [
                'id' => (string)Uuid::uuid4(),
                'name' => 'Test note #2',
                'check' => true
            ], [
                'id' => (string)Uuid::uuid4(),
                'name' => 'Test note #3',
                'check' => false
            ]
        ];
    }

    private function toEntity(): callable
    {
        return static fn(array $primitives) => ToDo::make($primitives);
    }
}
