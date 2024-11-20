<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\GenericResource;
use App\Services\ClearUserCache;
use App\Services\LogoutUserService;
use Illuminate\Http\JsonResponse;

final class LogoutUserController extends Controller
{
    public function __invoke(LogoutUserService $logoutUserService): JsonResponse
    {
        $user = auth()->user();
        $return = $logoutUserService($user);
        $message = __('api.user.logout_error');

        if ($return) {
            $message = __('api.user.logout_success');
            app(ClearUserCache::class)($user);
        }

        return (new GenericResource($message))->response();
    }
}
