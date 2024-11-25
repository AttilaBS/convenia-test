<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\ListProcessed;
use App\Services\CreateManyEmployeesService;
use App\Services\ValidateListValues;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateEmployeesFromListJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 1200;

    /**
     * @return void
     */
    public function __construct(private readonly array $employeesList) {}

    /**
     * @noinspection NullPointerExceptionInspection
     */
    public function handle(): void
    {
        $message = __('api.employee.upload.list.success');
        $chunks = array_chunk($this->employeesList, 50);
        $user = app(User::class)->find($chunks[0][0]['manager_id']);
        $hasInserted = false;
        $hasValidated = false;
        $chunkNumber = 1;
        foreach ($chunks as $chunk) {
            $hasValidated = app(ValidateListValues::class)($chunk);
            if ($hasValidated === true) {
                $hasInserted = app(CreateManyEmployeesService::class)($chunk);
            } else {
                $message = __(
                    'api.employee.upload.list.validation_error',
                    ['error' => $hasValidated]
                );
                break;
            }
            if ($hasInserted) {
                logger()->notice("O bloco nº $chunkNumber foi inserido.");
                $chunkNumber++;
            } else {
                $message = __('api.employee.upload.list.failure',
                    ['attribute' => $chunkNumber]
                );
                break;
            }
        }
        $user->notify(new ListProcessed($message));
    }
}
