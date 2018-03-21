<?php

namespace App\Jobs;


use App\Traits\CurlHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FetchDataValue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, CurlHelper;

    protected $orgUnit;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($orgUnit)
    {
        $this->orgUnit = $orgUnit;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $response = $this->execute('https://centraldhis.mohfw.gov.bd/dhismohfw/api/26/dataValueSets.json?dataSet=MRAMSldVeTu&orgUnit='.$this->orgUnit.'&period=201701');

        $response = json_decode($response);
        // dd($response);
        return $response;
    }
}
