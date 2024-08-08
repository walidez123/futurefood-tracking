<?php

namespace App\Jobs;

use App\Imports\ImportGood;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;



class ImportGoodsFromExcelAdmin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    protected $user;

    public function __construct($filePath, $user)
    {
        $this->filePath = $filePath;
        $this->user = $user;

    }

    public function handle()
    {

        try {
            $fullPath = Storage::path($this->filePath);

            Excel::import(new ImportGood($this->user), $this->filePath);

            Log::info('Import orders job completed successfully.');
        } catch (\Exception $e) {
            Log::error('Import orders job failed: '.$e->getMessage());
        }
    }
}
