<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TechnicalStandardController extends Controller
{
  public function indexAction() {
  	$standards = $this->getAllStandards();
  	return view('frontend.technicalstandard.index', compact('standards'));
  }

  public function getAllStandards() {
		return [
			"Maternal Counselling" => [
				"level" => "Output",
				"indicator" => "% of women receiving maternal nutrition counselling",
				"definition" => "# of visits with pregnant and lactating women up to two years after birth with a counselling session on maternal nutrition divided by the total # of visits with pregnant and lactating women up to 2 years after birth",
				"target" => "70%",
				"frequency" => "Monthly",
				"table_data" => [
					["Community Clinics", "CHCP", "CHCP", "Maternal Register", "Maternal form"],
					["Home visits", "CHCP", "FWA", "FW Register", "MIS-1"],
					["Family Welfare Center", "FWV", "CHCP", "Pregnant Mother Register", "MIS-3"]
				],
				"text" => "The minimum set of counselling messages that must be delivered to be reported as counselling distribution are:
				Dietary Diversity, IFA supplementation, Exclusive Breastfeeding and Early Initiation of Breastfeeding, weight management during pregnancy/lactation
				** Messages should vary based on trimester"
			],
			"IYCF Counselling" => [
				"level" => "Output",
				"indicator" => "% of caregivers of children 0-23 months old receiving age appropriate IYCF counselling			",
				"definition" => "# of visits with children under 23 months with a counselling session on IYCF for the caregiver divided by the total # of visits with  children under 23 months			",
				"target" => "60%",
				"frequency" => "Monthly",
				"table_data" => [
					["Community Clinics", "CHCP", "CHCP", "Newborn and Child Register (new)", "TBD"],
					["Home visits", "HA", "CHCP", "Newborn and Child Register (new)", "TBD"],
					["Home visits", "FWA", "FPI -> UFPO", "FW Register", "MIS-1"],
					["Family Welfare Centers", "FWV", "UFPO", "Child register", "MIS-3"]
				],
				"text" => "The minimum set of counselling messages that must be delivered to be reported as counselling distribution are:
				Dietary Diversity, Exclusive Breastfeeding, Continued breastfeeding up to 2 years, Vitamin A supplementation and Iodine fortification
				** Messages should be age and context appropriate"
			],
			"IFA Distribution" => [
				"level" => "Output",
				"indicator" => "% of visits with pregnant women who received any IFA			",
				"definition" => "# of visits with pregnant women when IFA was distributed divided by the total number of visits with pregnant women",
				"target" => "60%",
				"frequency" => "Monthly",
				"table_data" => [
					["Community Clinics", "CHCP", "CHCP", "Maternal Register", "Maternal form"],
					["Home visits", "FWA", "FPI -> UFPO", "FW Register", "MIS-1"],
					["Family Welfare Center", "FWV", "UFPO", "Pregnant Mother Register", "MIS-3"]
				],
				"text" => "Monthly reports should include the number of times women received IFA (separated by ANC/PNC if available); registers should have the number of IFA Tablets distributed for Quality Assessment purposes"
			],
			"Child Weight" => [
				"level" => "Output",
				"indicator" => "% of children 0-23 months old whose weight was taken at a facility			",
				"definition" => "Number of facility visits with a child 0-23 months when weight was taken divided by the total number of facility visits with a child 0-23 months",
				"target" => "35%",
				"frequency" => "Monthly",
				"table_data" => [
					["Community Clinics", "CHCP", "CHCP", "Newborn and Child Register", "Child form"],
					["Family Welfare Center", "FWV", "UFPO", "Child register", "MIS-3(new)"]
				],
				"text" => "Monthly reports should include the number of times children were weighed and the total number of child visits; should have the weight for each time it was measured (but not estimated if weight was not taken properly). Growth monitoring is the ideal with an individual card, but at a minimum a child should be weighed"
			],
			"Maternal Weight" => [
				"level" => "Output",
				"indicator" => "% of times women attended a facility during pregnancy that they were weighed",
				"definition" => "# of facility visits with pregnant women when weight was taken divided by the total number of facility visits with pregnant women",
				"target" => "25%",
				"frequency" => "Monthly",
				"table_data" => [
					["Community Clinics", "CHCP", "CHCP", "Maternal Register", "Maternal form"],
					["Family Welfare Center", "FWV", "UFPO", "Pregnant Mother Register", "MIS-3(new)"]
				],
				"text" => "Monthly reports should include the number of times pregnant women were weighed; registers should have the weight for each time it was measured (but not estimated if weight was not taken properly)"
			]
		];
	}
}
