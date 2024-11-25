<?php

namespace App\Services;

use App\Models\Employee;

class EditEmployeeService
{
    public function __invoke(array $employeeData, string $uuid): int|Employee
    {
        $updated = app(Employee::class)
            ->where('id', $uuid)
            ->where('manager_id', auth()->user()->id)
            ->update($employeeData);

        if ($updated === 1) {
            return app(Employee::class)->find($uuid);
        }

        return $updated;
    }
}
