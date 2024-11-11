<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Services\CreateEmployeeService;
use Illuminate\Http\JsonResponse;

final class CreateEmployeeController extends Controller
{
    public function __invoke(
        EmployeeRequest $request,
        CreateEmployeeService $createEmployeeService
    ): JsonResponse {
        $validated = $request->validated();
        $employee = $createEmployeeService($validated);

        return (new EmployeeResource($employee))->response();
    }
}
