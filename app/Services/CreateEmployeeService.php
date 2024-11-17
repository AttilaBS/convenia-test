<?php

namespace App\Services;

use App\Models\Employee;

class CreateEmployeeService
{
    /**
     * @param array $employeeData
     * @return Employee|null
     */
    public function __invoke(array $employeeData): Employee|null
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
