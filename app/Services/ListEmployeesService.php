<?php

namespace App\Services;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;

class ListEmployeesService
{
    public function __invoke(): Collection
    {
        return app(Employee::class)
            ->where('manager_id', auth()->user()->id)
            ->get();
    }
}
