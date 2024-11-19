<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\GenericResource;
use App\Services\LogoutUserService;
use Illuminate\Http\JsonResponse;

final class LogoutUserController extends Controller
{
    public function __invoke(LogoutUserService $logoutUserService): JsonResponse
    {
        $return = $logoutUserService();
        $return ? __('api.user.logout.success') : __('api.user.logout_error');

        return (new GenericResource($return))->response();
    }
}
