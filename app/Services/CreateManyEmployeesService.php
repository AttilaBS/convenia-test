<?php

namespace App\Services;

use App\Models\Employee;
use Exception;

class CreateManyEmployeesService
{
    /**
     * @param array $employeeData
     * @return bool
     */
    public function __invoke(array $employeeData): bool
    {
        try {
            return app(Employee::class)->insert($employeeData);
        } catch (Exception $error) {
            /** @noinspection NullPointerExceptionInspection */
            logger()->error(
                'An Error happened when creating employees from list',
                [
                    'email' => $employeeData[0]['email'],
                    'cpf' => $employeeData[0]['cpf'],
                    'error' => $error->getMessage(),
                ]
            );
        }

        return false;
    }
}
