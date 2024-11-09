<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\UserResource;
use App\Services\CreateUserService;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;

final class CreateUserController extends ApiController
{
    /**
     * @param CreateUserRequest $request
     * @param CreateUserService $createUserService
     * @return JsonResponse
     *
     * @throws BindingResolutionException
     * @throws Exception
     */
    public function __invoke(
        CreateUserRequest $request,
        CreateUserService $createUserService
    ): JsonResponse {
        $user = $createUserService($request->validated());

        logger()->notice("O usuário de id {$user->id} foi criado!");

        return (new UserResource(['user' => $user]))->response();
    }
}
