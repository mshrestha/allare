<?php

namespace App\Http\Controllers\ImportData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\CurlHelper;

use App\Models\Data\ImciWasting;

class ImciWastingController extends Controller
{
    use CurlHelper;
    public function import() {
    	$data = config('data.imci_wasting');
    	for ($k=0; $k < count($data); $k++) { 
    		$currData = $data[$k];
            $save_array = [];
            $ou = config('static.organizations');
            for($j = 0; $j < count($ou); $j++) {
                $baseUrl = config('static.centralBaseUrl');
                if($currData['server'] == 'central')
                    $baseUrl = config('static.centralBaseUrl');
                else if($currData['server'] == 'community')
                    $baseUrl = config('static.communityBaseUrl');
                $url = $baseUrl.config('static.analyticsEP').'.json?dimension=dx:'.$currData['api_id'].'&dimension=pe:LAST_MONTH;&filter=ou:'.$ou[$j].'&displayProperty=NAME&outputIdScheme=UID&skipData=True';
                $responses = $this->callUrl($url);
                $responses = json_decode($responses);
                // dd($responses);
                $metaData = $responses->metaData;
                // dd($metaData->items);
                // $items = array_flip($metaData->items);
                $co = $metaData->dimensions->co;
                $dx = '';
                if(count($co) > 0) {
                    for($i = 0; $i < count($co); $i++) {
                        $dx .= $currData['api_id'].'.'.$co[$i].';';
                    }
                    $dx = rtrim($dx, ';');
                    $url = $baseUrl.config('static.analyticsEP').'.json?dimension=dx:'.$dx.'&dimension=pe:201801;201802;201701;201702;201703;201704;201705;201706;201707;201708;201709;201710;201711;201712;201601;201602;201603;201604;201605;201606;201607;201608;201609;201610;201611;201612;201501;201502;201503;201504;201505;201506;201507;201508;201509;201510;201511;201512;201401;201402;201403;201404;201405;201406;201407;201408;201409;201410;201411;201412;201301;201302;201303;201304;201305;201306;201307;201308;201309;201310;201311;201312;&filter=ou:'.$ou[$j].'&displayProperty=NAME&outputIdScheme=UID';
                    $responses = $this->callUrl($url);
                    $responses = json_decode($responses);
                    $metaData = $responses->metaData;
                    $rows = $responses->rows;
                    foreach ($rows as $keyrows => $row) {
                        $unit = [];
                        $unit['organisation_unit'] = $ou[$j];
                        foreach ($row as $key => $value) {
                            if($key == 0) {
                                $co = explode('.',$value)[1];
                                // $unit['name'] = $metaData->items->$value->name;
                                $unit['category_option_combo'] = $co;
                            }
                            else if($key == 1) {
                                $unit['period'] = $value?:'';
                                $unit['period_name'] = $metaData->items->$value->name;
                            }
                            else if($key == 2) {
                                $unit['value'] = $value;
                            }
                        }
                        $unit['import_date'] = date('Y-m-d');
                        array_push($save_array,$unit);
                    }
                    
                }
            }
            ImciWasting::unguard();
            ImciWasting::insert($save_array);
            ImciWasting::reguard();
    	}
    }
}
