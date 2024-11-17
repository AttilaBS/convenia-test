<?php

namespace App\Services;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class ListEmployeesService
{
    public function __invoke(): Collection|null
    {
        return Cache::remember('employees-listing', 60, function () {
            return app(Employee::class)
                ->where('manager_id', auth()->user()->id)
                ->get();
        });
    }
}
