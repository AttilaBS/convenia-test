<?php

namespace App\Services;

use App\Models\User;

final class LogoutUserService
{
    public function __invoke(User $user): bool
    {
        if ($user) {
            $user->token()->revoke();

            return true;
        }

        return false;
    }
}
