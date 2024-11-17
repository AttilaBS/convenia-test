<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadEmployeesListRequest;
use App\Http\Resources\GenericResource;
use App\Services\ProcessEmployeesListService;
use Illuminate\Http\JsonResponse;

final class CreateEmployeesFromListController extends Controller
{
    public function __invoke(
        UploadEmployeesListRequest $request,
        ProcessEmployeesListService $processEmployeesListService
    ): JsonResponse {
        $isTrue = $processEmployeesListService($request->validated('list'));
        $return = $isTrue
            ? __('api.employee.upload.list.processing')
            : __('api.employee.upload.list.error');

        return (new GenericResource($return))->response();
    }
}
