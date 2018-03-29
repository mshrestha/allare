<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\OrganisationUnit;
use Illuminate\Http\Request;

class OutputController extends Controller
{
	public function indexAction() {
		$organisation_units = OrganisationUnit::all();
		
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


		return view('frontend.output.index', 
			compact(
				'trend_analysis',
				'organisation_units'
			)
		);
	}
}
