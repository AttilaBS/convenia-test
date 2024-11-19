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
                ['error' => $error->getMessage()]
            );
        }

        return false;
    }
}
