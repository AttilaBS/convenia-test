<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\UserResource;
use App\Services\CreateUserService;
use Exception;
use Illuminate\Http\JsonResponse;

final class CreateUserController extends Controller
{
    /**
     * @param CreateUserRequest $request
     * @param CreateUserService $createUserService
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function __invoke(
        CreateUserRequest $request,
        CreateUserService $createUserService
    ): JsonResponse {
        [$user, $token] = $createUserService($request->validated());

        logger()->notice("O usuário de id {$user->id} foi criado!");

        return (new UserResource(['user' => $user, 'token' => $token]))->response();
    }
}
