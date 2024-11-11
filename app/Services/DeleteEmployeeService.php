<?php

namespace App\Services;

use App\Models\Employee;

class DeleteEmployeeService
{
    /**
     * @param string $uuid
     * @return int
     */
    public function __invoke(string $uuid): int
    {
        return app(Employee::class)
            ->where('id', $uuid)
            ->where('manager_id', auth()->user()->id)
            ->delete();
    }
}
