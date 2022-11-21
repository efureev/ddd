<?php

declare(strict_types=1);

namespace ToDo\ToDo\Infrastructure\Repository;

use ToDo\Shared\Domain\Criteria\Criteria;
use ToDo\Shared\Infrastructure\Repository\Elasticsearch\ElasticsearchRepository;
use ToDo\ToDo\Domain\ToDo;
use ToDo\ToDo\Domain\ToDoRepository;

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

    public function matching(Criteria $criteria): array
    {
        return mapValue($this->toEntity(), $this->searchByCriteria($criteria));
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
