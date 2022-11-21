<?php

declare(strict_types=1);

namespace ToDo\Shared\Domain\Bus\Query;

interface QueryBus
{
    public function ask(Query $query): ?Response;
}
