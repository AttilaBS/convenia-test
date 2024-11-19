<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class CreateUserService
{
    /**
     * @param array<string> $parameters
     *
     * @return array<object, string>
     */
    public function __invoke(array $parameters): array
    {
        $parameters['password'] = Hash::make($parameters['password']);
        $user = app(User::class)->create($parameters);
        $token = $user->createToken('api_token')->accessToken;

        return [$user, $token];
    }
}
