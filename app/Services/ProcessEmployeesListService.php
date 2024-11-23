<?php

namespace App\Services;

use App\Jobs\ProcessEmployeesListJob;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\UnableToWriteFile;

class ProcessEmployeesListService
{
    public function __invoke(UploadedFile $list): bool
    {
        [$stored, $directory] = $this->storeList($list);
        if ($stored) {
            $managerId = auth()->user()->id;
            dispatch(
                new ProcessEmployeesListJob(
                    $stored,
                    $managerId,
                    $directory
                )
            )->onQueue('list');

            return true;
        }

        return false;
    }

    /**
     * @param UploadedFile $list
     * @return bool|array<bool, string>
     */
    private function storeList(UploadedFile $list): false|array
    {
        try {
            $directory = 'employees-'.now()->format('Y-m-d-H-i-s');
            $filePath = Storage::disk('local')->put($directory, $list);
        } catch (UnableToWriteFile|Exception $exception) {
            /** @noinspection NullPointerExceptionInspection */
            logger()->error(
                'An error occurred while uploading the list: ',
                ['exception' => $exception->getMessage()]
            );

            return false;
        }

        return [$filePath, $directory];
    }
}
