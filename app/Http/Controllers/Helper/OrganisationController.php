<?php

namespace App\Http\Controllers\Helper;

use App\Http\Controllers\Controller;
use App\Traits\CurlHelper;
use App\Models\OrganisationUnit;

class OrganisationController extends Controller {
	use CurlHelper;
	public function getOrganizationDivisions() {
		// $urls = [config('static.centralBaseUrl'), config('static.communityBaseUrl')];
		// $orgArr = [];
		// for ($i = 0; $i < count($urls); $i++) {
		// 	$url = $urls[$i] . config('static.orgUnitEP') . '/dNLjKwsVjod?fields=children[:id,name]';
		// 	$responses = $this->callUrl($url);
		// 	$responses = json_decode($responses);
		// 	$children = $responses->children;
		// 	sort($children);
		// 	for ($i = 0; $i < count($children); $i++) {
		// 		if (!in_array($children[$i], $orgArr)) {
		// 			if (strcasecmp("Ukfjm01aMRf", $children[$i]->id) != 0)
		// 			// array_push($orgArr, $children[$i]);
		// 			{
		// 				$orgArr[$children[$i]->id] = $children[$i]->name;
		// 			}

		// 		}
		// 	}
		// }
		$divisions = OrganisationUnit::where('level', 2)->get();
		$orgArr = [];
		for ($i=0; $i < count($divisions); $i++) { 
			$orgArr[$divisions[$i]->name] = $divisions[$i]->central_api_id.'-'.$divisions[$i]->community_api_id;
		}
		dd($orgArr);
		return array("divisions" => $orgArr);
	}

	public function fetchOrganisationUnit() {
		$divisions = OrganisationUnit::where('level', 2)->get();
		$orgArr = [];
		for ($i=0; $i < count($divisions); $i++) { 
			$orgArr[$children[$i]->name] = $divisions[$i]->central_api_id.'-'.$divisions[$i]->community_api_id;
		}
		dd($orgArr);
	}
}