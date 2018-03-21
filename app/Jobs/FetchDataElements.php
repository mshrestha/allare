<?php

namespace App\Jobs;
use App\DataElements;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Traits\CurlHelper;

class FetchDataElements implements ShouldQueue
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
        $response = $this->execute('https://centraldhis.mohfw.gov.bd/dhismohfw/api/dataElements'. $this->orgUnit->id);

        $data = json_decode($response);
        // dd($data);
        $unit = new DataElements();
        $unit->api_id = $this->orgUnit->id;
        $unit->name = $this->orgUnit->displayName;
        // $unit->organisation_group_id = isset($data->organisationUnitGroups[0]) ? $data->organisationUnitGroups[0]->id : null;
        $unit->save();
    }
}
