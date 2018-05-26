<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

// Models
use App\Models\Data\BdhsExclusiveBreastfeeding;
use App\Models\Data\BdhsStunting;
use App\Models\Data\BdhsWasting;
use App\Models\Data\CcCrExclusiveBreastFeeding;
use App\Models\Data\CcCrTotalFemale;
use App\Models\Data\CcCrTotalMale;
use App\Models\Data\CcMrTotalPatient;
use App\Models\Data\ImciMale;
use App\Models\Data\ImciFemale;
use App\Models\Data\ImciCounselling;
use App\Models\Data\ImciStuntingPercent;
use App\Models\Data\ImciTotalChild;
use App\Models\Data\ImciWastingPercent;
use App\Models\Data\GeoJson;
use App\Models\OrganisationUnit;
use App\Models\Data\ANC1;
use App\Models\Data\ANC2;
use App\Models\Data\ANC3;
use App\Models\Data\ANC4;
use App\Models\Data\PNC1;
use App\Models\Data\PNC2;
use App\Models\Data\PNC3;
use App\Models\Data\PNC4;

// Traits
use App\Traits\PeriodHelper;
use App\Traits\OrganisationHelper;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
	use PeriodHelper;
	use OrganisationHelper;

	public function indexAction() {
		$sidebarContents = [
			'Training' => 
			[
				'title' => 'Departments that have trained health workers on CCTN with P4P',
				'items' => [
					[
						'image' => 'training.svg',
						'percent' => "65%",
						'text' => 'Health workers trained'
					],
					[
						'image' => 'training-check.svg',
						'percent' => "65%",
						'text' => 'Health workers who succeeded'
					]
				]
			],
			'Quality Assessment' => 
			[
				'title' => 'Quality Control & Supportive Supervision',
				'items' => [
					[
						'image' => 'qa.svg',
						'percent' => "65%",
						'text' => 'Facilities receiving SS&M'
					],
					[
						'image' => 'qa-child.svg',
						'percent' => "65%",
						'text' => 'Facilities providing quality IYCF/Maternal counselling'
					],
					[
						'image' => 'qa-paper.svg',
						'percent' => "65%",
						'text' => 'Facilities providing quality Nut reporting'
					]
				]
			],
			'Supply Management' => 
			[
				'title' => 'Ensure adequate nutrition supplies to facilites',
				'items' => [
					[
						'image' => 'supplement.svg',
						'percent' => "65%",
						'text' => 'Facilities requiring IFA tablets'
					],
					[
						'image' => 'supplement-paper.svg',
						'percent' => "65%",
						'text' => 'Facilities requiring counselling materials'
					],
					[
						'image' => 'supplement-tape.svg',
						'percent' => "65%",
						'text' => 'Facilities requiring MUAC tapes'
					],
					[
						'image' => 'supplement-weight.svg',
						'percent' => "65%",
						'text' => 'Facilities requiring Scales / height board'
					],
					[
						'image' => 'supplement-bottle.svg',
						'percent' => "65%",
						'text' => 'Facilities requiring F-75 and F-100 therapeutic feeding'
					]
				]
			]
		];
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
			'Stunting' => 'BdhsStunting',
			'Wasting' => 'BdhsWasting',
			'Exclusive Breastfeeding' => 'BdhsExclusiveBreastfeeding',
			'Vitamin A Supplements' => 'BdhsVitaminA',
		];
		$ou = 'dNLjKwsVjod';

		$data = config('data.outcomes');
		$dataSet = [];

		foreach($indicators as $indicator => $indicatorName) {
			$counter = 0;
			$dataSet[$indicator] = [];
			
				$ou = 'dNLjKwsVjod';
				
				$goal_model = 'App\Models\Data\\'.$indicators[$indicator];
				$datum = $goal_model::orderBy('period', 'asc')->get();
				
				$datum_goal = $goal_model::orderBy('period', 'desc')->first();
				// dd($datum_goal);
				$dataSet[$indicator]['title'] = $indicator;
				$dataSet[$indicator]['periods'] = $datum->pluck('period');
				$dataSet[$indicator]['goal_period'] = $datum_goal->period;
				$dataSet[$indicator]['goal_values'] = $datum_goal->value;
				$dataSet[$indicator]['min'] = 0;//$goal_model::min('value');
				$dataSet[$indicator]['max'] = 100;//m$goal_model::max('value');
				$dataSet[$indicator]['values'] = $datum->pluck('value');	
				if($indicators[$indicator] == 'BdhsStunting') {
					$dataSet[$indicator]['limit'] = 100;
					$dataSet[$indicator]['target'] = 25;
					$dataSet[$indicator]['goal'] = 'Goal 25% by 2021';
					$dataSet[$indicator]['direction'] = -1;
					$dataSet[$indicator]['goal_text'] = "Reduce stunting in children under-5 years from 36.1% (BDHS 2014) to 25 % by 2021";
					$dataSet[$indicator]['min'] = 100;//$goal_model::min('value');
					$dataSet[$indicator]['max'] = 0;//m$goal_model::max('value');
				}
				else if($indicators[$indicator] == 'BdhsWasting') {
					$dataSet[$indicator]['goal'] = 'Goal < 10% by 2021';
					$dataSet[$indicator]['limit'] = 100;
					$dataSet[$indicator]['target'] = 10;
					$dataSet[$indicator]['direction'] = -1;
					$dataSet[$indicator]['goal_text'] = "Reduce wasting in children under-5 years";
					$dataSet[$indicator]['min'] = 100;//$goal_model::min('value');
					$dataSet[$indicator]['max'] = 0;//m$goal_model::max('value');
				}
				else if($indicators[$indicator] == 'BdhsVitaminA') {
					$dataSet[$indicator]['goal'] = 'Goal 100% by 2021';
					$dataSet[$indicator]['limit'] = 100;
					$dataSet[$indicator]['target'] = 1;
					$dataSet[$indicator]['direction'] = -1;
					$dataSet[$indicator]['goal_text'] = "Two-dose coverage for 2016: 99%";
					$dataSet[$indicator]['min'] = 100;//$goal_model::min('value');
					$dataSet[$indicator]['max'] = 0;//m$goal_model::max('value');
				}
				else {
					$dataSet[$indicator]['goal'] = 'Goal 65% by 2021';
					$dataSet[$indicator]['direction'] = 1;
					$dataSet[$indicator]['limit'] = 100;
					$dataSet[$indicator]['target'] = 35;
					$dataSet[$indicator]['goal_text'] = "Increase prevalence of exclusive breastfeeding";
				}
		}
		
		$outcomes = $dataSet;
		
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

		
		$data = config('data.child');
		
		// IMCI total children
		$counselling_data = $this->calculateMonthlyPercentage($data['iycf_counselling'][0], $periodData, 'dNLjKwsVjod');
		$counselling_percent = $counselling_data['percent'];
		$counselling_all_values = $counselling_data['all_values'];
		$counselling_all_periods = $counselling_data['all_periods'];
		$counselling_month_child = $counselling_data['month'];

		
		// Vitamin A supplimentation
		$vitamin_a_supplimentation_data = $this->calculateMonthlyPercentage($data['vitamin_a_supplementation'][0], $periodData, 'dNLjKwsVjod');
		$vitamin_a_supplementation_percent = $vitamin_a_supplimentation_data['percent'];
		$vitamin_a_supplementation_all_values = $vitamin_a_supplimentation_data['all_values'];
		$vitamin_a_supplementation_all_periods = $vitamin_a_supplimentation_data['all_periods'];
		$vitamin_a_supplementation_month = $vitamin_a_supplimentation_data['month'];

		$maternal_trend_analysis = [
			[
				'name' => 'Counselling',
				'month' => 'Maternal Counselling Given - '. $counselling_month_maternal,
				'percent' => round($counselling_percent),
				'periods' => $counselling_all_periods,
				'values' => $counselling_all_values,
				'title' => 'Counselling',
				'labels' => json_encode(['Maternal Counselling Given '.$counselling_month_maternal, 'Total patient ' .$counselling_month_maternal]),
			],
			[
				'name' => 'IFA Distribution',
				'month' => 'PLW who receive IFA\'s - '. $plw_who_receive_ifas_month,
				'percent' => round($plw_who_receive_ifas_percent),
				'periods' => $plw_who_receive_ifas_all_periods,
				'values' => $plw_who_receive_ifas_all_values,
				'title' => 'IFA Distribution',
				'labels' => json_encode(['PLW who receive IFA\'s in '. $plw_who_receive_ifas_month, 'Total patient '.$plw_who_receive_ifas_month]),
			],
			[
				'name' => 'Weight Measurement',
				'month' => 'Pregnant women weighed - ' . $pregnant_women_weighed_month,
				'percent' => round($pregnant_women_weighed_percent),
				'periods' => $pregnant_women_weighed_all_periods,
				'values' => $pregnant_women_weighed_all_values,
				'title' => 'Weight Measurement',
				'labels' => json_encode(['Pregnant women weighed in ' .$pregnant_women_weighed_month, 'Pregnant women weighed yearly']),
			],
		];

		// dd($maternal_trend_analysis);

		$child_trend_analysis = [
			[
				'name' => 'IMCI Counselling',
				'title' => 'IMCI Counselling',
				'month' => 'IYCF counselling - '. $counselling_month_child,
				'percent' => round($counselling_percent),
				'periods' => $counselling_all_periods,
				'values' => $counselling_all_values,
				'labels' => json_encode(['IMCI Counselling given '. $counselling_month_child, 'IMCI Counselling yearly']),
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
				'title' => 'Food Supplementation',
				'month' => 'Food Supplementation - '. $vitamin_a_supplementation_month,
				'percent' => round($vitamin_a_supplementation_percent),
				'periods' => $vitamin_a_supplementation_all_periods,
				'values' => $vitamin_a_supplementation_all_values,
				'labels' => json_encode(['Food Supplrmentation in '. $vitamin_a_supplementation_month, 'Food Supplementation yearly']),
			],
		];

		$outcomes['vitamin A supplement'] = [];
		$outcomes['vitamin A supplement']['title'] = 'Vitamin A Supplement';
		$outcomes['vitamin A supplement']['goal_values'] = $child_trend_analysis[1]['percent'];
		$outcomes['vitamin A supplement']['min'] = 0;
		$outcomes['vitamin A supplement']['max'] = 100;
		$outcomes['vitamin A supplement']['goal'] = 'Goal 100% by 2021';
		$outcomes['vitamin A supplement']['direction'] = 1;
		$outcomes['vitamin A supplement']['limit'] = 100;
		$outcomes['vitamin A supplement']['target'] = 0;
		$outcomes['vitamin A supplement']['goal_text'] = "Increase intake of Vitamin Supplements";

		return view('frontend.dashboard.index', compact('sidebarContents', 'outcomes', 'maternal_trend_analysis', 'child_trend_analysis', 'organisation_units', 'periods'));
	}

	public function ajaxCircularChart(Request $request) {

		$organisation_unit = explode('.', $request->organisation_unit);	
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
		$total_patient_last_month = CcMrTotalPatient::orderBy('period', 'desc')->where('organisation_unit', $organisation_unit[1])->where('period', $request->period)->first();

		//Maternal counselling percentage
		$counselling_data = $data['maternal_counselling'][0];
		$counselling_model = 'App\Models\Data\\' . $counselling_data['model'];
		$counselling_last_month = $counselling_model::where('organisation_unit', $organisation_unit[1])->orderBy('period', 'desc')->where('period', $request->period)->first();
		// dd($counselling_last_month);
		$counselling_percent = ($counselling_last_month->value/$total_patient_last_month->value) * 100;
		// $counselling_all_periods = $counselling_model::whereIn('period', $periodData)->where('organisation_unit', $organisation_unit[1])->whereNull('category_option_combo')->orderBy('period', 'asc')->pluck('period');
		// $counselling_all_values = $counselling_model::whereIn('period', $periodData)->where('organisation_unit', $organisation_unit[1])->whereNull('category_option_combo')->orderBy('period', 'asc')->pluck('value');
		$counselling_month_maternal = $counselling_last_month->period_name;

		//Plw who receive ifas
		$plw_who_receive_ifas_data = $data['plw_who_receive_ifas'][0];
		$plw_who_receive_ifas_model = 'App\Models\Data\\' . $plw_who_receive_ifas_data['model'];
		$plw_who_receive_ifas_last_month = $plw_who_receive_ifas_model::where('organisation_unit', $organisation_unit[1])->orderBy('period', 'desc')->where('period', $request->period)->first();
		$plw_who_receive_ifas_percent = ($plw_who_receive_ifas_last_month->value/$total_patient_last_month->value) * 100;
		// $plw_who_receive_ifas_all_periods = $plw_who_receive_ifas_model::whereIn('period', $periodData)->where('organisation_unit', $organisation_unit[1])->whereNull('category_option_combo')->orderBy('period', 'asc')->pluck('period');
		// $plw_who_receive_ifas_all_values = $plw_who_receive_ifas_model::whereIn('period', $periodData)->where('organisation_unit', $organisation_unit[1])->whereNull('category_option_combo')->orderBy('period', 'asc')->pluck('value');
		$plw_who_receive_ifas_month = $plw_who_receive_ifas_last_month->period_name;

		//Pregnant women weighed
		$pregnant_women_weighed_data = $data['pregnant_women_weighed'][0];
		$pregnant_women_weighed_model = 'App\Models\Data\\' . $pregnant_women_weighed_data['model'];
		$pregnant_women_weighed_last_month = $pregnant_women_weighed_model::where('period', $total_patient_last_month->period)->where('organisation_unit', $organisation_unit[1])->orderBy('period', 'desc')->first();
		$pregnant_women_weighed_yearly = $pregnant_women_weighed_model::where('period', date('Y'))->where('organisation_unit', $organisation_unit[1])->orderBy('period', 'desc')->first();
		$pregnant_women_weighed_percent = ($pregnant_women_weighed_last_month->value/$pregnant_women_weighed_yearly->value) * 100;
		// $pregnant_women_weighed_all_periods = $pregnant_women_weighed_model::whereIn('period', $periodData)->where('organisation_unit', $organisation_unit[1])->orderBy('period', 'asc')->pluck('period');
		// $pregnant_women_weighed_all_values = $pregnant_women_weighed_model::whereIn('period', $periodData)->where('organisation_unit', $organisation_unit[1])->orderBy('period', 'asc')->pluck('value');
		$pregnant_women_weighed_month = $pregnant_women_weighed_last_month->period_name;

		
		$data = config('data.child');
		
		// Denominator : Kazi-Central->IMCI Male + IMCI Female
		// Numerator : Kazi-Central -> IMCI Counseling


		// IMCI total children
		$imci_total_children_data = $this->calculateMonthlyPercentage($data['iycf_counselling'][0], $periodData, $organisation_unit[0]);
		$imci_total_children_percent = $imci_total_children_data['percent'];
		$imci_total_children_all_values = $imci_total_children_data['all_values'];
		$imci_total_children_all_periods = $imci_total_children_data['all_periods'];
		$imci_total_children_month_child = $imci_total_children_data['month'];

		
		// Vitamin A supplimentation
		$vitamin_a_supplimentation_data = $this->calculateMonthlyPercentage($data['vitamin_a_supplementation'][0], $periodData, $organisation_unit[1]);
		$vitamin_a_supplementation_percent = $vitamin_a_supplimentation_data['percent'];
		$vitamin_a_supplementation_all_values = $vitamin_a_supplimentation_data['all_values'];
		$vitamin_a_supplementation_all_periods = $vitamin_a_supplimentation_data['all_periods'];
		$vitamin_a_supplementation_month = $vitamin_a_supplimentation_data['month'];

		$maternal_trend_analysis = [
			[
				'name' => 'Counselling',
				'month' => 'Maternal Counselling Given - '. $counselling_month_maternal,
				'percent' => round($counselling_percent),
				// 'periods' => $counselling_all_periods,
				// 'values' => $counselling_all_values,
				'title' => 'Counselling',
				'labels' => json_encode(['Maternal Counselling Given '.$counselling_month_maternal, 'Total patient ' .$counselling_month_maternal]),
			],
			[
				'name' => 'IFA Distribution',
				'month' => 'PLW who receive IFA\'s - '. $plw_who_receive_ifas_month,
				'percent' => round($plw_who_receive_ifas_percent),
				// 'periods' => $plw_who_receive_ifas_all_periods,
				// 'values' => $plw_who_receive_ifas_all_values,
				'title' => 'IFA Distribution',
				'labels' => json_encode(['PLW who receive IFA\'s in '. $plw_who_receive_ifas_month, 'Total patient '.$plw_who_receive_ifas_month]),
			],
			[
				'name' => 'Weight Measurement',
				'month' => 'Pregnant women weighed - ' . $pregnant_women_weighed_month,
				'percent' => round($pregnant_women_weighed_percent),
				// 'periods' => $pregnant_women_weighed_all_periods,
				// 'values' => $pregnant_women_weighed_all_values,
				'title' => 'Weight Measurement',
				'labels' => json_encode(['Pregnant women weighed in ' .$pregnant_women_weighed_month, 'Pregnant women weighed yearly']),
			],
		];

		$child_trend_analysis = [
			[
				'name' => 'IMCI Counselling',
				'title' => 'IMCI Counselling',
				'month' => 'IYCF counselling - '. $imci_total_children_month_child,
				'percent' => round($imci_total_children_percent),
				// 'periods' => $counselling_all_periods,
				// 'values' => $counselling_all_values,
				'labels' => json_encode(['IMCI Counselling given '. $imci_total_children_month_child, 'IMCI Counselling yearly']),
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
				'title' => 'Food Supplementation',
				'month' => 'Food Supplementation - '. $vitamin_a_supplementation_month,
				'percent' => round($vitamin_a_supplementation_percent),
				// 'periods' => $vitamin_a_supplementation_all_periods,
				// 'values' => $vitamin_a_supplementation_all_values,
				'labels' => json_encode(['Food Supplrmentation in '. $vitamin_a_supplementation_month, 'Food Supplementation yearly']),
			],
		];

		// return $maternal_trend_analysis;

		return view('frontend.dashboard.index', compact('sidebarContents', 'outcomes', 'maternal_trend_analysis', 'child_trend_analysis'));
	}

	public function calculate_IYCF_counselling_percentage() {
		//DHIS iycf counselling calculation
		//Numerator : Kazi-Central -> IMCI Counseling
		//Denominator : Kazi-Central->IMCI Male + IMCI Female
		
		$imci_male = ImciMale::where('organisation_unit', 'dNLjKwsVjod')
						->whereNull('category_option_combo')
						->where('source', 'DGHS')
						->where('period', date('Y'))->first();
		$imci_female = ImciFemale::where('organisation_unit', 'dNLjKwsVjod')
						->whereNull('category_option_combo')
						->where('source', 'DGHS')
						->where('period', date('Y'))->first();
		$imci_counselling = ImciCounselling::where('organisation_unit', 'dNLjKwsVjod')
						->whereNull('category_option_combo')
						->where('source', 'DGHS')
						->where('period', date('Y'))->first();

		$dhis_calculate = $imci_counselling->value / ($imci_male->value + $imci_female->value);
		$dhis_iycf_counselling_percent = $dhis_calculate * 100;
		
		//DGFP IYCF counselling calculation
		//Numerator -> Counseling on IYCF, IFA,Vitamin-A & Hand washing
		//Denominator -> ANC1+ANC2+ANC3+ANC4 + PNC 1+ PNC 2+ PNC 3 + PNC4
		
		$iycf_counselling = ImciCounselling::where('source', 'DGFP')
					->where('organisation_unit', 'dNLjKwsVjod')
					->where('period', date('Y'))
					->whereNull('category_option_combo')
					->first();
		$anc1 = ANC1::where('source', 'DGFP')
					->where('organisation_unit', 'dNLjKwsVjod')
					->where('period', date('Y'))
					->whereNull('category_option_combo')
					->first();
		$anc2 = ANC2::where('source', 'DGFP')
					->where('organisation_unit', 'dNLjKwsVjod')
					->where('period', date('Y'))
					->whereNull('category_option_combo')
					->first();
		$anc3 = ANC3::where('source', 'DGFP')
					->where('organisation_unit', 'dNLjKwsVjod')
					->where('period', date('Y'))
					->whereNull('category_option_combo')
					->first();
		$anc4 = ANC4::where('source', 'DGFP')
					->where('organisation_unit', 'dNLjKwsVjod')
					->where('period', date('Y'))
					->whereNull('category_option_combo')
					->first();
		$pnc1 = PNC1::where('source', 'DGFP')
					->where('organisation_unit', 'dNLjKwsVjod')
					->where('period', date('Y'))
					->whereNull('category_option_combo')
					->first();
		$pnc2 = PNC2::where('source', 'DGFP')
					->where('organisation_unit', 'dNLjKwsVjod')
					->where('period', date('Y'))
					->whereNull('category_option_combo')
					->first();
		$pnc3 = PNC3::where('source', 'DGFP')
					->where('organisation_unit', 'dNLjKwsVjod')
					->where('period', date('Y'))
					->whereNull('category_option_combo')
					->first();
		$pnc4 = PNC4::where('source', 'DGFP')
					->where('organisation_unit', 'dNLjKwsVjod')
					->where('period', date('Y'))
					->whereNull('category_option_combo')
					->first();

		$dgfp_calculate = $iycf_counselling->value / ($anc1->value + $anc2->value + $anc3->value + $anc4->value + $pnc1->value + $pnc2->value + $pnc3->value + $pnc4->value);
		$dgfp_iycf_counselling_percent = $dgfp_calculate * 100;

		$iycf_counselling_percent = ($dhis_iycf_counselling_percent + $dgfp_iycf_counselling_percent) / 2;

		return $iycf_counselling_percent;
	}

	public function calculate_IFA_distribution_percentage() {
		// DHIS calculation
		//Numerator -> Kazi-Comm->cc_MR_ANC_IFA_Distribution
		//Denominator -> Kazi->comm-> cc_MR_ANC_1+2+3+4 
		
		$cc_mr_anc_ifa_distribution = CcMrAncIfaDistribution::where('organisation_unit', 'dNLjKwsVjod')
						->whereNull('category_option_combo')
						->where('source', 'DGHS')
						->where('period', date('Y'))->first();
		$anc1_dghs = ANC1::where('source', 'DGHS')
					->where('organisation_unit', 'dNLjKwsVjod')
					->where('period', date('Y'))
					->whereNull('category_option_combo')
					->first();
		$anc2_dghs = ANC2::where('source', 'DGHS')
					->where('organisation_unit', 'dNLjKwsVjod')
					->where('period', date('Y'))
					->whereNull('category_option_combo')
					->first();
		$anc3_dghs = ANC3::where('source', 'DGHS')
					->where('organisation_unit', 'dNLjKwsVjod')
					->where('period', date('Y'))
					->whereNull('category_option_combo')
					->first();
		$anc4_dghs = ANC4::where('source', 'DGHS')
					->where('organisation_unit', 'dNLjKwsVjod')
					->where('period', date('Y'))
					->whereNull('category_option_combo')
					->first();

		$dhis_calculate = $cc_mr_anc_ifa_distribution->value / ($anc1_dghs->value + $anc2_dghs->value + $anc3_dghs->value + $anc4_dghs->value);
		$dhis_ifa_distribution_percent = $dhis_calculate * 100;

		//DGFP calculation
		//Numerator -> Number of Pregnant Woman received IFA 
		//Denominator -> ANC1 + ANC2 + ANC3 + ANC4

		$number_of_pregnant_woman_received_ifa = CcMrAncIfaDistribution::where('source', 'DGFP')
					->where('organisation_unit', 'dNLjKwsVjod')
					->where('period', date('Y'))
					->whereNull('category_option_combo')
					->first();
		$anc1_dgfp = ANC1::where('source', 'DGFP')
					->where('organisation_unit', 'dNLjKwsVjod')
					->where('period', date('Y'))
					->whereNull('category_option_combo')
					->first();
		$anc2_dgfp = ANC2::where('source', 'DGFP')
					->where('organisation_unit', 'dNLjKwsVjod')
					->where('period', date('Y'))
					->whereNull('category_option_combo')
					->first();
		$anc3_dgfp = ANC3::where('source', 'DGFP')
					->where('organisation_unit', 'dNLjKwsVjod')
					->where('period', date('Y'))
					->whereNull('category_option_combo')
					->first();
		$anc4_dgfp = ANC4::where('source', 'DGFP')
					->where('organisation_unit', 'dNLjKwsVjod')
					->where('period', date('Y'))
					->whereNull('category_option_combo')
					->first();

		$dgfp_calculate = $number_of_pregnant_woman_received_ifa->value / $anc1_dgfp->value + $anc2_dgfp->value + $anc3_dgfp->value + $anc4_dgfp->value;

		$dgfp_ifa_distribution_percent = $dgfp_calculate * 100;

		$ifa_distribution_percent = ($dhis_ifa_distribution_percent + $dgfp_ifa_distribution_percent) / 2;

		return $ifa_distribution_percent;
	}

	public function calculate_Maternal_nutrition_counseling_pergentage() {
		//Dhis formula
		// Numerator: kazi->comm->cc_MR_ANC_Nutri_counsel
		// Denominator : Kazi->comm-> cc_MR_ANC_1+2+3+4
		
		$cc_mr_anc_nutri_counsel = CcMrAncNutriCounsel::where('organisation_unit', 'dNLjKwsVjod')
						->whereNull('category_option_combo')
						->where('source', 'DGHS')
						->where('period', date('Y'))->first();
		$anc1_dghs = ANC1::where('source', 'DGHS')
					->where('organisation_unit', 'dNLjKwsVjod')
					->where('period', date('Y'))
					->whereNull('category_option_combo')
					->first();
		$anc2_dghs = ANC2::where('source', 'DGHS')
					->where('organisation_unit', 'dNLjKwsVjod')
					->where('period', date('Y'))
					->whereNull('category_option_combo')
					->first();
		$anc3_dghs = ANC3::where('source', 'DGHS')
					->where('organisation_unit', 'dNLjKwsVjod')
					->where('period', date('Y'))
					->whereNull('category_option_combo')
					->first();
		$anc4_dghs = ANC4::where('source', 'DGHS')
					->where('organisation_unit', 'dNLjKwsVjod')
					->where('period', date('Y'))
					->whereNull('category_option_combo')
					->first();
		$dhis_calculate = ($cc_mr_anc_nutri_counsel->value / ($anc1_dghs->value + $anc2_dghs->value + $anc3_dghs->value + $anc4_dghs->value)) * 100;
		
		return $dhis_calculate;
	}

	public function calculateMonthlyPercentage($data, $periodData, $ou) {
		$model = 'App\Models\Data\\' . $data['model'];
		$last_month = $model::where('organisation_unit', $ou)->orderBy('period', 'desc')->whereNull('category_option_combo')->first();
		$yearly = $model::where('organisation_unit', $ou)->where('period', date('Y'))->whereNull('category_option_combo')->orderBy('period', 'desc')->first();

		$percent = ($last_month->value/$yearly->value) * 100;

		$all_periods = $model::whereIn('period', $periodData)->where('organisation_unit', $ou)->whereNull('category_option_combo')->orderBy('period', 'asc')->pluck('period');
		$all_values = $model::whereIn('period', $periodData)->where('organisation_unit', $ou)->whereNull('category_option_combo')->orderBy('period', 'asc')->pluck('value');
		$month = $last_month->period_name;

		return compact('percent', 'all_periods', 'all_values', 'month');
	}

	public function getGeoJsons() {
		$geoJsons = GeoJson::all();

		$organisations = $geoJsons->pluck('organisation_unit');
		$coordinates = $geoJsons->pluck('coordinates');
		// dd(count($coordinates));
		$organisationsArray = [];
		foreach ($organisations as $key => $value) {
			$orgName = OrganisationUnit::where('central_api_id', $value)->first();
			$organisationsArray[$orgName->name]['key'] = $orgName->central_api_id.'-'.$orgName->community_api_id;
			$organisationsArray[$orgName->name]['coordinates'] = json_decode($coordinates[$key]);
		}
		// dd($organisationsArray['Barisal Division']);
		return $organisationsArray;
	}

	public function getPercentTrend(Request $request) {
		$data = $request->ids;
		$ids = explode("-", $data);
		$ou = '';
		$periods = $this->getPeriodYears();
		$flipped_period = array_flip($periods);

		$periodData = '';
		foreach ($flipped_period as $key => $value) {
			$periodData .= $value.';';
		}
		
		$periodData = rtrim($periodData, ';');
		$periodData = explode(";", $periodData);
		sort($periodData);
		$returnArr['child'] = $this->getChildPercent($periodData, $ids[0], $ids[1]);
		$returnArr['maternal'] = $this->getMaternalPercent($periodData, $ids[0], $ids[1]);
		return $returnArr;
	}

	private function getChildPercent($periodData, $central_api_id, $community_api_id) {

		$data = config('data.child');
		
		// IMCI total children
		if($data['iycf_counselling'][0]['server'] == 'central') {
			$ou = $central_api_id;
		}else{
			$ou = $community_api_id;
		}
		$counselling_data = $this->calculateMonthlyPercentage($data['iycf_counselling'][0], $periodData, $ou);
		$counselling_percent = $counselling_data['percent'];
		$counselling_all_values = $counselling_data['all_values'];
		$counselling_all_periods = $counselling_data['all_periods'];
		$counselling_month_child = $counselling_data['month'];

		
		// Vitamin A supplimentation
		if($data['vitamin_a_supplementation'][0]['server'] == 'central') {
			$ou = $central_api_id;
		}else{
			$ou = $community_api_id;
		}
		$vitamin_a_supplimentation_data = $this->calculateMonthlyPercentage($data['vitamin_a_supplementation'][0], $periodData, $ou);
		$vitamin_a_supplementation_percent = $vitamin_a_supplimentation_data['percent'];
		$vitamin_a_supplementation_all_values = $vitamin_a_supplimentation_data['all_values'];
		$vitamin_a_supplementation_all_periods = $vitamin_a_supplimentation_data['all_periods'];
		$vitamin_a_supplementation_month = $vitamin_a_supplimentation_data['month'];

		$child_trend_analysis = [
			[
				'name' => 'IMCI Counselling',
				'title' => 'IMCI Counselling',
				'month' => 'IYCF counselling - '. $counselling_month_child,
				'percent' => round($counselling_percent),
				'periods' => $counselling_all_periods,
				'values' => $counselling_all_values,
				'labels' => (['IMCI Counselling given '. $counselling_month_child, 'IMCI Counselling yearly']),
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
				'title' => 'Food Supplementation',
				'month' => 'Food Supplementation - '. $vitamin_a_supplementation_month,
				'percent' => round($vitamin_a_supplementation_percent),
				'periods' => $vitamin_a_supplementation_all_periods,
				'values' => $vitamin_a_supplementation_all_values,
				'labels' => (['Food Supplementation in '. $vitamin_a_supplementation_month, 'Food Supplementation yearly']),
			],
		];
		return $child_trend_analysis;
	}

	private function getMaternalPercent($periodData, $central_api_id, $community_api_id) {


		$data = config('data.maternal');
		$total_patient_last_month = CcMrTotalPatient::orderBy('period', 'desc')->where('organisation_unit', 'dNLjKwsVjod')->first();

		//Maternal counselling percentage
		$counselling_data = $data['maternal_counselling'][0];
		if($counselling_data['server'] == 'central') {
			$ou = $central_api_id;
		} else {
			$ou = $community_api_id;
		}
		$counselling_model = 'App\Models\Data\\' . $counselling_data['model'];
		$counselling_last_month = $counselling_model::where('organisation_unit', $ou)->orderBy('period', 'desc')->first();
		$counselling_percent = ($counselling_last_month->value/$total_patient_last_month->value) * 100;
		$counselling_all_periods = $counselling_model::whereIn('period', $periodData)->where('organisation_unit', $ou)->whereNull('category_option_combo')->orderBy('period', 'asc')->pluck('period');
		$counselling_all_values = $counselling_model::whereIn('period', $periodData)->where('organisation_unit', $ou)->whereNull('category_option_combo')->orderBy('period', 'asc')->pluck('value');
		$counselling_month_maternal = $counselling_last_month->period_name;

		//Plw who receive ifas
		$plw_who_receive_ifas_data = $data['plw_who_receive_ifas'][0];
		if($plw_who_receive_ifas_data['server'] == 'central') {
			$ou = $central_api_id;
		} else {
			$ou = $community_api_id;
		}
		$plw_who_receive_ifas_model = 'App\Models\Data\\' . $plw_who_receive_ifas_data['model'];
		$plw_who_receive_ifas_last_month = $plw_who_receive_ifas_model::where('organisation_unit', $ou)->orderBy('period', 'desc')->first();
		
		$plw_who_receive_ifas_percent = ($plw_who_receive_ifas_last_month->value/$total_patient_last_month->value) * 100;
		$plw_who_receive_ifas_all_periods = $plw_who_receive_ifas_model::whereIn('period', $periodData)->where('organisation_unit', $ou)->whereNull('category_option_combo')->orderBy('period', 'asc')->pluck('period');
		$plw_who_receive_ifas_all_values = $plw_who_receive_ifas_model::whereIn('period', $periodData)->where('organisation_unit', $ou)->whereNull('category_option_combo')->orderBy('period', 'asc')->pluck('value');
		$plw_who_receive_ifas_month = $plw_who_receive_ifas_last_month->period_name;

		//Pregnant women weighed
		$pregnant_women_weighed_data = $data['pregnant_women_weighed'][0];
		if($pregnant_women_weighed_data['server'] == 'central') {
			$ou = $central_api_id;
		} else {
			$ou = $community_api_id;
		}
		$pregnant_women_weighed_model = 'App\Models\Data\\' . $pregnant_women_weighed_data['model'];
		$pregnant_women_weighed_last_month = $pregnant_women_weighed_model::where('period', $total_patient_last_month->period)->where('organisation_unit', $ou)->orderBy('period', 'desc')->first();
		$pregnant_women_weighed_yearly = $pregnant_women_weighed_model::where('period', date('Y'))->where('organisation_unit', $ou)->orderBy('period', 'desc')->first();
		$pregnant_women_weighed_percent = ($pregnant_women_weighed_last_month->value/$pregnant_women_weighed_yearly->value) * 100;
		$pregnant_women_weighed_all_periods = $pregnant_women_weighed_model::whereIn('period', $periodData)->where('organisation_unit', $ou)->orderBy('period', 'asc')->pluck('period');
		$pregnant_women_weighed_all_values = $pregnant_women_weighed_model::whereIn('period', $periodData)->where('organisation_unit', $ou)->orderBy('period', 'asc')->pluck('value');
		$pregnant_women_weighed_month = $pregnant_women_weighed_last_month->period_name;

		
		

		$maternal_trend_analysis = [
			[
				'name' => 'Counselling',
				'month' => 'Maternal Counselling Given - '. $counselling_month_maternal,
				'percent' => round($counselling_percent),
				'periods' => $counselling_all_periods,
				'values' => $counselling_all_values,
				'title' => 'Counselling',
				'labels' => (['Maternal Counselling Given '.$counselling_month_maternal, 'Total patient ' .$counselling_month_maternal]),
			],
			[
				'name' => 'IFA Distribution',
				'month' => 'PLW who receive IFA\'s - '. $plw_who_receive_ifas_month,
				'percent' => round($plw_who_receive_ifas_percent),
				'periods' => $plw_who_receive_ifas_all_periods,
				'values' => $plw_who_receive_ifas_all_values,
				'title' => 'IFA Distribution',
				'labels' => (['PLW who receive IFA\'s in '. $plw_who_receive_ifas_month, 'Total patient '.$plw_who_receive_ifas_month]),
			],
			[
				'name' => 'Weight Measurement',
				'month' => 'Pregnant women weighed - ' . $pregnant_women_weighed_month,
				'percent' => round($pregnant_women_weighed_percent),
				'periods' => $pregnant_women_weighed_all_periods,
				'values' => $pregnant_women_weighed_all_values,
				'title' => 'Weight Measurement',
				'labels' => (['Pregnant women weighed in ' .$pregnant_women_weighed_month, 'Pregnant women weighed yearly']),
			],
		];

		return $maternal_trend_analysis;
	}

	public function getMapData(Request $request) {
		$data = $request->all();
		$datamodel = config('datamodel');
		$model = 'App\Models\Data\\' . $data['model'];
		$server = 'central';
		for ($i=0; $i < count($datamodel); $i++) { 
			if($datamodel[$i]['model'] == $data['model'])
				$server = $datamodel[$i]['server'];
		}
		$pe = date('Y').date('m', strtotime('-1 month'));
		$pe = '201802';
		$organisations = $this->getOrganisations($server);
		// dd($organisations);
		$responseData = $model::whereIn('organisation_unit', $organisations['organisation_unit_array'])->where('period', $pe)->where('category_option_combo', NULL)->get();
		$dataArr = [];
		$valueArr = [];
		for ($i=0; $i < count($responseData); $i++) { 
			$dataArr[$responseData[$i]['organisation_unit']] = $responseData[$i]['value'];
			if($responseData[$i]['organisation_unit'] != 'dNLjKwsVjod')
				array_push($valueArr, $responseData[$i]['value']);
		}
		$ranges = $this->getThreeRanges($valueArr);

		$text = 'People reached: ';
		$reverse = false;
		if(strcasecmp($data['model'], 'ImciStunting') == 0){
			$text = 'Children suffering from Stunting: ';
			$reverse = true;
		} else if(strcasecmp($data['model'], 'ImciStunting') == 0){
			$text = 'Children suffering from Wasting: ';
			$reverse = true;
		} else if(strcasecmp($data['model'], 'CcCrExclusiveBreastFeeding') == 0){
			$text = 'Children breastfed: ';
			$reverse = true;
		}

		// dd($valueArr);
		if(count($valueArr) <= 0){
			return array(
				'dataExists' => false,
			);
		}else{
			return array(
				'dataExists' => true,
				'modelData' => $responseData,
				'minimalData' => $dataArr,
				'server' => $server,
				'min' => count($ranges)>0?$ranges['min']:0,
				'q1' => count($ranges)>0?$ranges['q1']:0,
				'q2' => count($ranges)>0?$ranges['q2']:0,
				'max' => count($ranges)>0?$ranges['max']:0,
				'text' => $text,
				'reverse' => $reverse
			);
		}
	}

	private function getThreeRanges($valueArray) {
		if(count($valueArray) > 0) {
			$min = min($valueArray);
			$max = max($valueArray);
			$step = ($max - $min) / 3;
			$q1 = $min + $step;
			$q2 = $max - $step;
			return array(
				'min' => $min,
				'max' => $max,
				'q1' => $q1,
				'q2' => $q2,
			);
		}else{
			return [];
		}
	}
}