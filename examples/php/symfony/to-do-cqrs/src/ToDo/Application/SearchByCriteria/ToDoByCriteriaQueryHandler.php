<?php

declare(strict_types=1);

namespace ToDo\ToDo\Application\SearchByCriteria;

use ToDo\Shared\Domain\Bus\Query\QueryHandler;
use ToDo\Shared\Domain\Criteria\Filters;
use ToDo\Shared\Domain\Criteria\Order;
use ToDo\ToDo\Application\ToDosResponse;

final class ToDoByCriteriaQueryHandler implements QueryHandler
{
    public function __construct(private readonly ToDoByCriteriaSearcher $searcher)
    {
    }

    public function __invoke(SearchToDoByCriteriaQuery $query): ToDosResponse
    {
        $filters = Filters::fromValues($query->filters());
        $order = Order::fromValues($query->orderBy(), $query->order());

        return $this->searcher->search($filters, $order, $query->limit(), $query->offset());
    }
}
