<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Services\DeleteEmployeeService;

final class DeleteEmployeeController extends Controller
{
    public function __invoke(
        string $uuid,
        DeleteEmployeeService $deleteEmployeeService
    )
    {
        $deleted = $deleteEmployeeService($uuid);

        if ($deleted) {
            return response()->json(
                [
                    'message' => 'Employee id: '. $uuid .'successfully deleted'
                ],
                200
            );
        }

        return response()->json(
            [
                'message' => 'An error occured while deleting the employee'
            ],
            500
        );
    }
}
