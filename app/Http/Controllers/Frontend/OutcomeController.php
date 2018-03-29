<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OutcomeController extends Controller
{
    //
	public function indexAction() {
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

		return view('frontend.outcome.index', compact('trend_analysis'));
	}
}
