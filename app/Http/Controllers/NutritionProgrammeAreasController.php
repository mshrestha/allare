<?php

namespace App\Http\Controllers;

use App\Traits\CurlHelper;
use Illuminate\Http\Request;

class NutritionProgrammeAreasController extends Controller
{
	use CurlHelper;

    public function index() {
    	return view('nutrition.nutrition-programme-areas');
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


}
