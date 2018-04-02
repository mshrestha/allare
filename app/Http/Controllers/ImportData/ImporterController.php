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
use App\Models\Data\ImciWastingPercent;
use App\Models\Data\ImciStuntingPercent;
use App\Models\Data\ImciTotalChild;
use App\Models\Data\ImciExclusiveBreastFeeding;
use App\Models\Data\CcCrAdditionalFoodSuppliment;
use App\Models\Data\CcMrAncIfaDistribution;
use App\Models\Data\CcMrAncNutriCounsel;
use App\Models\Data\CcMrCounsellingAnc;
use App\Models\Data\CcMrWeightInKgAnc;
use App\Models\Data\CcCrExclusiveBreastFeeding;
use App\Models\Data\CcCrTotalMale;
use App\Models\Data\CcCrTotalFemale;
use App\Models\OrganisationUnit;

class ImporterController extends Controller
{
    use CurlHelper;
    use PeriodHelper;

    public function import() {
    	$data = config('datamodel');
    	$flag = 0;
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

            $pe = $this->getPeriods();
            $pe = $pe['years_months_string'];
            for($j = 0; $j < count($ou); $j++) {
                $baseUrl = config('static.centralBaseUrl');
                if($currData['server'] == 'central')
                    $baseUrl = config('static.centralBaseUrl');
                else if($currData['server'] == 'community')
                    $baseUrl = config('static.communityBaseUrl');
                $url = $baseUrl.config('static.analyticsEP').'?dimension=dx:'.$currData['api_id'].'&dimension=pe:LAST_MONTH&filter=ou:'.$ou[$j].'&displayProperty=NAME&outputIdScheme=UID&skipData=True';

                $responses = $this->callUrl($url);
                $responses = json_decode($responses);
                
                // dd($url);
                dd($responses);
                $metaData = $responses->metaData;
                
                $co = $metaData->dimensions->co;

                $dx = $currData['api_id'].';';
                if(count($co) > 0) {
                	if($co != 'dCWAvZ8hcrs') {
                		$flag = 1;
	                    for($i = 0; $i < count($co); $i++) {
	                        $dx .= $currData['api_id'].'.'.$co[$i].';';
	                    }
                	}
                }
                // dd($co);
                $dx = rtrim($dx, ';');
                $url = $baseUrl.config('static.analyticsEP').'.json?dimension=dx:'.$dx.'&dimension=pe:'.$pe.'&filter=ou:'.$ou[$j].'&displayProperty=NAME&outputIdScheme=UID';
                $responses = $this->callUrl($url);
                $responses = json_decode($responses);
                // dd($url);
                // dd($responses);
                $metaData = $responses->metaData;
                $rows = $responses->rows;
                foreach ($rows as $keyrows => $row) {
                    $unit = [];
                    // $ouId = -1;
                    // if($ou[$j] == 'op5gbhjVCRk') {
                    // 	$orgUnit = OrganizationUnit::where('id','R1GAfTe6Mkb')->first();
                    // 	$ouId = $orgUnit->id;
                    // }
                    $unit['organisation_unit'] = $ou[$j];
                    foreach ($row as $key => $value) {
                        if($key == 0) {
                        	
                        	if($flag == 1) {
	                        	$co = explode('.',$value);
	                        	if(count($co) > 1) {
	                        		$co = $co[1];
	                        		// print_r($co); echo $url.'<br /><br />';
	                        	}else{
	                        		$co = NULL;
	                        	}

                            	// $flag = 0;

                            }else{
                            	$co = NULL;
                            }
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
                    $unit['source'] = $currData['source'];
                    $unit['server'] = $currData['server'];
                    $unit['import_date'] = date('Y-m-d');
                    $unit['created_at'] = date('Y-m-d H:i:s');
                    $unit['updated_at'] = date('Y-m-d H:i:s');
                    array_push($save_array,$unit);
                    // dd($save_array);
                }
                    
            }
            // dd($save_array);
            $model = 'App\Models\Data\\'.$currData['model'];
            $model::insert($save_array);
            echo 'ok';
    	}
        dd('done');
    }
}