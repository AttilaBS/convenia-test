<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class ClearUserCache
{
    public function __invoke(User $user): void
    {
        Cache::forget("employees-listing-$user->id");
    }
}
