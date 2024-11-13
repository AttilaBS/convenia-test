<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
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
            return response()->json(
                [
                    'message' => 'O colaborador de id: '.$uuid.'foi removido com sucesso.',
                ],
                200
            );
        }

        return response()->json(
            [
                'message' => 'Ocorreu um erro ao remover o colaborador.',
            ],
            500
        );
    }
}
