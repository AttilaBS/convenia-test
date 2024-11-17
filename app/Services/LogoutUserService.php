<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class LogoutUserService
{
    /**
     * @return bool
     */
    public function __invoke(): bool
    {
        $user = auth()->user();
        if ($user) {
            $user->token()->revoke();

            return true;
        }

        return false;
    }
}
