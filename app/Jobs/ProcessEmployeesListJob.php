<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProcessEmployeesListJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 600;

    public function __construct(
        private readonly string $filePath,
        private readonly int $managerId,
        private readonly string $directory
    ) {}

    public function handle(): void
    {
        if (Storage::disk('local')->exists($this->filePath)) {
            $employeesToInsert = $this->iterateThruList();
            dispatch(new CreateEmployeesFromListJob($employeesToInsert))->onQueue('employees');

            Storage::disk('local')->deleteDirectory($this->directory);
        } else {
            logger()->error("Folder with name $this->filePath not found !");
        }
    }

    /**
     * @return array<string, string>
     */
    private function iterateThruList(): array
    {
        $fileStream = fopen(storage_path('app/private/'.$this->filePath), 'rb');
        $skipHeader = true;
        $employees = [];
        while ($row = fgetcsv($fileStream)) {
            if ($skipHeader) {
                $skipHeader = false;

                continue;
            }
            $employees[] = [
                'id' => Str::uuid()->toString(),
                'name' => $row[0],
                'email' => $row[1],
                'cpf' => $row[2],
                'city' => $row[3],
                'state' => $row[4],
                'manager_id' => $this->managerId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        fclose($fileStream);

        return $employees;
    }
}
