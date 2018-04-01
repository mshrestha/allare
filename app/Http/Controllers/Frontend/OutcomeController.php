<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrganisationUnit;
use App\Traits\PeriodHelper;

class OutcomeController extends Controller
{
	use PeriodHelper;
	public function indexAction() {
		$organisation_units = OrganisationUnit::where('level', 2)->get();
		$periods = $this->getPeriodYears();
		$data = config('data.outcomes');
		// dd($data);
		$indicators = [
			'imci_stunting' => 'Stunting',
			'imci_wasting' => 'Wasting',
			'exclusive_breastfeeding' => 'Exclusive Breastfeeding',
		];
		$trend_analysis = [
			[
				'name' => 'Stunting',
				'month' => 'Counseling Given - April',
				'percent' => '80',
			],
			[
				'name' => 'IFA Distribution',
				'month' => 'IFA Distributed - April',
				'percent' => '50',
			],
			[
				'name' => 'Weight Measurement',
				'month' => 'Weight gained - April',
				'percent' => '60',
			],
		];

		return view('frontend.outcome.index', compact('trend_analysis', 'organisation_units', 'periods', 'indicators'));
	}

	public function getOutcomeData(Request $request) {
		$data = config('data.outcomes');
		$requestData = $request->all();
		$indicator = $request->indicator_id;
		$source = $request->department_id;
		$ou = explode('.', $request->organisation_unit_id);
		// dd($data[$indicator][0]['server']);
		if($data[$indicator][0]['server'] == 'central')
			$ou = $ou[0];
		if($data[$indicator][0]['server'] == 'community')
			$ou = $ou[1];
		$pe = $this->getPeriodArray($request->period_id);
		// for ($i=0; $i < count($data[$indicator]); $i++) { 
		// 	dd($data[$indicator][$i]);
		// }

		$all_table_datas = [];
		$labels = [];
		$dataVals = [];
		foreach ($data[$indicator] as $table) {
			$model = 'App\Models\Data\\' . $table['model'];
			$datum = $model::whereIn('period', $pe)->where('source', $source)->where('organisation_unit', $ou)->whereNull('category_option_combo')->get();
			foreach ($datum as $key => $value) {
				array_push($labels, $value['period_name']);
				array_push($dataVals, $value['value']);
			}
		}
		return array(
				'labels' => $labels,
				'data' => $dataVals
			);

	}

	private function getPeriodArray($period) {
		if($period == "LAST_MONTH") {
			$current_year = date('Y');
			$current_month = date('m');
			if($current_month - 1 < 10) {
				$current_month = '0'.($current_month-1);
			}else {
				$current_month = ($current_month-1);
			}
			$pe = $current_year.$current_month;
			dd($pe);
		}else if($period == 'LAST_6_MONTHS') {
			$current_year = date('Y');
			$current_month = date('m');
			if($current_month - 1 < 10) {
				$current_month = '0'.($current_month-1);
			}else {
				$current_month = ($current_month-1);
			}
			$pe = $current_year.$current_month.';';
			for ($i = 2; $i < 7; $i++) {
			  $pe .= date('Ym', strtotime("-$i month")).';';
			}
			$pe = rtrim($pe, ';');
		} else {
			$pe = $period;
		}
		return explode(";", $pe);
	}
}
