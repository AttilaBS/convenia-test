<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\ListProcessed;
use App\Services\CreateManyEmployeesService;
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
     * @param array $employeesList
     * @return void
     */
    public function __construct(private readonly array $employeesList) {}

    /**
     * @return void
     * @noinspection NullPointerExceptionInspection
     */
    public function handle(): void
    {
        $message = __('api.employee.upload.list.success');
        $chunks = array_chunk($this->employeesList, 250);
        $user = app(User::class)->find($chunks[0][0]['manager_id']);
        $hasInserted = false;
        $chunkNumber = 1;
        foreach ($chunks as $chunk) {
            $hasInserted = app(CreateManyEmployeesService::class)($chunk);
            if ($hasInserted) {
                logger()->notice("The chunk: $chunkNumber was processed.");
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
