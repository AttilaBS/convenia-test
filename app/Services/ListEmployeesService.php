<?php

namespace App\Services;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class ListEmployeesService
{
    public function __invoke(): Collection|null
    {
        $userId = auth()->user()->id;
        return Cache::remember(
            "employees-listing-$userId",
            60,
            function () use ($userId) {
                return app(Employee::class)
                    ->where('manager_id', $userId)
                    ->get();
        });
    }
}
