<?php

declare(strict_types=1);

namespace ToDo\Shared\Infrastructure\Bus\Query;

use RuntimeException;
use ToDo\Shared\Domain\Bus\Query\Query;

final class QueryNotRegisteredError extends RuntimeException
{
    public function __construct(Query $query)
    {
        $queryClass = $query::class;

        parent::__construct("The query <$queryClass> hasn't a query handler associated");
    }
}
