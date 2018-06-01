<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrganisationUnit;
use App\Traits\PeriodHelper;

use App\Models\Data\ImciStuntingPercent;
use App\Models\Data\ImciWastingPercent;
use App\Models\Data\ImciTotalChild;
use App\Models\Data\CcCrExclusiveBreastFeeding;
use App\Models\Data\CcCrTotalMale;
use App\Models\Data\CcCrTotalFemale;

use App\Models\Data\BdhsStunting;
use App\Models\Data\BdhsWasting;
use App\Models\Data\BdhsExclusiveBreastfeeding;


class ImpactController extends Controller
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
		$current_year = date('Y');
		$indicators = [
			'imci_stunting' => 'Stunting',
			'imci_wasting' => 'Wasting',
			'exclusive_breastfeeding' => 'Exclusive_Breastfeeding',
		];

		$goals = [
			'imci_stunting' => 'BdhsStunting',
			'imci_wasting' => 'BdhsWasting',
			'exclusive_breastfeeding' => 'BdhsExclusiveBreastfeeding',
		];
		$ou = 'dNLjKwsVjod';

		$data = config('data.outcomes');
		$dataSet = [];

		$imciTotalChild = ImciTotalChild::where('period', $current_year)->where('organisation_unit', $ou)->whereNull('category_option_combo')->orderBy('period', 'asc')->first()->value;
		$CcMaleTotal = CcCrTotalMale::where('period', $current_year)->where('organisation_unit', $ou)->whereNull('category_option_combo')->orderBy('period', 'asc')->first()->value;
		$CcFemaleTotal = CcCrTotalFemale::where('period', $current_year)->where('organisation_unit', $ou)->whereNull('category_option_combo')->orderBy('period', 'asc')->first()->value;
		$CcTotalChild = $CcMaleTotal + $CcFemaleTotal;
		$periods = [];
		foreach($indicators as $indicator => $indicatorName) {
			$counter = 0;
			$dataSet[$indicatorName] = [];
			foreach ($data[$indicator] as $keyIndict => $indictData) {
				$ou = 'dNLjKwsVjod';
				$model = 'App\Models\Data\\' . $indictData['model'];
				$goal_model = 'App\Models\Data\\'.$goals[$indicator];
				$datum = $model::whereIn('period', $periodData)->where('organisation_unit', $ou)->whereNull('category_option_combo')->orderBy('period', 'asc')->get();
				// $datum_goal = $model::where('period', $current_year)->where('organisation_unit', $ou)->whereNull('category_option_combo')->orderBy('period', 'asc')->first();
				$datum_goal = $goal_model::orderBy('period', 'desc')->first();
				// dd($datum_goal);
				if(count($data[$indicator]) > 1) {
					$periods = $datum->pluck('period');
					$dataSet[$indicatorName][$counter]['title'] = $indictData['model'];
					$dataSet[$indicatorName][$counter]['periods'] = $datum->pluck('period');
					$dataSet[$indicatorName][$counter]['goal_period'] = $datum_goal->period;
					$dataSet[$indicatorName][$counter]['values'] = $datum->pluck('value');	
					if($indictData['model'] == 'ImciExclusiveBreastFeeding')
						// $dataSet[$indicatorName][$counter]['goal_values'] = ($datum_goal->value / $imciTotalChild) * 100;
						$dataSet[$indicatorName][$counter]['goal_values'] = $datum_goal->value;
					else
						$dataSet[$indicatorName][$counter]['goal_values'] = $datum_goal->value;
						// $dataSet[$indicatorName][$counter]['goal_values'] = ($datum_goal->value / $CcTotalChild) * 100;
					$dataSet[$indicatorName][$counter]['goal'] = 'Goal 65% by 2021';

					$counter++;
				}else{
					$dataSet[$indicatorName]['title'] = $indictData['model'];
					$dataSet[$indicatorName]['periods'] = $datum->pluck('period');
					$dataSet[$indicatorName]['goal_period'] = $datum_goal->period;
					$dataSet[$indicatorName]['goal_values'] = $datum_goal->value;
					// $dataSet[$indicatorName]['goal_values'] = $datum_goal->value / $imciTotalChild * 100;
					$dataSet[$indicatorName]['values'] = $datum->pluck('value');	
					if($indictData['model'] == 'ImciStunting')
						$dataSet[$indicatorName]['goal'] = 'Goal 25% by 2021';
					else
						$dataSet[$indicatorName]['goal'] = 'Goal < 10% by 2021';

				}
			}
		}

		
		

		$goal_analysis = [];
		foreach ($goals as $goalKey => $goalValue) {
			$counter = 0;
			$goal_analysis[$goalValue] = [];
			foreach ($data[$goalKey] as $dataKey => $dataValue) {
				$ou = 'dNLjKwsVjod';
				$model = 'App\Models\Data\\' . $dataValue['model'];
				$datum = $model::where('period', $current_year)->where('organisation_unit', $ou)->whereNull('category_option_combo')->orderBy('period', 'asc')->first();

				if(count($data[$goalKey]) > 1) {
					$goal_analysis[$goalValue][$counter]['title'] = $dataValue['model'];
					$goal_analysis[$goalValue][$counter]['periods'] = $datum->period;
					if($dataValue['model'] == 'ImciExclusiveBreastFeeding')
						$goal_analysis[$goalValue][$counter]['values'] = ($datum->value / $imciTotalChild) * 100;
					else
						$goal_analysis[$goalValue][$counter]['values'] = ($datum->value / $CcTotalChild) * 100;

					$counter++;
				}else{
					$goal_analysis[$goalValue]['title'] = $dataValue['model'];
					$goal_analysis[$goalValue]['periods'] = $datum->period;
					$goal_analysis[$goalValue]['values'] = $datum->value;	
				}
			}
		}
		
		$trend_analysis = $dataSet;

		return view('frontend.impact.index', compact('trend_analysis', 'organisation_units', 'periods', 'indicators'));
	}

	public function secondIndexAction() {
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
		$current_year = date('Y');

		$indicators = [
			'Stunting prevalence in children under 5 years old' => 'BdhsStunting',
			'Wasting prevalence in children under 5 years old' => 'BdhsWasting',
			'Prevalence of Anemia in Women of Reproductive Age' => 'BdhsAnemia',
			'Exclusive Breastfeeding' => 'BdhsExclusiveBreastfeeding',
		];
		$ou = 'dNLjKwsVjod';

		$data = config('data.outcomes');
		$dataSet = [];

		foreach($indicators as $indicator => $indicatorName) {
			$counter = 0;
			$dataSet[$indicator] = [];
			
				$ou = 'dNLjKwsVjod';
				
				$goal_model = 'App\Models\Data\\'.$indicators[$indicator];
				$datum = $goal_model::where('organisation_unit', NULL)->orderBy('period', 'asc')->get();
				
				$datum_goal = $goal_model::orderBy('period', 'desc')->first();
				// dd($datum_goal);
				$dataSet[$indicator]['title'] = $indicator;
				$dataSet[$indicator]['periods'] = $datum->pluck('period');
				$dataSet[$indicator]['goal_period'] = $datum_goal->period;
				$dataSet[$indicator]['goal_values'] = $datum_goal->value;
				$dataSet[$indicator]['min'] = $goal_model::min('value');
				$dataSet[$indicator]['max'] = $goal_model::max('value');

				
				$dataSet[$indicator]['values'] = $datum->pluck('value');	
				if($indicators[$indicator] == 'BdhsStunting') {
					$dataSet[$indicator]['limit'] = 25;
					$dataSet[$indicator]['goal'] = 'Goal 25% by 2021';
					$dataSet[$indicator]['direction'] = -1;
					$dataSet[$indicator]['goal_text'] = "Reduce stunting in children under-5 years from 36.1% (BDHS 2014) to 25 % by 2021";
				}
				else if($indicators[$indicator] == 'BdhsWasting') {
					$dataSet[$indicator]['goal'] = 'Goal < 10% by 2021';
					$dataSet[$indicator]['limit'] = 10;
					$dataSet[$indicator]['direction'] = -1;
					$dataSet[$indicator]['goal_text'] = "Reduce wasting in children under-5 years";
				}
				else {
					$dataSet[$indicator]['goal'] = 'Goal 65% by 2021';
					$dataSet[$indicator]['direction'] = 1;
					$dataSet[$indicator]['limit'] = 65;
					$dataSet[$indicator]['goal_text'] = "Increase prevalence of exclusive breastfeeding";
				}
		}
		
		$trend_analysis = $dataSet;

		return view('frontend.impact.index', compact('trend_analysis', 'organisation_units', 'periods', 'indicators'));
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
