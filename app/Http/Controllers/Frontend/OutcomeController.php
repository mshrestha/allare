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
		$data = $request->all();
		dd($data);
	}
}
