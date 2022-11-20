<?php

declare(strict_types=1);

namespace App\Controller\ToDo;

use App\Shared\Infrastructure\Symfony\ApiController;
use App\Shared\Infrastructure\Symfony\HasRequestValidation;
use App\ToDo\Application\Create\ToDoCreator;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;

#[Route(path: 'create', methods: 'POST', stateless: true)]
final class ToDoCreateController extends ApiController
{
    use HasRequestValidation;

    public function __invoke(Request $request, ToDoCreator $creator): JsonResponse
    {
        $validationErrors = $this->validateRequest($request);

        if ($validationErrors->count()) {
            return new JsonResponse($this->formatErrors($validationErrors), self::$validationErrorHttpCode);
        }

        return new JsonResponse(['id' => $this->createToDo($creator, $request)], 201);
    }

    protected function validateRules(): array
    {
        return [
            // 'id' => new Assert\Uuid(), // on update
            'name' => [new Assert\NotBlank(), new Assert\Length(['min' => 1, 'max' => 255])],
            'check' => new Assert\IsFalse(),
        ];
    }

    private function createToDo(ToDoCreator $creator, Request $request): string
    {
        $creator->create(
            $id = Uuid::uuid7()->toString(),
            (string)$request->request->get('name'),
            (bool)$request->request->get('check')
        );

        return $id;
    }
}
