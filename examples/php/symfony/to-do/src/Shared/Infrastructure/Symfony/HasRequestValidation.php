<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

trait HasRequestValidation
{
    protected static int $validationErrorHttpCode = 429;

    abstract protected function validateRules();

    protected function validateRequest(Request $request): ConstraintViolationListInterface
    {
        $constraint = new Collection($this->validateRules());

        $input = $request->request->all();

        return Validation::createValidator()->validate($input, $constraint);
    }

    protected static function formatErrors(ConstraintViolationListInterface $violations): array
    {
        $errors = [];
        foreach ($violations as $violation) {
            $errors[str_replace(['[', ']'], ['', ''], $violation->getPropertyPath())] = $violation->getMessage();
        }

        return $errors;
    }
}
