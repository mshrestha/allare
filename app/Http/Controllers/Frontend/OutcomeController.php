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
		$organisation = explode('.', $request->organisation_unit_id);

		$labels = [];
		$vals = [];
		$dataVals = [];
		$titles = [];
		$count = 0;

		$mixed = 0;
		foreach ($data[$indicator] as $keyIndict => $indictData) {
			// dd($indictData);
			// print_r($organisation);
			if($indictData['server'] == 'central')
				$ou = $organisation[0];
			if($indictData['server'] == 'community')
				$ou = $organisation[1];
			$pe = $this->getPeriodArray($request->period_id);
			// dd($pe);
			$all_table_datas = [];
			// $labels = [];
			$titles[$count] = $indictData['model'];
			$count += 1;
			$vals[$keyIndict] = [];
			// echo $keyIndict.' '.$ou.' '.$source.'<br />';
			// dd($table);
			// print_r($indictData['model']);
			$model = 'App\Models\Data\\' . $indictData['model'];
			$datum = $model::whereIn('period', $pe)->where('source', $source)->where('organisation_unit', $ou)->whereNull('category_option_combo')->get();
			foreach ($datum as $key => $value) {
				// print_r($dataVals[$keyIndict]); echo '<br />';
				if($value['value'] != '' || $value['value'] != NULL) {
					if(!in_array($value['period_name'], $labels))
						array_push($labels, $value['period_name']);
					array_push($vals[$keyIndict], $value['value']);
				}
			}
		}
		
		$keys = array_keys($vals);
		
		if(count($vals) > 1) {
			$counter = 0;
			$mixed = 1;
			// $dataVals = array_fill(0, count($labels), []);
			foreach ($vals as $key => $value) {
				$vals[$key] = array_reverse($vals[$key]);
				$vals[$counter] = $vals[$key];
				unset($vals[$key]);
				// $vals[$counter] = $value;
				
				// foreach($value as $keyVal=>$val) {
				// 	// print_r($keyVal.'-'.$val); echo '<br />';
				// 	$dataVals[$counter][] = $value[$counter];	
				// 	// break;
				// 	$counter += 1;
				// }
				// unset($vals[$key]);

				$counter += 1;
			}
			$dataVals = $vals;
		} else {
			$dataVals = $vals[0];
		}
		// dd($dataVals);
		// exit();
		// dd($titles);
		// exit();
		
		$labels = array_reverse($labels);
		// $dataVals = array_reverse($dataVals);
		return array(
				'labels' => $labels,
				'data' => $dataVals,
				'titles' => $titles,
				'mixed' => $mixed
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
