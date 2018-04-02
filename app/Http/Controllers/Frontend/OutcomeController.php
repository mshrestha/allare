<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrganisationUnit;
use App\Traits\PeriodHelper;

use App\Models\Data\ImciStuntingPercent;
use App\Models\Data\ImciWastingPercent;


class OutcomeController extends Controller
{
	use PeriodHelper;
	public function indexAction() {
		$organisation_units = OrganisationUnit::where('level', 2)->get();
		$periods = $this->getPeriodYears();
		$flipped_period = array_flip($periods);

		$periodData = '';
		foreach ($flipped_period as $key => $value) {
			$periodData .= $value.';';
		}
		
		$periodData = rtrim($periodData, ';');
		$periodData = explode(";", $periodData);
		sort($periodData);

		$keys = array_reverse(array_keys($flipped_period));
		$keyPeriods = implode(';',$keys);

		$data = config('data.outcomes');
		// dd($data);
		$indicators = [
			'imci_stunting' => 'Stunting',
			'imci_wasting' => 'Wasting',
			'exclusive_breastfeeding' => 'Exclusive Breastfeeding',
		];
		$data = config('data.outcomes');
		$dataSet = [];
		
		foreach($indicators as $indicator => $indicatorName) {
			foreach ($data[$indicator] as $keyIndict => $indictData) {
				$ou = 'dNLjKwsVjod';
				$model = 'App\Models\Data\\' . $indictData['model'];
				$datum = $model::whereIn('period', $periodData)->where('organisation_unit', $ou)->whereNull('category_option_combo')->orderBy('period', 'asc')->get();
				if(count($data[$indicator]) > 1) {
					$dataSet[$indicatorName][$keyIndict]['title'] = $indictData['model'];
					$dataSet[$indicatorName][$keyIndict]['periods'] = $datum->pluck('period');
					$dataSet[$indicatorName][$keyIndict]['values'] = $datum->pluck('value');
				}else{
					$dataSet[$indicatorName]['title'] = $indictData['model'];
					$dataSet[$indicatorName]['periods'] = $datum->pluck('period');
					$dataSet[$indicatorName]['values'] = $datum->pluck('value');	
				}
			}
		}

		$trend_analysis = [];
		$stunting_percent = ImciStuntingPercent::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->get();
		$values = $stunting_percent->pluck('value');
		$period = $stunting_percent->pluck('period');


		$wasting_percent = ImciWastingPercent::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->get();
		$values = $stunting_percent->pluck('value');
		$period = $stunting_percent->pluck('period');

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
			// dd($pe);
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
