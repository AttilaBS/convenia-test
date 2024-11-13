<?php

use App\Http\Controllers\Employee\CreateEmployeeController;
use App\Http\Controllers\Employee\CreateEmployeesFromListController;
use App\Http\Controllers\Employee\DeleteEmployeeController;
use App\Http\Controllers\Employee\EditEmployeeController;
use App\Http\Controllers\Employee\ListEmployeesController;
use App\Http\Controllers\User\CreateUserController;
use App\Http\Controllers\User\LoginUserController;
use App\Http\Controllers\User\LogoutUserController;
use Illuminate\Support\Facades\Route;

Route::get('/status', function (): string {
        return 'ok';
    }
    );

Route::middleware('throttle:user')->name('user.')->prefix('user')
    ->group(
        function (): void {
            Route::post('register', CreateUserController::class);
            Route::post('login', LoginUserController::class);
            Route::middleware('auth:api')->group(function(): void {
                Route::get('logout', LogoutUserController::class);
            });
        });

Route::middleware('auth:api')->group(function (): void {
    Route::name('employee.')->prefix('employee')
        ->group(
            function (): void {
                Route::post('/upload-list', CreateEmployeesFromListController::class)
                    ->name('upload-list');
                Route::post('/create', CreateEmployeeController::class)
                    ->name('create');
                Route::get('/list', ListEmployeesController::class)
                    ->name('list');
                Route::put('/edit/{uuid}', EditEmployeeController::class)
                    ->name('edit');
                Route::delete('/delete/{uuid}', DeleteEmployeeController::class)
                    ->name('delete');
            }
        );
}
);
