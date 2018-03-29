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
		$organisation_units = OrganisationUnit::all();
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
			'plw_who_receive_ifas' => 'Plw how receive ifas',
			'pregnant_women_weighed' => 'Pregnant women weighed',
		];


		return view('frontend.output.index', 
			compact('trend_analysis','organisation_units','periods','indicators')
		);
	}
}
