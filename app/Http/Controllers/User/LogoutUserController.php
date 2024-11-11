<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

final class LogoutUserController extends Controller
{
    public function __invoke(): JsonResponse {
        $user = auth()->user();
        if ($user) {
            if (! $user->token()) {
                return response()->json(__('User not logged in.'));
            }
            $user->token()->revoke();

            return (new UserResource(['user' => $user]))->response();
        }

        return response()->json(__('User not found.'));
    }
}
