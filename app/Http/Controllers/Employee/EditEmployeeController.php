<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\GenericResource;
use App\Services\EditEmployeeService;
use Illuminate\Http\JsonResponse;

final class EditEmployeeController extends Controller
{
    public function __invoke(
        EmployeeRequest $request,
        EditEmployeeService $editEmployeeService,
        string $uuid
    ): JsonResponse {
        $validated = $request->validated();
        $updatedEmployee = $editEmployeeService($validated, $uuid);

        if (! $updatedEmployee) {
            $message = __('api.employee.not_updated', ['uuid' => $uuid]);
            logger()->error("Ocorreu um erro ao atualizar o colaborador de id $uuid.");

            return (new GenericResource($message))->response();
        }
        logger()->notice("O colaborador de id $uuid foi atualizado.");

        return (new EmployeeResource($updatedEmployee))->response();

    }
}
