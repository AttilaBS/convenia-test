<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\GenericResource;
use App\Services\ListEmployeesService;
use Illuminate\Http\JsonResponse;

final class ListEmployeesController extends Controller
{
    public function __invoke(ListEmployeesService $listEmployeesService): JsonResponse
    {
        $employees = $listEmployeesService();
        if (is_null($employees)) {

            return (new GenericResource(__('api.employee.list_error')))->response();
        }

        return EmployeeResource::collection($employees)->response();
    }
}
