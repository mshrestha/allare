<?php

namespace App\Http\Controllers\ImportData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\CurlHelper;
use App\Traits\PeriodHelper;

use App\Models\Data\ImciWasting;
use App\Models\Data\ImciStunting;
use App\Models\Data\ImciCounselling;
use App\Models\Data\ImciMale;
use App\Models\Data\ImciFemale;
use App\Models\Data\CcCrAdditionalFoodSuppliment;
use App\Models\Data\CcMrAncIfaDistribution;
use App\Models\Data\CcMrAncNutriCounsel;
use App\Models\Data\CcMrCounsellingAnc;
use App\Models\Data\CcMrWeightInKgAnc;
use App\Models\OrganizationUnit;

class ImporterController extends Controller
{
    use CurlHelper;
    use PeriodHelper;

    public function import() {
    	$data = config('datamodel');
    	for ($k=0; $k < count($data); $k++) {
    		$currData = $data[$k];
    		// dd($currData);
            $save_array = [];
            $ou = '';
            if($currData['server'] == 'central') {
            	$ou = config('static.centralOrganisation');
            }else if($currData['server'] == 'community') {
            	$ou = config('static.communityOrganisation');
            }
            // $ou = config('static.organizations');
            $pe = $this->getPeriods();
            $pe = $pe['years_months_string'];
            for($j = 0; $j < count($ou); $j++) {
                $baseUrl = config('static.centralBaseUrl');
                if($currData['server'] == 'central')
                    $baseUrl = config('static.centralBaseUrl');
                else if($currData['server'] == 'community')
                    $baseUrl = config('static.communityBaseUrl');
                $url = $baseUrl.config('static.analyticsEP').'?dimension=dx:'.$currData['api_id'].'&dimension=pe:LAST_MONTH&dimension=ou:'.$ou[$j].'&displayProperty=NAME&outputIdScheme=UID&skipData=True';

                $responses = $this->callUrl($url);
                $responses = json_decode($responses);
                
                // https://communitydhis.mohfw.gov.bd/nationalcc/api/26/analytics.json?dimension=dx:WfrGlt9gYxW.OJd05AWCFTk&dimension=pe:LAST_MONTH&filter=ou:dNLjKwsVjod&displayProperty=NAME&outputIdScheme=NAME

                // dd($url);
                $metaData = $responses->metaData;
                
                $co = $metaData->dimensions->co;
                $dx = '';
                if(count($co) > 0) {
                    for($i = 0; $i < count($co); $i++) {
                        $dx .= $currData['api_id'].'.'.$co[$i].';';
                    }
                    $dx = rtrim($dx, ';');
                    $url = $baseUrl.config('static.analyticsEP').'.json?dimension=dx:'.$dx.'&dimension=pe:'.$pe.'&filter=ou:'.$ou[$j].'&displayProperty=NAME&outputIdScheme=UID';
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
            

            $model = 'App\Models\Data\\'.$currData['model'];
            $model::insert($save_array);
    	}
    }
}