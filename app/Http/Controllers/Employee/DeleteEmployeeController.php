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

        if ($deleted) {
            logger()->notice("O colaborador de id $uuid foi removido.");
            $message = __('api.model.deleted', ['uuid' => $uuid]);
        } else {
            logger()->error("Ocorreu um erro ao remover o colaborador de id $uuid.");
            $message = __('api.model.not_deleted', ['uuid' => $uuid]);
        }

        return (new GenericResource($message))->response();
    }
}
