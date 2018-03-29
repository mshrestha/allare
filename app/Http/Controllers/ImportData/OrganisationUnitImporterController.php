<?php

namespace App\Http\Controllers\ImportData;

use App\Http\Controllers\Controller;
use App\Models\OrganizationUnit;
use App\Traits\CurlHelper;
use Illuminate\Http\Request;

class OrganisationUnitImporterController extends Controller
{
	use CurlHelper;

	public function import() {
		$servers = [
			'central' => 'https://centraldhis.mohfw.gov.bd/dhismohfw/api/organisationUnits.json?level=',
			'community' => 'https://communitydhis.mohfw.gov.bd/nationalcc/api/organisationUnits.json?level='
		];
		
		OrganizationUnit::truncate();

		foreach($servers as $key => $server) {
			for ($i=1; $i <= 2; $i++) {  //Level 2
				$response = $this->callUrl($server.$i);
				$response = json_decode($response);

				foreach($response->organisationUnits as $organisationUnit) {	
					$organisation_unit = new OrganizationUnit;
					$organisation_unit->api_id = $organisationUnit->id;
					$organisation_unit->name = $organisationUnit->displayName;
					$organisation_unit->level = $i;
					$organisation_unit->server = $key;					
					$organisation_unit->save();
				}

			}
		}

		dd('done');
	}
}
