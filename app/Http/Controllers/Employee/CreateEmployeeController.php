<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\GenericResource;
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

        if (is_null($employee)) {

            return (new GenericResource(__('api.model.not_created')))->response();
        }
        logger()->notice("O colaborador de id $employee->id foi criado.");

        return (new EmployeeResource($employee))->response();
    }
}
