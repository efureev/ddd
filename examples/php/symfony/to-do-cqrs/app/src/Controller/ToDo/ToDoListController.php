<?php

declare(strict_types=1);

namespace App\Controller\ToDo;

use App\ToDo\Application\ToDosResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use ToDo\Shared\Domain\Bus\Query\QueryBus;
use ToDo\ToDo\Application\SearchByCriteria\SearchToDoByCriteriaQuery;
use ToDo\ToDo\Application\ToDoResponse;

#[Route(path: 'list', methods: 'GET', stateless: true)]
final class ToDoListController
{
    public function __construct(private readonly QueryBus $queryBus)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $orderBy = $request->query->get('order_by');
        $order = $request->query->get('order');
        $limit = $request->query->get('limit');
        $offset = $request->query->get('offset');

        /** @var ToDosResponse $response */
        $response = $this->queryBus->ask(
            new SearchToDoByCriteriaQuery(
                (array)$request->query->get('filters'),
                null === $orderBy ? null : (string)$orderBy,
                null === $order ? null : (string)$order,
                null === $limit ? null : (int)$limit,
                null === $offset ? null : (int)$offset
            )
        );

        return new JsonResponse(
            mapValue(
                static fn(ToDoResponse $todo) => [
                    'id' => $todo->id(),
                    'name' => $todo->name(),
                    'check' => $todo->check(),
                ],
                $response->items()
            ),
            200
        );
    }
}
