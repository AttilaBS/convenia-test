<?php

namespace App\Services;

final class LogoutUserService
{
    /**
     * @return bool
     */
    public function __invoke(): bool
    {
        $user = auth()->user();
        if ($user) {
            /** @noinspection NullPointerExceptionInspection */
            $user->token()->revoke();

            return true;
        }

        return false;
    }
}
