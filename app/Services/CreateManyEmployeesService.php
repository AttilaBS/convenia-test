<?php

namespace App\Services;

use App\Models\Employee;
use Exception;
use Illuminate\Database\Connection;
use Throwable;

class CreateManyEmployeesService
{
    public function __invoke(array $employeeData): bool
    {
        try {
            app(Connection::class)->transaction(function () use ($employeeData) {
                return app(Employee::class)->insert($employeeData);
            });
        } catch (Throwable $error) {
            /** @noinspection NullPointerExceptionInspection */
            logger()->error(
                'Ocorreu um erro ao criar os colaboradores da lista',
                ['error' => $error->getMessage()]
            );
        }

        return false;
    }
}
