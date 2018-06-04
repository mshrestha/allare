<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Data\ANC1;
use App\Models\Data\ANC2;
use App\Models\Data\ANC3;
use App\Models\Data\ANC4;
use App\Models\Data\CcMrAncIfaDistribution;
use App\Models\Data\CcMrAncNutriCounsel;
use App\Models\Data\CcMrTotalPatient;
use App\Models\Data\ImciCounselling;
use App\Models\Data\ImciFemale;
use App\Models\Data\ImciMale;
use App\Models\Data\ImciTotalChild;
use App\Models\Data\PNC1;
use App\Models\Data\PNC2;
use App\Models\Data\PNC3;
use App\Models\Data\PNC4;
use App\Models\OrganisationUnit;
use App\Traits\PeriodHelper;
use Illuminate\Http\Request;

class OutcomeController extends Controller
{
	use PeriodHelper;

	public function test($var) { 
		$currentVal = date('Y').date('m', strtotime('-2 month'));
		return (int)$var < (int)$currentVal; 
	}

	public function indexAction() {
		$organisation_units = OrganisationUnit::whereIn('level', [1, 2])->get();
		$periods = $this->getPeriodYears();
		// $currentVal = date('Y').date('m', strtotime('-2 month'));
		$periodData = $this->yearly_months(2018);
		// array_push($periodData, '201712');
		// $emptyPeriod = [];
		// for ($i=0; $i < count($periodData); $i++) { 
		// 	if((int)$periodData[$i] < (int)$currentVal)
		// 		array_push($emptyPeriod, $periodData[$i]);
		// }
		// $periodData = $emptyPeriod
		// sort($emptyPeriod);
		// $periodData = $emptyPeriod;
		// dd($periodData);
		$data = config('data.maternal');
		$indicators = [
			'maternal_counselling' => 'Maternal Nutrition Counselling',
			'plw_who_receive_ifas' => 'IFA Distribution',
			'pregnant_women_weighed' => 'Maternal weight',
			'exclusive_breastfeeding' => 'Measurement',
		];

		$total_patient_last_month = CcMrTotalPatient::orderBy('period', 'desc')->where('organisation_unit', 'dNLjKwsVjod')->first();
		$organisation_unit = ['dNLjKwsVjod', 'dNLjKwsVjod'];
		$current_period = 2018;
		
		//Maternal counselling percentage
		$counselling_data = $data['maternal_counselling'][0];
		$counselling_model = 'App\Models\Data\\' . $counselling_data['model'];
		$counselling_percent = $this->calculate_Maternal_nutrition_counseling_pergentage($organisation_unit, $current_period);
		$counselling_all_periods = $counselling_model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->orderBy('period', 'asc')->pluck('period');
		$counselling_all_values = $counselling_model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->orderBy('period', 'asc')->pluck('value');
		$counselling_month_maternal = $current_period;

		//Plw who receive ifas
		$plw_who_receive_ifas_data = $data['plw_who_receive_ifas'][0];
		$plw_who_receive_ifas_model = 'App\Models\Data\\' . $plw_who_receive_ifas_data['model'];
		$plw_who_receive_ifas_percent = $this->calculate_IFA_distribution_percentage($organisation_unit, $current_period);
		$plw_who_receive_ifas_all_periods = $plw_who_receive_ifas_model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->where('source', 'DGHS')->orderBy('period', 'asc')
		->pluck('period');
		$plw_who_receive_ifas_all_values = $plw_who_receive_ifas_model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->where('source', 'DGHS')->orderBy('period', 'asc')->pluck('value');
		$plw_who_receive_ifas_month = $current_period;
		

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
		$exclusive_breastfeeding_last_month = $exclusive_breastfeeding_model::where('period', $total_patient_last_month->period)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->where('source', 'DGHS')->orderBy('period', 'desc')->first();
		$exclusive_breastfeeding_yearly = $exclusive_breastfeeding_model::where('period', date('Y'))->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->where('source', 'DGHS')->orderBy('period', 'desc')->first();
		$exclusive_breastfeeding_percent = ($exclusive_breastfeeding_last_month->value/$exclusive_breastfeeding_yearly->value) * 100;
		$exclusive_breastfeeding_all_periods = $exclusive_breastfeeding_model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->where('source', 'DGHS')->orderBy('period', 'asc')->pluck('period');
		$exclusive_breastfeeding_all_values = $exclusive_breastfeeding_model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->where('source', 'DGHS')->orderBy('period', 'asc')->pluck('value');
		$exclusive_breastfeeding_month = $exclusive_breastfeeding_last_month->period_name;
		
		$trend_analysis = [
			[
				'heading' => 'Maternal Nutrition Counselling',
				'name' => 'Pregnant women counselled on maternal nutrition',
				'model' => 'counselling',
				'percent' => round($counselling_percent),
				'periods' => $counselling_all_periods,
				'values' => $counselling_all_values,
				'current_month' => $counselling_month_maternal
			],
			[
				'heading' => 'IFA Distribution',
				'name' => 'Pregnant women who received IFA tablets',
				'model' => 'ifa_distribution',
				'percent' => round($plw_who_receive_ifas_percent),
				'periods' => $plw_who_receive_ifas_all_periods,
				'values' => $plw_who_receive_ifas_all_values,
				'current_month' => $plw_who_receive_ifas_month
			],
			[
				'heading' => 'Maternal Weight',
				'name' => 'Pregnant women weighed in a facility visit',
				'model' => 'weight_measurement',
				'percent' => round($pregnant_women_weighed_percent),
				'periods' => $pregnant_women_weighed_all_periods,
				'values' => $pregnant_women_weighed_all_values,
				'current_month' => $pregnant_women_weighed_month
			],
			[
				'heading' => 'Measurement',
				'name' => 'Exclusive breastfeeding',
				'model' => 'exclusive_breastfeeding',
				'percent' => round($exclusive_breastfeeding_percent),
				'periods' => $exclusive_breastfeeding_all_periods,
				'values' => $exclusive_breastfeeding_all_values,
				'current_month' => $exclusive_breastfeeding_month
			],
		];
		
		// dd($trend_analysis);
		return view('frontend.outcome.maternal', 
			compact('trend_analysis','organisation_units','periods','indicators')
		);
	}

	public function calculate_Maternal_nutrition_counseling_pergentage($organisation_unit, $period) {
		//Dhis formula
		// Numerator: kazi->comm->cc_MR_ANC_Nutri_counsel
		// Denominator : Kazi->comm-> cc_MR_ANC_1+2+3+4
		
		$cc_mr_anc_nutri_counsel = CcMrAncNutriCounsel::where('source', 'DGHS')
					->where('organisation_unit', $organisation_unit[0])
					->where('period', $period)
					->whereNull('category_option_combo')
					->first();
		$anc1_dghs = ANC1::where('source', 'DGHS')
					->where('organisation_unit', $organisation_unit[0])
					->where('period', $period)
					->whereNull('category_option_combo')
					->first();
		$anc2_dghs = ANC2::where('source', 'DGHS')
					->where('organisation_unit', $organisation_unit[0])
					->where('period', $period)
					->whereNull('category_option_combo')
					->first();
		$anc3_dghs = ANC3::where('source', 'DGHS')
					->where('organisation_unit', $organisation_unit[0])
					->where('period', $period)
					->whereNull('category_option_combo')
					->first();
		$anc4_dghs = ANC4::where('source', 'DGHS')
					->where('organisation_unit', $organisation_unit[0])
					->where('period', $period)
					->whereNull('category_option_combo')
					->first();
		$dhis_calculate = ($cc_mr_anc_nutri_counsel->value / ($anc1_dghs->value + $anc2_dghs->value + $anc3_dghs->value + $anc4_dghs->value)) * 100;

		return $dhis_calculate;
	}

	public function calculate_IFA_distribution_percentage($organisation_unit, $period) {
		//DHIS calculation
		//Numerator -> Kazi-Comm->cc_MR_ANC_IFA_Distribution
		//Denominator -> Kazi->comm-> cc_MR_ANC_1+2+3+4 
		
		$cc_mr_anc_ifa_distribution = CcMrAncIfaDistribution::where('organisation_unit', $organisation_unit[0])
						->whereNull('category_option_combo')
						->where('source', 'DGHS')
						->where('period', $period)->first();
		
		$anc1_dghs = ANC1::where('source', 'DGHS')
					->where('organisation_unit', $organisation_unit[0])
					->where('period', $period)
					->whereNull('category_option_combo')
					->first();
		$anc2_dghs = ANC2::where('source', 'DGHS')
					->where('organisation_unit', $organisation_unit[0])
					->where('period', $period)
					->whereNull('category_option_combo')
					->first();
		$anc3_dghs = ANC3::where('source', 'DGHS')
					->where('organisation_unit', $organisation_unit[0])
					->where('period', $period)
					->whereNull('category_option_combo')
					->first();
		$anc4_dghs = ANC4::where('source', 'DGHS')
					->where('organisation_unit', $organisation_unit[0])
					->where('period', $period)
					->whereNull('category_option_combo')
					->first();

		$dhis_numerator = $cc_mr_anc_ifa_distribution->value;
		$dhis_denominator = $anc1_dghs->value + $anc2_dghs->value + $anc3_dghs->value + $anc4_dghs->value;


		//DGFP calculation
		//Numerator -> Number of Pregnant Woman received IFA 
		//Denominator -> ANC1 + ANC2 + ANC3 + ANC4
		$number_of_pregnant_woman_received_ifa = CcMrAncIfaDistribution::where('source', 'DGFP')
					->where('organisation_unit', $organisation_unit[1])
					->where('period', 'LIKE', '%' . $period . '%')
					->whereNull('category_option_combo')
					->sum('value');
		$anc1_dgfp = ANC1::where('source', 'DGFP')
					->where('organisation_unit', $organisation_unit[1])
					->where('period', 'LIKE', '%' . $period . '%')
					->whereNull('category_option_combo')
					->sum('value');
		$anc2_dgfp = ANC2::where('source', 'DGFP')
					->where('organisation_unit', $organisation_unit[1])
					->where('period', 'LIKE', '%' . $period . '%')
					->whereNull('category_option_combo')
					->sum('value');
		$anc3_dgfp = ANC3::where('source', 'DGFP')
					->where('organisation_unit', $organisation_unit[1])
					->where('period', 'LIKE', '%' . $period . '%')
					->whereNull('category_option_combo')
					->sum('value');
		$anc4_dgfp = ANC4::where('source', 'DGFP')
					->where('organisation_unit', $organisation_unit[1])
					->where('period', 'LIKE', '%' . $period . '%')
					->whereNull('category_option_combo')
					->sum('value');

		$dgfp_numerator = $number_of_pregnant_woman_received_ifa;
		$dgfp_denominator = $anc1_dgfp + $anc2_dgfp + $anc3_dgfp + $anc4_dgfp;

		$ifa_distribution_percent = (($dhis_numerator + $dgfp_numerator) / ($dhis_denominator + $dgfp_denominator)) * 100;

		return $ifa_distribution_percent;
	}
	
	public function loadPeriodWiseMaternalData(Request $request) {
		if($request->period == 'LAST_MONTH') {
			$pe = date('Ym') - 1;
			$periodData = [(String)$pe];
		} else if($request->period == 'LAST_6_MONTHS') {
			$current_year = date('Y');
			$current_month = date('m');
			if($current_month - 1 < 10) {
				$current_month = '0'.($current_month-1);
			}else {
				$current_month = ($current_month-1);
			}
			$periodData = [];
			for ($i = 1; $i < 7; $i++) {
				$pe = date('Ym', strtotime("-$i month"));
				array_push($periodData, $pe);
			}
			$current_period = $periodData;
		} else {
			$periodData = $this->yearly_months($request->period);
			$current_period = $request->period;
		}

		// dd($periodData);
		
		$data = config('data.maternal');
		$indicators = [
			'maternal_counselling' => 'Maternal Counselling',
			'plw_who_receive_ifas' => 'Plw who receive ifas',
			'pregnant_women_weighed' => 'Pregnant women weighed',
			'exclusive_breastfeeding' => 'Exclusive breastfeeding',
		];

		$total_patient_last_month = CcMrTotalPatient::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->orderBy('period', 'desc')->first();

		$organisation_unit = ['dNLjKwsVjod', 'dNLjKwsVjod'];
		
		
		//Maternal counselling percentage
		$counselling_data = $data['maternal_counselling'][0];
		$counselling_model = 'App\Models\Data\\' . $counselling_data['model'];
		$counselling_percent = $this->calculate_Maternal_nutrition_counseling_pergentage($organisation_unit, $current_period);
		$counselling_all_periods = $counselling_model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->orderBy('period', 'asc')->pluck('period');
		$counselling_all_values = $counselling_model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->orderBy('period', 'asc')->pluck('value');
		$counselling_month_maternal = $current_period;
		// dd($counselling_all_values);
		//Plw who receive ifas
		$plw_who_receive_ifas_data = $data['plw_who_receive_ifas'][0];
		$plw_who_receive_ifas_model = 'App\Models\Data\\' . $plw_who_receive_ifas_data['model'];
		$plw_who_receive_ifas_percent = $this->calculate_IFA_distribution_percentage($organisation_unit, $current_period);
		$plw_who_receive_ifas_all_periods = $plw_who_receive_ifas_model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->where('source', 'DGHS')->orderBy('period', 'asc')->pluck('period');
		$plw_who_receive_ifas_all_values = $plw_who_receive_ifas_model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->where('source', 'DGHS')->orderBy('period', 'asc')->pluck('value');
		$plw_who_receive_ifas_month = $current_period;
		

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
		$exclusive_breastfeeding_last_month = $exclusive_breastfeeding_model::where('period', $total_patient_last_month->period)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->where('source', 'DGHS')->orderBy('period', 'desc')->first();
		$exclusive_breastfeeding_yearly = $exclusive_breastfeeding_model::where('period', date('Y'))->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->where('source', 'DGHS')->orderBy('period', 'desc')->first();
		$exclusive_breastfeeding_percent = ($exclusive_breastfeeding_last_month->value/$exclusive_breastfeeding_yearly->value) * 100;
		$exclusive_breastfeeding_all_periods = $exclusive_breastfeeding_model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->where('source', 'DGHS')->orderBy('period', 'asc')->pluck('period');
		$exclusive_breastfeeding_all_values = $exclusive_breastfeeding_model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->where('source', 'DGHS')->orderBy('period', 'asc')->pluck('value');
		$exclusive_breastfeeding_month = $exclusive_breastfeeding_last_month->period_name;
		
		if($request->model == 'counselling') {
			return [
				'key' => 0,
				'name' => 'Counselling',
				'model' => 'counselling',
				'percent' => round($counselling_percent),
				'periods' => $counselling_all_periods,
				'values' => $counselling_all_values,
				'current_month' => $counselling_month_maternal
			];
		} else if ($request->model == 'ifa_distribution') {
			return [
				'key' => 1,
				'name' => 'IFA Distribution',
				'model' => 'ifa_distribution',
				'percent' => round($plw_who_receive_ifas_percent),
				'periods' => $plw_who_receive_ifas_all_periods,
				'values' => $plw_who_receive_ifas_all_values,
				'current_month' => $plw_who_receive_ifas_month
			];
		} else if ($request->model == 'weight_measurement') {
			return [
				'key' => 2,
				'name' => 'Weight Measurement',
				'model' => 'weight_measurement',
				'percent' => round($pregnant_women_weighed_percent),
				'periods' => $pregnant_women_weighed_all_periods,
				'values' => $pregnant_women_weighed_all_values,
				'current_month' => $pregnant_women_weighed_month
			];
		} else if ($request->model == 'exclusive_breastfeeding') {
			return [
				'key' => 3,
				'name' => 'Exclusive breastfeeding',
				'model' => 'exclusive_breastfeeding',
				'percent' => round($exclusive_breastfeeding_percent),
				'periods' => $exclusive_breastfeeding_all_periods,
				'values' => $exclusive_breastfeeding_all_values,
				'current_month' => $exclusive_breastfeeding_month
			];
		}
	}
	
	public function indexChild() {
		$organisation_units = OrganisationUnit::whereIn('level', [1, 2])->get();
		$periods = $this->getPeriodYears();
		$periodData = $this->yearly_months(2018);
		$organisation_unit = ['dNLjKwsVjod', 'dNLjKwsVjod'];
		$current_period = 2018;
		$data = config('data.child');

		$indicators = [
			'iycf_counselling' => 'IYCF Counselling',
			'vitamin_a_supplementation' => 'Vitamin A supplementation',
		];

		// IMCI total children
		$counselling_data = $this->calculateMonthlyPercentage($data['iycf_counselling'][0], $periodData);
		$counselling_percent = floor($this->calculate_IYCF_counselling_percentage($organisation_unit, $current_period));
		$counselling_all_values = $counselling_data['all_values'];
		$counselling_all_periods = $counselling_data['all_periods'];
		$counselling_month_child = $counselling_data['month'];
		// dd($counselling_all_periods);
		
		// Vitamin A supplimentation
		$vitamin_a_supplimentation_data = $this->calculateMonthlyPercentage($data['vitamin_a_supplementation'][0], $periodData);
		$vitamin_a_supplementation_percent = $vitamin_a_supplimentation_data['percent'];
		$vitamin_a_supplementation_all_values = $vitamin_a_supplimentation_data['all_values'];
		$vitamin_a_supplementation_all_periods = $vitamin_a_supplimentation_data['all_periods'];
		$vitamin_a_supplementation_month = $vitamin_a_supplimentation_data['month'];

		$trend_analysis = [
			[
				'heading' => '',
				'name' => 'Caregivers of 0-23 month olds counselled on IYCF',
				'model' => 'iycf_counselling',
				'percent' => round($counselling_percent),
				'periods' => $counselling_all_periods,
				'values' => $counselling_all_values,
				'current_month' => $counselling_month_child
			],
			[
				'heading' => '',
				'name' => 'Children 0-23 months old weighed in a facility',
				'model' => 'supplements',
				'percent' => round($vitamin_a_supplementation_percent),
				'periods' => $vitamin_a_supplementation_all_periods,
				'values' => $vitamin_a_supplementation_all_values,
				'current_month' => $vitamin_a_supplementation_month
			],
		];

		return view('frontend.outcome.child', 
			compact('trend_analysis','organisation_units','periods','indicators')
		);
	}

	public function loadPeriodWiseChildData(Request $request) {
		$periodData = $this->yearly_months($request->period);
		$organisation_unit = ['dNLjKwsVjod', 'dNLjKwsVjod'];
		$current_period = $request->period;

		$data = config('data.child');
		$indicators = [
			'iycf_counselling' => 'IYCF Counselling',
			'vitamin_a_supplementation' => 'Vitamin A supplementation',
		];

		// IMCI total children
		$counselling_data = $this->calculateMonthlyPercentage($data['iycf_counselling'][0], $periodData);
		$counselling_percent = $this->calculate_IYCF_counselling_percentage($organisation_unit, $current_period);
		$counselling_all_values = $counselling_data['all_values'];
		$counselling_all_periods = $counselling_data['all_periods'];
		$counselling_month_child = $counselling_data['month'];

		// Vitamin A supplimentation
		$vitamin_a_supplimentation_data = $this->calculateMonthlyPercentage($data['vitamin_a_supplementation'][0], $periodData);
		$vitamin_a_supplementation_percent = $vitamin_a_supplimentation_data['percent'];
		$vitamin_a_supplementation_all_values = $vitamin_a_supplimentation_data['all_values'];
		$vitamin_a_supplementation_all_periods = $vitamin_a_supplimentation_data['all_periods'];
		$vitamin_a_supplementation_month = $vitamin_a_supplimentation_data['month'];

		if($request->model == 'iycf_counselling') {
			return [
				'key' => 0,
				'name' => 'IYCF Counselling',
				'model' => 'iycf_counselling',
				'percent' => round($counselling_percent),
				'periods' => $counselling_all_periods,
				'values' => $counselling_all_values,
				'current_month' => $counselling_month_child
			];
		} else if ($request->model == 'supplements') {	
			return [
				'key' => 1,
				'name' => 'Supplements',
				'model' => 'supplements',
				'percent' => round($vitamin_a_supplementation_percent),
				'periods' => $vitamin_a_supplementation_all_periods,
				'values' => $vitamin_a_supplementation_all_values,
				'current_month' => $vitamin_a_supplementation_month
			];
		}
	}
	
	public function calculate_IYCF_counselling_percentage($organisation_unit, $period) {
		//DHIS iycf counselling calculation
		//Numerator : Kazi-Central -> IMCI Counseling
		//Denominator : Kazi-Central->IMCI Male + IMCI Female
		
		$imci_male = ImciMale::where('organisation_unit', $organisation_unit[1])
						->whereNull('category_option_combo')
						->where('source', 'DGHS')
						->where('period', $period)->first();
		$imci_female = ImciFemale::where('organisation_unit', $organisation_unit[1])
						->whereNull('category_option_combo')
						->where('source', 'DGHS')
						->where('period', $period)->first();
		$imci_counselling = ImciCounselling::where('organisation_unit', $organisation_unit[1])
						->whereNull('category_option_combo')
						->where('source', 'DGHS')
						->where('period', $period)->first();

		$dhis_numerator = $imci_counselling->value;
		$dhis_denominator = $imci_male->value + $imci_female->value;

		//DGFP IYCF counselling calculation
		//Numerator -> Counseling on IYCF, IFA,Vitamin-A & Hand washing
		//Denominator -> ANC1+ANC2+ANC3+ANC4 + PNC 1+ PNC 2+ PNC 3 + PNC4
		
		$iycf_counselling = ImciCounselling::where('source', 'DGFP')
					->where('organisation_unit', $organisation_unit[1])
					->where('period', 'LIKE', '%' . $period . '%')
					->whereNull('category_option_combo')
					->sum('value');
		$anc1 = ANC1::where('source', 'DGFP')
					->where('organisation_unit', $organisation_unit[1])
					->where('period', 'LIKE', '%' . $period . '%')
					->whereNull('category_option_combo')
					->sum('value');
		$anc2 = ANC2::where('source', 'DGFP')
					->where('organisation_unit', $organisation_unit[1])
					->where('period', 'LIKE', '%' . $period . '%')
					->whereNull('category_option_combo')
					->sum('value');
		$anc3 = ANC3::where('source', 'DGFP')
					->where('organisation_unit', $organisation_unit[1])
					->where('period', 'LIKE', '%' . $period . '%')
					->whereNull('category_option_combo')
					->sum('value');
		$anc4 = ANC4::where('source', 'DGFP')
					->where('organisation_unit', $organisation_unit[1])
					->where('period', 'LIKE', '%' . $period . '%')
					->whereNull('category_option_combo')
					->sum('value');
		$pnc1 = PNC1::where('source', 'DGFP')
					->where('organisation_unit', $organisation_unit[1])
					->where('period', 'LIKE', '%' . $period . '%')
					->whereNull('category_option_combo')
					->sum('value');
		$pnc2 = PNC2::where('source', 'DGFP')
					->where('organisation_unit', $organisation_unit[1])
					->where('period', 'LIKE', '%' . $period . '%')
					->whereNull('category_option_combo')
					->sum('value');
		$pnc3 = PNC3::where('source', 'DGFP')
					->where('organisation_unit', $organisation_unit[1])
					->where('period', 'LIKE', '%' . $period . '%')
					->whereNull('category_option_combo')
					->sum('value');
		$pnc4 = PNC4::where('source', 'DGFP')
					->where('organisation_unit', $organisation_unit[1])
					->where('period', 'LIKE', '%' . $period . '%')
					->whereNull('category_option_combo')
					->sum('value');

		$dgfp_numerator = $iycf_counselling;
		$dgfp_denominator = $anc1+$anc2+$anc3+$anc4+$pnc1+$pnc2+$pnc3+$pnc4;

		$iycf_counselling_percent = (($dhis_numerator + $dgfp_numerator) / ($dhis_denominator + $dgfp_denominator)) * 100;

		return $iycf_counselling_percent;
	}

	public function calculateMonthlyPercentage($data, $periodData) {
		$model = 'App\Models\Data\\' . $data['model'];
		$last_month = $model::where('organisation_unit', 'dNLjKwsVjod')->whereIn('period', $periodData)->orderBy('period', 'desc')->whereNull('category_option_combo')->where('source', 'DGHS')->first();
		$yearly = $model::where('organisation_unit', 'dNLjKwsVjod')->where('period', substr($periodData[0], 0, 4))->whereNull('category_option_combo')->where('source', 'DGHS')->orderBy('period', 'desc')->first();

		$percent = ($last_month->value/$yearly->value) * 100;

		$all_periods = $model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->where('source', 'DGHS')->orderBy('period', 'asc')->pluck('period');
		$all_values = $model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->where('source', 'DGHS')->orderBy('period', 'asc')->pluck('value');
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

			// dd($data);
			for ($i=0; $i < count($data[$loop_data_used]); $i++) { 

				if(!$this->existsInArray($data[$next_data_used], $data[$loop_data_used][$i]['period'])) {
					$newData = $data[$loop_data_used][$i];
					$newData['value'] = 0;
					array_push($data[$next_data_used], $newData);
				}
			}

			for ($i=0; $i < count($data[$next_data_used]); $i++) { 
				if(!$this->existsInArray($data[$loop_data_used], $data[$next_data_used][$i]['period'])) {
					$newData = $data[$next_data_used][$i];
					$newData['value'] = 0;
					array_push($data[$loop_data_used], $newData);
				}
			}

			$final_data['DGHS']= array_pluck($data['DGHS'], 'value');
			$final_data['DGFP'] = array_pluck($data['DGFP'], 'value');
			// dd($final_data);
			$labels = array_pluck($data['DGHS'], 'period_name');
			$title = $data_table[0]['name'];
			if(strcasecmp(strtolower($title), 'imci counselling') == 0)
				$title = 'IYCF Counselling';
			if(strcasecmp(strtolower($title), 'food supplimentation') == 0)
				$title = 'Vitamin A Supplementation';
			// dd($title);

			$response = [
				'labels' => $labels,
				'datasets' => [
					[
						'label' => ['DGHS'],
						'data' => $final_data['DGHS'],
						'backgroundColor' => '#81ddc6' 
					],
					[
						'label' => ['DGFP'],
						'data' => $final_data['DGFP'],
						'backgroundColor' => '#008091'
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
