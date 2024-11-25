<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class LoginUserService
{
    /**
     * @param  array<string>  $parameters
     * @return array<object, string>
     */
    public function __invoke(array $parameters): array
    {
        $user = app(User::class)
            ->where('email', $parameters['email'])
            ->first();

        if ($user) {
            if (Hash::check($parameters['password'], $user->password)) {
                $user->tokens()->latest()->first()?->revoke();
                $token = $user->createToken('api_token')->accessToken;

                return [$user, $token];
            }

            return [$user, null];
        }

        return [null, null];
    }
}
