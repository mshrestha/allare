<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\OrganisationUnit;
use App\Traits\PeriodHelper;
use Illuminate\Http\Request;

class OutputController extends Controller
{
	use PeriodHelper;

	public function indexAction() {
		$organisation_units = OrganisationUnit::where('level', 2)->get();
		$periods = $this->getPeriodYears();
		$trend_analysis = [
			[
				'name' => 'Counseling',
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

		$data = config('data.maternal');
		$indicators = [
			'maternal_counselling' => 'Maternal Counselling',
			'plw_who_receive_ifas' => 'Plw who receive ifas',
			'pregnant_women_weighed' => 'Pregnant women weighed',
		];


		return view('frontend.output.index', 
			compact('trend_analysis','organisation_units','periods','indicators')
		);
	}

	public function maternalMainChart(Request $request) {
		$indicator = $request->indicator_id;
		$data_table = config('data.maternal.'.$indicator);
		$periods = explode(';', $request->period_id);
		$organisation_unit = explode('.', $request->organisation_unit_id);
		$source = $request->department_id;
		
		$model = 'App\Models\Data\\' . $data_table[0]['model'];
		$ou = ($data_table[0]['server'] == 'central') ? $organisation_unit[0] : $organisation_unit[1];
		$data = $model::whereIn('period', $periods)->where('source', 'DGHS')->where('organisation_unit', $ou)->whereNull('category_option_combo')->orderBy('period')->get();
		
		$labels = $data->pluck('period_name');
		$datasets = $data->pluck('value');
		$pointers = $request->department_id;
		$title = $data_table[0]['name'];

		return response()->json(['pointers' => $pointers, 'title' => $title, 'labels' => $labels, 'datasets' => $datasets]);
	}
}
