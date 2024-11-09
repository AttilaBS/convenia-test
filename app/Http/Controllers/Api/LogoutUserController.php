<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

final class LogoutUserController extends ApiController
{
    public function __invoke(): JsonResponse {
        $user = auth()->user();
        if ($user) {
            if (! $user->token()) {
                return response()->json(__('User not logged in.'));
            }
            $user->tokens()->delete();

            return (new UserResource(['user' => $user]))->response();
        }

        return response()->json(__('User not found.'));
    }
}
