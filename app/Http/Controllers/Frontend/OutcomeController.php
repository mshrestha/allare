<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Data\CcMrAncNutriCounsel;
use App\Models\Data\CcMrTotalPatient;
use App\Models\Data\ImciTotalChild;
use App\Models\OrganisationUnit;
use App\Traits\PeriodHelper;
use Illuminate\Http\Request;

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

		$data = config('data.maternal');
		$indicators = [
			'maternal_counselling' => 'Maternal Counselling',
			'plw_who_receive_ifas' => 'Plw who receive ifas',
			'pregnant_women_weighed' => 'Pregnant women weighed',
			'exclusive_breastfeeding' => 'Exclusive breastfeeding',
		];

		$total_patient_last_month = CcMrTotalPatient::orderBy('period', 'desc')->where('organisation_unit', 'dNLjKwsVjod')->first();

		//Maternal counselling percentage
		$counselling_data = $data['maternal_counselling'][0];
		$counselling_model = 'App\Models\Data\\' . $counselling_data['model'];
		$counselling_last_month = $counselling_model::where('organisation_unit', 'dNLjKwsVjod')->orderBy('period', 'desc')->first();
		$counselling_percent = ($counselling_last_month->value/$total_patient_last_month->value) * 100;
		$counselling_all_periods = $counselling_model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->orderBy('period', 'asc')->pluck('period');
		$counselling_all_values = $counselling_model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->orderBy('period', 'asc')->pluck('value');
		$counselling_month_maternal = $counselling_last_month->period_name;

		//Plw who receive ifas
		$plw_who_receive_ifas_data = $data['plw_who_receive_ifas'][0];
		$plw_who_receive_ifas_model = 'App\Models\Data\\' . $plw_who_receive_ifas_data['model'];
		$plw_who_receive_ifas_last_month = $plw_who_receive_ifas_model::where('organisation_unit', 'dNLjKwsVjod')->orderBy('period', 'desc')->first();
		$plw_who_receive_ifas_percent = ($plw_who_receive_ifas_last_month->value/$total_patient_last_month->value) * 100;
		$plw_who_receive_ifas_all_periods = $plw_who_receive_ifas_model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->orderBy('period', 'asc')->pluck('period');
		$plw_who_receive_ifas_all_values = $plw_who_receive_ifas_model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->orderBy('period', 'asc')->pluck('value');
		$plw_who_receive_ifas_month = $plw_who_receive_ifas_last_month->period_name;

		//Pregnant women weighed
		$pregnant_women_weighed_data = $data['pregnant_women_weighed'][0];
		$pregnant_women_weighed_model = 'App\Models\Data\\' . $pregnant_women_weighed_data['model'];
		$pregnant_women_weighed_last_month = $pregnant_women_weighed_model::where('period', $total_patient_last_month->period)->where('organisation_unit', 'dNLjKwsVjod')->orderBy('period', 'desc')->first();
		$pregnant_women_weighed_yearly = $pregnant_women_weighed_model::where('period', date('Y'))->where('organisation_unit', 'dNLjKwsVjod')->orderBy('period', 'desc')->first();
		$pregnant_women_weighed_percent = ($pregnant_women_weighed_last_month->value/$pregnant_women_weighed_yearly->value) * 100;
		$pregnant_women_weighed_all_periods = $pregnant_women_weighed_model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->orderBy('period', 'asc')->pluck('period');
		$pregnant_women_weighed_all_values = $pregnant_women_weighed_model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->orderBy('period', 'asc')->pluck('value');
		$pregnant_women_weighed_month = $pregnant_women_weighed_last_month->period_name;


		//Pregnant women weighed
		$exclusive_breastfeeding_data = $data['exclusive_breastfeeding'][0];
		$exclusive_breastfeeding_model = 'App\Models\Data\\' . $exclusive_breastfeeding_data['model'];
		$exclusive_breastfeeding_last_month = $exclusive_breastfeeding_model::where('period', $total_patient_last_month->period)->where('organisation_unit', 'dNLjKwsVjod')->orderBy('period', 'desc')->first();
		$exclusive_breastfeeding_yearly = $exclusive_breastfeeding_model::where('period', date('Y'))->where('organisation_unit', 'dNLjKwsVjod')->orderBy('period', 'desc')->first();
		$exclusive_breastfeeding_percent = ($exclusive_breastfeeding_last_month->value/$exclusive_breastfeeding_yearly->value) * 100;
		$exclusive_breastfeeding_all_periods = $exclusive_breastfeeding_model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->orderBy('period', 'asc')->pluck('period');
		$exclusive_breastfeeding_all_values = $exclusive_breastfeeding_model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->orderBy('period', 'asc')->pluck('value');
		$exclusive_breastfeeding_month = $exclusive_breastfeeding_last_month->period_name;

		$trend_analysis = [
			[
				'name' => 'Counseling',
				'month' => 'Maternal Counselling Given - '. $counselling_month_maternal,
				'percent' => round($counselling_percent),
				'periods' => $counselling_all_periods,
				'values' => $counselling_all_values,
				'title' => 'Counseling',
				'labels' => json_encode(['Maternal Counselling Given '.$counselling_month_maternal, 'Total patient in ' .$counselling_month_maternal]),
				'current_month' => $counselling_month_maternal
			],
			[
				'name' => 'IFA Distribution',
				'month' => 'PLW who receive IFA\'s - '. $plw_who_receive_ifas_month,
				'percent' => round($plw_who_receive_ifas_percent),
				'periods' => $plw_who_receive_ifas_all_periods,
				'values' => $plw_who_receive_ifas_all_values,
				'title' => 'IFA Distribution',
				'labels' => json_encode(['PLW who receive IFA\'s in '. $plw_who_receive_ifas_month, 'Total patient in '.$plw_who_receive_ifas_month]),
				'current_month' => $plw_who_receive_ifas_month
			],
			[
				'name' => 'Weight Measurement',
				'month' => 'Pregnant women weighed - ' . $pregnant_women_weighed_month,
				'percent' => round($pregnant_women_weighed_percent),
				'periods' => $pregnant_women_weighed_all_periods,
				'values' => $pregnant_women_weighed_all_values,
				'title' => 'Weight Measurement',
				'labels' => json_encode(['Pregnant women weighed in ' .$pregnant_women_weighed_month, 'Pregnant women weighed yearly']),
				'current_month' => $pregnant_women_weighed_month
			],
			[
				'name' => 'Exclusive breastfeeding',
				'month' => 'Exclusive breastfeeding - ' . $exclusive_breastfeeding_month,
				'percent' => round($exclusive_breastfeeding_percent),
				'periods' => $exclusive_breastfeeding_all_periods,
				'values' => $exclusive_breastfeeding_all_values,
				'title' => 'Exclusive breastfeeding',
				'labels' => json_encode(['Exclusive breastfeeding in ' .$exclusive_breastfeeding_month, 'Exclusive breastfeeding yearly']),
				'current_month' => $exclusive_breastfeeding_month
			],
		];

		return view('frontend.outcome.maternal', 
			compact('trend_analysis','organisation_units','periods','indicators')
		);
	}

	public function indexChild() {
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

		$data = config('data.child');
		$indicators = [
			'iycf_counselling' => 'IYCF Counselling',
			// 'child_growth_monitoring' => 'Child growth monitoring',
			'vitamin_a_supplementation' => 'Vitamin A supplimentation',
		];


		// IMCI total children
		$counselling_data = $this->calculateMonthlyPercentage($data['iycf_counselling'][0], $periodData);
		$counselling_percent = $counselling_data['percent'];
		$counselling_all_values = $counselling_data['all_values'];
		$counselling_all_periods = $counselling_data['all_periods'];
		$counselling_month_child = $counselling_data['month'];

		
		// Vitamin A supplimentation
		$vitamin_a_supplimentation_data = $this->calculateMonthlyPercentage($data['vitamin_a_supplementation'][0], $periodData);
		$vitamin_a_supplementation_percent = $vitamin_a_supplimentation_data['percent'];
		$vitamin_a_supplementation_all_values = $vitamin_a_supplimentation_data['all_values'];
		$vitamin_a_supplementation_all_periods = $vitamin_a_supplimentation_data['all_periods'];
		$vitamin_a_supplementation_month = $vitamin_a_supplimentation_data['month'];

		$trend_analysis = [
			[
				'name' => 'IMCI Counseling',
				'title' => 'IMCI Counselling',
				'month' => 'IYCF counselling - '. $counselling_month_child,
				'percent' => round($counselling_percent),
				'periods' => $counselling_all_periods,
				'values' => $counselling_all_values,
				'labels' => json_encode(['IMCI Counselling given '. $counselling_month_child, 'IMCI Counselling yearly']),
				'current_month' => $counselling_month_child
			],
			// [
			// 	'name' => 'Child Growth',
			// 	'month' => 'Child growth monitoring',
			// 	'percent' => round($plw_who_receive_ifas_percent),
			// 	'periods' => $plw_who_receive_ifas_all_periods,
			// 	'values' => $plw_who_receive_ifas_all_values
			// ],
			[
				'name' => 'Supplements',
				'title' => 'Food Supplimentation',
				'month' => 'Food Supplimentation - '. $vitamin_a_supplementation_month,
				'percent' => round($vitamin_a_supplementation_percent),
				'periods' => $vitamin_a_supplementation_all_periods,
				'values' => $vitamin_a_supplementation_all_values,
				'labels' => json_encode(['Food Supplimentation in '. $vitamin_a_supplementation_month, 'Food Supplimentation yearly']),
				'current_month' => $vitamin_a_supplementation_month
			],
		];

		return view('frontend.outcome.child', 
			compact('trend_analysis','organisation_units','periods','indicators')
		);
	}

	public function calculateMonthlyPercentage($data, $periodData) {
		$model = 'App\Models\Data\\' . $data['model'];
		$last_month = $model::where('organisation_unit', 'dNLjKwsVjod')->orderBy('period', 'desc')->whereNull('category_option_combo')->first();
		$yearly = $model::where('organisation_unit', 'dNLjKwsVjod')->where('period', date('Y'))->whereNull('category_option_combo')->orderBy('period', 'desc')->first();

		$percent = ($last_month->value/$yearly->value) * 100;

		$all_periods = $model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->orderBy('period', 'asc')->pluck('period');
		$all_values = $model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->orderBy('period', 'asc')->pluck('value');
		$month = $last_month->period_name;

		return compact('percent', 'all_periods', 'all_values', 'month');
	}

	public function maternalMainChart(Request $request) {
		$indicator = $request->indicator_id;
		$department = $request->department_id;
		if($request->department_id == 'both') {
			$department = ['DGHS', 'DGFP'];
		}

		if($request->output == 'maternal') {
			$data_table = config('data.maternal.'.$indicator);
		} else {
			$data_table = config('data.child.'.$indicator);
		}

		$periods = $this->getPeriodArray($request->period_id);

		$organisation_unit = explode('.', $request->organisation_unit_id);
		$source = $request->department_id;

		
		if($request->department_id == 'both') {
			$model = 'App\Models\Data\\' . $data_table[0]['model'];
			$ou = ($data_table[0]['server'] == 'central') ? $organisation_unit[0] : $organisation_unit[1];
			$query = $model::whereIn('period', $periods);
			$query->whereIn('source', $department);
			$query->where('organisation_unit', $ou);
			if($indicator !== 'pregnant_women_weighed') {	
				$query->whereNull('category_option_combo');
			}
			$data = $query->orderBy('period')->get()->groupBy('source');
			$labels = $data->pluck('period_name');
			$datasets = $data->pluck('value');
			$data = $data->toArray();

			if(!isset($data['DGHS'])) {
				$data['DGHS'] = [];
			}

			if(!isset($data['DGFP'])) {
				$data['DGFP'] = [];
			}

			$dghs_data = (isset($data['DGHS'])) ? count($data['DGHS']) : 0;
			$dgfp_data = (isset($data['DGFP'])) ? count($data['DGFP']) : 0;

			if($dghs_data > $dgfp_data) {
				$loop_data_used = 'DGHS';
				$next_data_used = 'DGFP';
			} else {
				$loop_data_used = 'DGFP';
				$next_data_used = 'DGHS';
			}

			for ($i=0; $i < count($data[$loop_data_used]); $i++) { 

				if(!$this->existsInArray($data[$next_data_used], $data[$loop_data_used][$i]['period'])) {
					array_push($data[$next_data_used], $data[$loop_data_used][$i]);
				}
			}

			for ($i=0; $i < count($data[$next_data_used]); $i++) { 
				if(!$this->existsInArray($data[$loop_data_used], $data[$next_data_used][$i]['period'])) {
					array_push($data[$loop_data_used], $data[$next_data_used][$i]);
				}
			}

			$final_data['DGHS']= array_pluck($data['DGHS'], 'value');
			$final_data['DGFP'] = array_pluck($data['DGFP'], 'value');
			$labels = array_pluck($data['DGHS'], 'period_name');
			$title = $data_table[0]['name'];

			$response = [
				'labels' => $labels,
				'datasets' => [
					[
						'label' => ['DGFP'],
						'data' => $final_data['DGFP'],
						'backgroundColor' => '#008091'
					],
					[
						'label' => ['DGHS'],
						'data' => $final_data['DGHS'],
						'backgroundColor' => '#81ddc6' 
					]
				]
			];

			return response()->json([
				'department' => 'both', 
				'title' => $title, 
				'dataSets' => $response
			]);
		} else {
			$model = 'App\Models\Data\\' . $data_table[0]['model'];
			$ou = ($data_table[0]['server'] == 'central') ? $organisation_unit[0] : $organisation_unit[1];
			$query = $model::whereIn('period', $periods);
			$query->where('source', $department);
			$query->where('organisation_unit', $ou);
			if($indicator !== 'pregnant_women_weighed') {	
				$query->whereNull('category_option_combo');
			}
			$data = $query->orderBy('period')->get();
			$labels = $data->pluck('period_name');
			$datasets = $data->pluck('value');

			$pointers = ($request->department_id == 'both') ? ['DGHS','DGFP'] : $request->department_id;
			$title = $data_table[0]['name'];
			$backgroundColor = ($request->department_id == 'DGHS') ? '#81ddc6' : '#008091';
			$response = [
				'labels' => $labels,
				'datasets' => [
					[
						'label' => $pointers,
						'data' => $datasets,
						'backgroundColor' => $backgroundColor
					]
				]
			];

			return response()->json([
				'department' => $request->department_id, 
				'title' => $title, 
				'dataSets' => $response
			]);
		}


	}

	private function existsInArray($arr, $val) {
		for ($i=0; $i < count($arr); $i++) { 
			if($arr[$i]['period'] == $val) {
				return true;
			}
		}
		return false;
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
