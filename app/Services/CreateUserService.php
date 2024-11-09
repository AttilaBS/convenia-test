<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Hash;

final class CreateUserService
{
    /**
     * @param array<string> $parameters
     *
     * @return User
     */
    public function __invoke(array $parameters): User
    {
        $parameters['password'] = Hash::make($parameters['password']);
        return User::create($parameters);
    }
}
