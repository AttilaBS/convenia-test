<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

final class LogoutUserController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $user = auth()->user();
        if ($user) {
            if (! $user->token()) {
                return response()->json(
                    [
                        'message' => 'Usuário não logado.',
                    ],
                    401
                );
            }
            $user->token()->revoke();

            return (new UserResource(['user' => $user]))->response();
        }

        return response()->json(
            [
                'message' => 'Usuário não encontrado.',
            ],
            404
        );
    }
}
