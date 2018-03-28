<?php

namespace App\Http\Controllers;

use App\Traits\CurlHelper;
use Illuminate\Http\Request;

class NutritionProgrammeAreasController extends Controller
{
	use CurlHelper;

    public function index() {
        $periods = $this->periodsArray();

    	return view('nutrition.nutrition-programme-areas', compact('periods'));
    }

    public function periodsArray() {
        $current_year = date('y');
        $periods = [
            'LAST_MONTH' => '1 month',
            'LAST_6_MONTHS' => '6 months'
        ];

        for ($year=14; $year <= $current_year; $year++) { 
            $yr = 20 . $year;
            $periods[$yr] = $yr;
        }

        return $periods;
    }

    public function loadGeoJson() {
        // $geojson = $this->callUrl('https://centraldhis.mohfw.gov.bd/dhismohfw/api/organisationUnits.geojson?level=2');
    	
    	$geojson = file_get_contents(asset('js/test.geojson'));
    	$geojson = json_decode($geojson);

    	// dd($geojson);
    	return $geojson;
    }

    public function loadOrganisationUnitLevels() {
        $response = $this->callUrl('https://centraldhis.mohfw.gov.bd/dhismohfw/api/organisationUnitLevels.json?fields=id,displayName~rename(name),level&paging=false&_dc=1521655997780');
        
        return $response;
    }

    public function loadLevelBasedOrganisationUnits(Request $request) {
        $response = $this->callUrl('https://centraldhis.mohfw.gov.bd/dhismohfw/api/organisationUnits.json?paging=false&level='. $request->organisation_unit_levels_id);

        return $response;
    }

    public function loadDataValueSetJoint(Request $request) {
        $data = $request->all();
        $platformDiction = $data['platformDiction'];
        
        //Get data from server
        $data = $this->getDataSetJoint($platformDiction);
        $data_values = array_pluck($data['dataValueSets'], 'value');
        $data_values = array_map('intval', $data_values);

        //Cluster data to three arrays
        $cluster_array = $this->cluster_array($data_values);
       

        $min_max_avg = [
        	min($data_values),
        	max($data_values),
			(int)floor(array_sum($data_values)/count($data_values))
        ];

        $calculate = [
        	'min' => $cluster_array[$min_max_avg[0]],
        	'max' => $cluster_array[$min_max_avg[1]],
			'avg' => $cluster_array[$min_max_avg[2]]
        ];


        //populate geojson with data
        $geocoordinates = file_get_contents(public_path('js/test.geojson'));
    	$geocoordinates = json_decode($geocoordinates);

    	foreach ($geocoordinates->features as $geo_organisations) {
    		$geo_organisations->properties->data_value = $data['dataValueSets'][$geo_organisations->id]->value;
    		if(in_array($geo_organisations->properties->data_value, $calculate['min'])) {
    			$geo_organisations->properties->calc = 'min';
    		} else if (in_array($geo_organisations->properties->data_value, $calculate['max'])) {
    			$geo_organisations->properties->calc = 'max';
    		} else if (in_array($geo_organisations->properties->data_value, $calculate['avg'])) {
    			$geo_organisations->properties->calc = 'avg';
    		}
    	}
    	
        return ['geocoordinates' => $geocoordinates];
    }

 	public function closest($number, $array){
	    //infinite distance to start
	    $dist = INF;
	    //remember our last value
	    $last = false;

	    foreach($array as $v){
	        //get our current distance
	        $dist2 = abs($number - $v);

	        //check if we are getting further than last number was
	        if($dist2 > $dist){
	            //return our last value
	            return $last;
	        }
	        //set our new distance
	        $dist = $dist2;
	        //set our last value for next iteration
	        $last = $v;
	    }
	    return $last;
	}

	public function cluster_array($data_values) {
		$calculate = [
        	'min' => min($data_values),
        	'max' => max($data_values),
			'avg' => (int)floor(array_sum($data_values)/count($data_values))
        ];

        $clustered_data = [];
        foreach ($calculate as $cal) {
        	$clustered_data[$cal] = [];
        }

        foreach($data_values as $value) {
			$closest = $this->closest($value, $calculate);

        	array_push($clustered_data[$closest], $value);
        }

        return $clustered_data;
	}

	public function getDataSetJoint($platformDiction) {
		$dx = '';
        $programmes = explode(",", $platformDiction['programme']);

		if($platformDiction['affected'] == -1)
            for ($i=0; $i < count($programmes); $i++) { 
                if($i == count($programmes)-1)
                    $dx .= $programmes[$i];
                else
                    $dx .= $programmes[$i].';';
            }
        else
            for ($i=0; $i < count($programmes); $i++) { 
                if($i == count($programmes) -1)
                    $dx .= $programmes[$i].'.'.$platformDiction['affected'];
                else
                    $dx .= $programmes[$i].'.'.$platformDiction['affected'].';';
            }

        $pe = 'LAST_MONTH';
        if(strcasecmp('last_month', $platformDiction['period']) == 0 || strcasecmp('last_6_month', $platformDiction['period']) == 0 ) {
            $pe = $platformDiction['period'];
        } else {
            $platformDiction['period'] = str_replace(',', ';', $platformDiction['period']);
            $pe = $platformDiction['period'];
        }

       	$ou = '';
        if($platformDiction['organisation_units']) {
        	$ou = implode(';', $platformDiction['organisation_units']);
        }
        
        $url = config('static.centralBaseUrl').config('static.dataValueEP').'?dimension=dx:'.$dx.'&dimension=pe:'.$pe.'&dimension=ou:'.$ou.'&displayProperty=NAME';

        $responses = $this->callUrl($url);
        $responses = json_decode($responses);
        $dataValues = $responses->dataValues;

        $organisation_units = [];
        $values = [];

        for($i = 0; $i < count($dataValues); $i++) {
            $temp = $dataValues[$i];
            for($j = $i + 1; $j < count($dataValues); $j++) {
                if(strcasecmp($dataValues[$i]->period, $dataValues[$j]->period) > 0){
                    $temp = $dataValues[$i];
                    $dataValues[$i] = $dataValues[$j];
                    $dataValues[$j] = $temp;
                }
            }
        }//end for

        for ($i=0; $i < count($dataValues); $i++) { 
            $currData = $dataValues[$i];
            // dd($currData);
            if(!in_array($currData->orgUnit, $organisation_units)) {
                array_push($organisation_units, $currData->orgUnit);
            }

            $values[$currData->orgUnit] = $currData;
        }

        sort($organisation_units);

        return [
        	'organisation_units' => $organisation_units,
        	'dataValueSets' => $values
        ];
	}


	private function createPriceRange($array){
	    sort($array);
	    //Setting range limits.
	    //Check if array has 5 digit number.
	    $countDigitedNumbers5 = preg_grep('/\d{5}/',$array);
	    $countDigitedNumbers6 = preg_grep('/\d{6}/',$array);

	    if(count($countDigitedNumbers6)) {
	    	$rangeLimits = array(0,100000, 200000, 500000, 800000, 1000000);
	    } else if(count($countDigitedNumbers5)){
	        $rangeLimits = array(0,10000,20000,30000,40000,50000,60000,70000,80000,100000);
	    } else {
	        $rangeLimits = array(0,100, 250, 500, 1000, 2500, 5000, 10000);
	    }

	    $ranges = array();

	    for($i = 0; $i < count($rangeLimits); $i++){
	        if($i == count($rangeLimits)-1){
	            break;
	        }
	        $lowLimit = $rangeLimits[$i];
	        $highLimit = $rangeLimits[$i+1];

	        $ranges[$i]['ranges']['min'] = $lowLimit;
	        $ranges[$i]['ranges']['max'] = $highLimit;

	        foreach($array as $perPrice){
	            if($perPrice >= $lowLimit && $perPrice < $highLimit){
	                $ranges[$i]['values'][] = $perPrice;
	            }
	        }
	    }
	    return $ranges;
	}

}
