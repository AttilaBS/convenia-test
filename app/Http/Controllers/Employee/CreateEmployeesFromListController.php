<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadEmployeesListRequest;
use App\Services\ProcessEmployeesListService;

final class CreateEmployeesFromListController extends Controller
{
    public function __invoke(
        UploadEmployeesListRequest $request,
        ProcessEmployeesListService $processEmployeesListService
    ) {
        $isTrue = $processEmployeesListService($request->validated('list'));
        if ($isTrue) {
            return response()->json(
                [
                    'message' => 'A lista está sendo processada. Você receberá um email assim que o processo terminar.',
                ],
                200
            );
        }

        return response()->json(
            [
                'message' => 'Ocorreu um erro ao inserir a lista. Tente novamente mais tarde.',
            ],
            400
        );
    }
}
