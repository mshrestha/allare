<?php

namespace App\Http\Controllers\ImportData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrganisationUnitImporterController extends Controller
{
	use CurlHeler;
	public function import() {
		$servers = [
			'https://centraldhis.mohfw.gov.bd/dhismohfw/api/organisationUnits.json?level=',	
			'https://communitydhis.mohfw.gov.bd/nationalcc/api/organisationUnits.json?level='	
		];

		foreach($servers as $server) {
			for ($i=1; $i <= 2; $i++) {  //Level 2
				$response = $this->callUrl('https://centraldhis.mohfw.gov.bd/dhismohfw/api/organisationUnits.json?level='. $i);
				$response = json_decode($response);
				dd($response);
			}
		}
	}
}
