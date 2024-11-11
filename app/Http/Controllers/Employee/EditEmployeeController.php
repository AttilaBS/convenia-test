<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
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
            return response()->json(
                [
                    'message' => 'The employee was not updated !',
                ],
                400
            );
        }

        return (new EmployeeResource($updatedEmployee))->response();

    }
}
