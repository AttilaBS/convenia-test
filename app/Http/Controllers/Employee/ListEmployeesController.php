<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Services\ListEmployeesService;
use Illuminate\Http\JsonResponse;

final class ListEmployeesController extends Controller
{
    public function __invoke(ListEmployeesService $listEmployeesService): JsonResponse
    {
        $employees = $listEmployeesService();

        return (EmployeeResource::collection($employees))->response();
    }
}
