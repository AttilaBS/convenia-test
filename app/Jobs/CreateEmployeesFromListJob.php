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
    public function __construct(private readonly array $employeesList)
    {
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $chunks = array_chunk($this->employeesList, 250);
        foreach ($chunks as $chunk) {
            $hasInserted = app(CreateManyEmployeesService::class)($chunk);
            if ($hasInserted) {
                logger()->notice('Employees were created successfully from list.');
                $user = app(User::class)->find($chunk[0]['manager_id']);
                $user->notify((new ListProcessed())->delay(now()->addMinute()));
            }
        }
    }
}
