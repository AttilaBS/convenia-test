<?php

namespace App\Services;

use App\Models\Employee;

class CreateEmployeeService
{
    public function __invoke(array $employeeData): ?Employee
    {
        $managerId = auth()->user()->id;

        return app(Employee::class)
            ->create(
                [
                    'name' => $employeeData['name'],
                    'email' => $employeeData['email'],
                    'cpf' => $employeeData['cpf'],
                    'city' => $employeeData['city'],
                    'state' => $employeeData['state'],
                    'manager_id' => $managerId,
                ]
            );
    }
}
