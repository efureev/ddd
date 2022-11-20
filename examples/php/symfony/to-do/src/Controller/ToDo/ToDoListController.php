<?php

declare(strict_types=1);

namespace App\Controller\ToDo;

use App\Shared\Domain\Utils;
use App\ToDo\Application\SearchAll\ToDoAllSearcher;
use App\ToDo\Application\ToDoResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: 'list', methods: 'GET', stateless: true)]
final class ToDoListController
{
    public function __construct(private readonly ToDoAllSearcher $searcher)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
//        $orderBy = $request->query->get('order_by');
//        $order = $request->query->get('order');
//        $limit = $request->query->get('limit');
//        $offset = $request->query->get('offset');

        $response = $this->searcher->searchAll();

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
