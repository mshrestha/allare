<?php

namespace App\Http\Controllers\ImportData;

use App\Http\Controllers\Controller;
use App\Models\Data\CcCrAdditionalFoodSupplimentation;
use App\Traits\CurlHelper;
use App\Traits\PeriodHelper;
use Illuminate\Http\Request;

class CcCrAdditionalFoodSupplimentationController extends Controller
{
	use CurlHelper, PeriodHelper;

	private $data;

	public function __construct() {
		$this->data = config('data.child.vitamin_a_supplementation.cc_cr_additional_food_supplimentation');
	}

	public function import() {
		//Fetch periods string
		$periods = $this->getPeriods();
		$periods = $periods['years_months_string'];

		//Fetch category combo string
		$dx = $this->dataCategoryOptionCombo();

		$url = "{$this->data['server']}analytics.json?dimension=dx:{$dx}&dimension=pe:{$periods}&filter=ou:dNLjKwsVjod&displayProperty=NAME&skipMeta=false&includeNumDen=true";
		$response = $this->callUrl($url);
		print_r($response);
		$response = json_decode($response);

		$save_data = [];
		foreach($response->rows as $key => $row) {
			$save_data[$key]['value'] = $row[2];
			$save_data[$key]['period'] = $row[1];
			$save_data[$key]['period_name'] = $response->metaData->$row[1];
			$save_data[$key]['organisation_unit'] = 'dNLjKwsVjod';
			$save_data[$key]['category_option_combo'] = $row[0];
			$save_data[$key]['import_date'] = date('Y-m-d');
		}

		$cc_cr_additional_food_supplimentation = CcCrAdditionalFoodSupplimentation::insert($save_data);
		
		dd($cc_cr_additional_food_supplimentation);
	}

	private function dataCategoryOptionCombo() {
		$url = "{$this->data['server']}analytics.json?dimension=dx:{$this->data['api_id']}&dimension=pe:LAST_MONTH&filter=ou:dNLjKwsVjod&displayProperty=NAME&outputIdScheme=UID&skipData=true";
		$response = $this->callUrl($url);
		$response = json_decode($response);

		$dx = null;
		foreach($response->metaData->dimensions->co as $categoryOptionCombo) {
			$dx .= $this->data['api_id'].'.'.$categoryOptionCombo. ';';
		}
		$dx = trim($dx, ';');

		return $dx;
	}

	private function organisationUnitsString() {
		$organisation_units = config('static.organisations');
		
		$ou = null;
		foreach($organisation_units as $unit) {
			$ou .= $unit . ';';
		}
		$ou = trim($ou, ';');

		return $ou;
	}
}
