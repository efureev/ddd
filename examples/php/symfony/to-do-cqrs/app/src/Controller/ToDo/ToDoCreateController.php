<?php

declare(strict_types=1);

namespace App\Controller\ToDo;

use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use ToDo\Shared\Infrastructure\Symfony\ApiController;
use ToDo\Shared\Infrastructure\Symfony\HasRequestValidation;
use ToDo\ToDo\Application\Create\CreateToDoCommand;

#[Route(path: 'create', methods: 'POST', stateless: true)]
final class ToDoCreateController extends ApiController
{
    use HasRequestValidation;

    public function __invoke(Request $request): JsonResponse
    {
        $validationErrors = $this->validateRequest($request);

        if ($validationErrors->count()) {
            return new JsonResponse($this->formatErrors($validationErrors), self::$validationErrorHttpCode);
        }

        return new JsonResponse(['id' => $this->createToDo($request)], 201);
    }

    protected function validateRules(): array
    {
        return [
            // 'id' => new Assert\Uuid(), // on update
            'name' => [new Assert\NotBlank(), new Assert\Length(['min' => 1, 'max' => 255])],
            'check' => new Assert\IsFalse(),
        ];
    }


    private function createToDo(Request $request): string
    {
        $this->dispatch(
            new CreateToDoCommand(
                $id = Uuid::uuid7()->toString(),
                (string)$request->request->get('name'),
                (bool)$request->request->get('check')
            )
        );

        return $id;
    }
}
