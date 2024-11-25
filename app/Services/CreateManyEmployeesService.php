<?php

namespace App\Services;

use App\Models\Employee;
use Exception;

class CreateManyEmployeesService
{
    public function __invoke(array $employeeData): bool
    {
        try {
            return app(Employee::class)->insert($employeeData);
        } catch (Exception $error) {
            /** @noinspection NullPointerExceptionInspection */
            logger()->error(
                'Ocorreu um erro ao criar os colaboradores da lista',
                ['error' => $error->getMessage()]
            );
        }

        return false;
    }
}
