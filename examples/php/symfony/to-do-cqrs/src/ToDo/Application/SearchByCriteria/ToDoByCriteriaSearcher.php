<?php

declare(strict_types=1);

namespace ToDo\ToDo\Application\SearchByCriteria;

use ToDo\Shared\Domain\Criteria\Criteria;
use ToDo\Shared\Domain\Criteria\Filters;
use ToDo\Shared\Domain\Criteria\Order;
use ToDo\ToDo\Application\ToDoResponse;
use ToDo\ToDo\Application\ToDosResponse;
use ToDo\ToDo\Domain\ToDo;
use ToDo\ToDo\Domain\ToDoRepository;

final class ToDoByCriteriaSearcher
{
    public function __construct(private readonly ToDoRepository $repository)
    {
    }

    public function search(Filters $filters, Order $order, ?int $limit, ?int $offset): ToDosResponse
    {
        $criteria = new Criteria($filters, $order, $offset, $limit);

        return new ToDosResponse(...mapValue($this->toResponse(), $this->repository->matching($criteria)));
    }

    private function toResponse(): callable
    {
        return static fn(ToDo $toDo) => new ToDoResponse(
            $toDo->id(),
            $toDo->name(),
            $toDo->check()
        );
    }
}
