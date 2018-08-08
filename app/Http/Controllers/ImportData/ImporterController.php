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
use App\Models\Data\GeoJson;

use App\Models\OrganisationUnit;

use Maatwebsite\Excel\Facades\Excel;

class ImporterController extends Controller
{
    use CurlHelper;
    use PeriodHelper;

    public function import() {
        // dd($period);
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

            // $pe = '201803;201804';
            $pe = $this->getPeriods();
            // dd($pe);
            $pe = $pe['years_months_string'];
            for($j = 0; $j < count($ou); $j++) {
                $baseUrl = config('static.centralBaseUrl');
                if($currData['server'] == 'central')
                    $baseUrl = config('static.centralBaseUrl');
                else if($currData['server'] == 'community')
                    $baseUrl = config('static.communityBaseUrl');
                $url = $baseUrl.config('static.analyticsEP').'?dimension=dx:'.$currData['api_id'].'&dimension=pe:LAST_MONTH&filter=ou:'.$ou[$j].'&displayProperty=NAME&outputIdScheme=UID&skipData=True';
                // dd($url);
                $responses = $this->callUrl($url);
                $responses = json_decode($responses);
                
                // dd($url);
                // dd($responses);
                // if(is_object($responses)) {
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
                    // if(is_object($responses)) {
                        $metaData = $responses->metaData;
                        $rows = $responses->rows;
                        foreach ($rows as $keyrows => $row) {
                            $unit = [];
                            // $ouId = -1;
                            // if($ou[$j] == 'op5gbhjVCRk') {
                            //  $orgUnit = OrganizationUnit::where('id','R1GAfTe6Mkb')->first();
                            //  $ouId = $orgUnit->id;
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
                //     }
                // }
            }
            dd($save_array);
            $model = 'App\Models\Data\\'.$currData['model'];
            $model::insert($save_array);
            echo 'ok';
    	}
        dd('done');
    }

    public function importDistrict() {
        $data = config('datamodel');
        $flag = 0;
        for ($k=0; $k < count($data); $k++) {
            $currData = $data[$k];
            // dd($currData);
            $save_array = [];
            $ou = '';
            if($currData['server'] == 'central') {
                $ou = config('static.centDistrict');
            }else if($currData['server'] == 'community') {
                $ou = config('static.commDistrict');
            }

            // $pe = '201803;201804';
            $pe = $this->getPeriods();
            // dd($pe);
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
                // dd($responses);
                // if(is_object($responses)) {
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
                    // if(is_object($responses)) {
                        $metaData = $responses->metaData;
                        $rows = $responses->rows;
                        foreach ($rows as $keyrows => $row) {
                            $unit = [];
                            // $ouId = -1;
                            // if($ou[$j] == 'op5gbhjVCRk') {
                            //  $orgUnit = OrganizationUnit::where('id','R1GAfTe6Mkb')->first();
                            //  $ouId = $orgUnit->id;
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
                //     }
                // }
            }
            // dd($save_array);
            $model = 'App\Models\Data\\'.$currData['model'];
            $model::insert($save_array);
            echo 'ok';
        }
        dd('done');
    }

    public function scheduleImport() {
        // dd($period);
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

            $pe = 'LAST_MONTH';
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
                // dd($responses);
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
                    //  $orgUnit = OrganizationUnit::where('id','R1GAfTe6Mkb')->first();
                    //  $ouId = $orgUnit->id;
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
            
            $model = 'App\Models\Data\\'.$currData['model'];
            $model::insert($save_array);
        }
        // dd($save_array);
        dd('done');
    }

    public function mapImport() {
        $baseUrls = array(config('static.centralBaseUrl'), config('static.communityBaseUrl'));
        $url = 'https://communitydhis.mohfw.gov.bd/nationalcc/api/26/geoFeatures.json?ou=ou:dNLjKwsVjod;LEVEL-2&displayProperty=NAME';
        // foreach ($baseUrls as $key => $value) {
        // $url = $value.'geoFeatures.json?ou=ou:dNLjKwsVjod;LEVEL-2&displayProperty=NAME';
        $responses = $this->callUrl($url);
        $responses = json_decode($responses);
        
        $save_array = [];
        // dd($responses);
        foreach ($responses as $key => $value) {
            $unit = [];
            $unit['code'] = $value->code;
            $unit['organisation_unit'] = $value->id;
            $unit['coordinates'] =$value->co;
            $unit['import_date'] = date('Y-m-d H:i:s');
            if((strpos(strtolower($url), 'centraldhis') !== false)) {
                $unit['server'] = 'central';
            }else if((strpos(strtolower($url), 'communitydhis') !== false)) {
                $unit['server'] = 'community';
            }
            $unit['source'] = 'DHIS';
            array_push($save_array, $unit);
        }
        $model = new GeoJson();
        $model::insert($save_array);    
        // }
        // $url = 'https://communitydhis.mohfw.gov.bd/nationalcc/api/26/geoFeatures.json?ou=ou:dNLjKwsVjod;LEVEL-2&displayProperty=NAME';
        // $responses = $this->callUrl($url);
        // $responses = json_decode($responses);
        // dd($responses);
        dd('done');
    }

    public function importDGFPCsv() {
        $address = 'dgfp_data/dgfp_may_districts.xlsx';
        Excel::load($address, function($reader) {
            $results = $reader->get();
            // dd($results);
            $data = config('datamodel');
            $dataArray['a_n_c1s'] = [];
            $dataArray['a_n_c2s'] = [];
            $dataArray['a_n_c3s'] = [];
            $dataArray['a_n_c4s'] = [];
            $dataArray['p_n_c1s'] = [];
            $dataArray['p_n_c2s'] = [];
            $dataArray['p_n_c3s'] = [];
            $dataArray['p_n_c4s'] = [];
            $dataArray['cc_mr_anc_ifa_distribution'] = [];
            $dataArray['imci_counselling'] = [];
            $dataArray['cc_cr_exclusive_breast_feeding'] = [];
            $dataArray['imci_stunting'] = [];
            $dataArray['imci_wasting'] = [];
            $counter = 0;
            $orgs = [];
            foreach ($results as $result) {
                // dd($result);
                
                $unit = [];
                // $orgName = $result['division'];
                // if(strcasecmp('bangladesh', strtolower($result['division'])) !== 0)
                //     $orgName = $orgName.' division';

                $orgName = $result['district'];
                if(strcasecmp('bangladesh', strtolower($result['district'])) !== 0)
                    $orgName = $orgName.' district';

                $orgName = ucwords($orgName);
                $organization = OrganisationUnit::where('name', $orgName)->first();
                $ou = $organization->central_api_id;
                // array_push($orgs, $ou);
                $pe = (int)$result['date'];
                // $periods = explode(' ', $result['month']);
                // $pe = $periods[1].$this->getMonth($periods[0]);
                $source = 'DGFP';
                $unit['organisation_unit'] = $ou;
                $unit['category_option_combo'] = NULL;
                $unit['period'] = $pe;
                if(strlen($pe) == 4)
                    $unit['period_name'] = $pe;
                else if(strlen($pe) > 4)
                    $unit['period_name'] = $this->getPeriodName(substr($result['date'], -2), substr($result['date'], 0, 4));
                
                $unit['source'] = 'DGFP';
                $unit['server'] = 'central';
                $unit['import_date'] = date('Y-m-d');
                $unit['created_at'] = date('Y-m-d H:i:s');
                $unit['updated_at'] = date('Y-m-d H:i:s');
                
                $unit['value'] = $result['anc_1'];
                array_push($dataArray['a_n_c1s'], $unit);

                $unit['value'] = $result['anc_2'];
                array_push($dataArray['a_n_c2s'], $unit);

                $unit['value'] = $result['anc_3'];
                array_push($dataArray['a_n_c3s'], $unit);

                $unit['value'] = $result['anc_4'];
                array_push($dataArray['a_n_c4s'], $unit);

                $unit['value'] = $result['pnc_1'];
                array_push($dataArray['p_n_c1s'], $unit);

                $unit['value'] = $result['pnc_2'];
                array_push($dataArray['p_n_c2s'], $unit);

                $unit['value'] = $result['pnc_3'];
                array_push($dataArray['p_n_c3s'], $unit);

                $unit['value'] = $result['pnc_4'];
                array_push($dataArray['p_n_c4s'], $unit);



                $unit['value'] = $result['number_of_pregnant_woman_received_ifa'];
                array_push($dataArray['cc_mr_anc_ifa_distribution'], $unit);

                $unit['value'] = $result['exclusive_breast_feeding_up_to_6_months'];
                array_push($dataArray['cc_cr_exclusive_breast_feeding'], $unit);

                $unit['value'] = $result['idetified_stunting_child'];
                array_push($dataArray['imci_stunting'], $unit);

                $unit['value'] = $result['idetified_wasting_child'];
                array_push($dataArray['imci_wasting'], $unit);

                $unit['value'] = $result['counseling_on_iycf_ifavitamin_a_hand_washing'];
                array_push($dataArray['imci_counselling'], $unit);
                array_push($orgs, $unit['period_name']);
            }
            // dd($orgs);
            foreach ($dataArray as $key => $value) {
                for ($i=0; $i < count($data); $i++) { 
                    if($data[$i]['table'] == $key) {
                        $model = 'App\Models\Data\\'.$data[$i]['model'];
                        $model::insert($dataArray[$key]);   
                    }
                }
            }
            dd('done');
        });
    }

    public function truncateImportTables() {
        ImciWasting::truncate();
        ImciStunting::truncate();
        ImciCounselling::truncate();
        ImciMale::truncate();
        ImciFemale::truncate();
        ImciWastingPercent::truncate();
        ImciStuntingPercent::truncate();
        ImciTotalChild::truncate();
        ImciExclusiveBreastFeeding::truncate();
        CcCrAdditionalFoodSuppliment::truncate();
        CcMrAncIfaDistribution::truncate();
        CcMrAncNutriCounsel::truncate();
        CcMrCounsellingAnc::truncate();
        CcMrWeightInKgAnc::truncate();
        CcCrExclusiveBreastFeeding::truncate();
        CcCrTotalMale::truncate();
        CcCrTotalFemale::truncate();

        dd('All data tables truncated');
    }

    private function getPeriodName($month, $year) {
        switch ($month) {
            case '01':
                return 'January '.$year;
                break;

            case '02':
                return 'Febraury '.$year;
                break;

            case '03':
                return 'March '.$year;
                break;

            case '04':
                return 'April '.$year;
                break;

            case '05':
                return 'May '.$year;
                break;

            case '06':
                return 'June '.$year;
                break;

            case '07':
                return 'July '.$year;
                break;

            case '08':
                return 'August '.$year;
                break;

            case '09':
                return 'September '.$year;
                break;

            case '10':
                return 'October '.$year;
                break;

            case '11':
                return 'November '.$year;
                break;

            case '12':
                return 'December '.$year;
                break;
        }
    }

}