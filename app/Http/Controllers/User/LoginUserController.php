<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\GenericResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\LoginUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

final class LoginUserController extends Controller
{
    public function __invoke(
        UserRequest $request,
        LoginUserService $loginUserService
    ): JsonResponse {
        $validated = $request->validated();
        [$user, $token] = $loginUserService($validated);

        if ($user && $token) {
            return (
                new UserResource(['user' => $user, 'token' => $token])
            )->response();
        }
        if ($user && ! $token) {
            $return = __('api.user.invalid_credentials');
        }
        if (! $user) {
            $return = __('api.model.not_found');
        }

        return (new GenericResource($return))->response();
    }
}
