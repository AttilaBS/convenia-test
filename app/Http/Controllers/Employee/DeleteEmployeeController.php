<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Resources\GenericResource;
use App\Services\DeleteEmployeeService;
use Illuminate\Http\JsonResponse;

final class DeleteEmployeeController extends Controller
{
    public function __invoke(
        string $uuid,
        DeleteEmployeeService $deleteEmployeeService
    ): JsonResponse {
        $deleted = $deleteEmployeeService($uuid);
        $return = $deleted
            ? __('api.model.deleted', ['uuid' => $uuid])
            : __('api.model.not_deleted', ['uuid' => $uuid]);

        return (new GenericResource($return))->response();
    }
}
