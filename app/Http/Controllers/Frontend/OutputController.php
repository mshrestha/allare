<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Data\CcMrTotalPatient;
use App\Models\OrganisationUnit;
use App\Traits\PeriodHelper;
use Illuminate\Http\Request;

class OutputController extends Controller
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
		];

		$total_patient_last_month = CcMrTotalPatient::orderBy('period', 'desc')->where('organisation_unit', 'dNLjKwsVjod')->first();

		//Maternal counselling percentage
		$counselling_data = $data['maternal_counselling'][0];
		$counselling_model = 'App\Models\Data\\' . $counselling_data['model'];
		$counselling_last_month = $counselling_model::where('organisation_unit', 'dNLjKwsVjod')->orderBy('period', 'desc')->first();
		$counselling_percent = ($counselling_last_month->value/$total_patient_last_month->value) * 100;
		$counselling_all_periods = $counselling_model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->orderBy('period', 'asc')->pluck('period');
		$counselling_all_values = $counselling_model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->orderBy('period', 'asc')->pluck('value');

		//Plw who receive ifas
		$plw_who_receive_ifas_data = $data['plw_who_receive_ifas'][0];
		$plw_who_receive_ifas_model = 'App\Models\Data\\' . $plw_who_receive_ifas_data['model'];
		$plw_who_receive_ifas_last_month = $plw_who_receive_ifas_model::where('organisation_unit', 'dNLjKwsVjod')->orderBy('period', 'desc')->first();
		$plw_who_receive_ifas_percent = ($plw_who_receive_ifas_last_month->value/$total_patient_last_month->value) * 100;
		$plw_who_receive_ifas_all_periods = $plw_who_receive_ifas_model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->orderBy('period', 'asc')->pluck('period');
		$plw_who_receive_ifas_all_values = $plw_who_receive_ifas_model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->whereNull('category_option_combo')->orderBy('period', 'asc')->pluck('value');
		
		//Pregnant women weighed
		$pregnant_women_weighed_data = $data['pregnant_women_weighed'][0];
		$pregnant_women_weighed_model = 'App\Models\Data\\' . $pregnant_women_weighed_data['model'];
		$pregnant_women_weighed_last_month = $pregnant_women_weighed_model::where('period', $total_patient_last_month->period)->where('organisation_unit', 'dNLjKwsVjod')->orderBy('period', 'desc')->first();
		$pregnant_women_weighed_yearly = $pregnant_women_weighed_model::where('period', date('Y'))->where('organisation_unit', 'dNLjKwsVjod')->orderBy('period', 'desc')->first();
		$pregnant_women_weighed_percent = ($pregnant_women_weighed_last_month->value/$pregnant_women_weighed_yearly->value) * 100;
		$pregnant_women_weighed_all_periods = $pregnant_women_weighed_model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->orderBy('period', 'asc')->pluck('period');
		$pregnant_women_weighed_all_values = $pregnant_women_weighed_model::whereIn('period', $periodData)->where('organisation_unit', 'dNLjKwsVjod')->orderBy('period', 'asc')->pluck('value');

		$trend_analysis = [
			[
				'name' => 'Counseling',
				'month' => 'Counseling Given - April',
				'percent' => round($counselling_percent),
				'periods' => $counselling_all_periods,
				'values' => $counselling_all_values
			],
			[
				'name' => 'IFA Distribution',
				'month' => 'IFA Distributed - April',
				'percent' => round($plw_who_receive_ifas_percent),
				'periods' => $plw_who_receive_ifas_all_periods,
				'values' => $plw_who_receive_ifas_all_values
			],
			[
				'name' => 'Weight Measurement',
				'month' => 'Weight gained - April',
				'percent' => round($pregnant_women_weighed_percent),
				'periods' => $pregnant_women_weighed_all_periods,
				'values' => $pregnant_women_weighed_all_values
			],
		];

		return view('frontend.output.index', 
			compact('trend_analysis','organisation_units','periods','indicators')
		);
	}

	public function maternalMainChart(Request $request) {
		$indicator = $request->indicator_id;
		$data_table = config('data.maternal.'.$indicator);
		$periods = $this->getPeriodArray($request->period_id);

		$organisation_unit = explode('.', $request->organisation_unit_id);
		$source = $request->department_id;
		$source = "DGHS";
		
		$model = 'App\Models\Data\\' . $data_table[0]['model'];
		$ou = ($data_table[0]['server'] == 'central') ? $organisation_unit[0] : $organisation_unit[1];
		$data = $model::whereIn('period', $periods)->where('source', 'DGHS')->where('organisation_unit', $ou)->whereNull('category_option_combo')->orderBy('period')->get();
		
		$labels = $data->pluck('period_name');
		$datasets = $data->pluck('value');
		$pointers = (empty($request->department_id) || $request->department_id == 'both') ? ['DGHS','DGFP'] : $request->department_id;
		$title = $data_table[0]['name'];

		return response()->json(['pointers' => $pointers, 'title' => $title, 'labels' => $labels, 'datasets' => $datasets]);
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
