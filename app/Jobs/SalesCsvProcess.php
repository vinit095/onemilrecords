<?php

namespace App\Jobs;

use App\Models\Sales;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class SalesCsvProcess implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data, $header;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $header)
    {
        $this->data = $data;
        $this->header = $header;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->data as $sale) {
            unset($sale[0]);
            $saleData = array_combine($this->header, $sale);
            Sales::create($saleData);
        }
        // $path = storage_path('temp');
        // $files = glob("$path/*.csv");
        // $header = [];
        // foreach ($files as $key => $file) {
        //     $data = array_map('str_getcsv', file($file));
        //     if ($key === 0) {
        //         $header = array_shift($data);
        //         unset($header[0]);
        //         $header = array_values(array_map(function ($header) {
        //             return strtolower(str_replace(' ', '_', str_replace('/', ' ', str_replace('.', '', $header))));
        //         }, $header));
        //     }
        //     foreach ($data as $sale) {
        //         unset($sale[0]);
        //         $saleData = array_combine($header, $sale);
        //         Sales::create($saleData);
        //     }
        // }
    }

    public function failed(Throwable $exception)
    {
        // Send user notification of failure, etc...
    }
}
