<?php

declare(strict_types=1);

namespace App\ToDo\Infrastructure\Repository;

use App\Shared\Infrastructure\Repository\Elasticsearch\ElasticsearchRepository;
use App\ToDo\Domain\ToDo;
use App\ToDo\Domain\ToDoRepository;

class ElasticsearchToDoRepository extends ElasticsearchRepository implements ToDoRepository
{
    public function save(ToDo $item): void
    {
        $this->persist($item->id(), $item->toArray());
    }

    public function searchAll(): array
    {
        return mapValue($this->toEntity(), $this->searchAllInElastic());
    }

    private function toEntity(): callable
    {
        return static fn(array $primitives) => ToDo::make($primitives);
    }

    protected function aggregateName(): string
    {
        return 'todos';
    }
}
