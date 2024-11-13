<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

final class LoginUserController extends Controller
{
    public function __invoke(
        UserRequest $request
    ): JsonResponse {
        $validated = $request->validated();
        $user = app(User::class)
            ->where('email', $validated['email'])
            ->first();

        if ($user) {
            if (Hash::check($validated['password'], $user->password)) {
                $user->tokens()->latest()->first()?->revoke();
                $token = $user->createToken('api_token')->accessToken;

                return (
                    new UserResource(['user' => $user, 'token' => $token])
                )->response();
            }

            return response()->json(
                ['message' => 'Credenciais incorretas.'],
                401
            );
        }

        return response()->json(
            ['message' => 'Usuário não encontrado.'],
            404
        );
    }
}
