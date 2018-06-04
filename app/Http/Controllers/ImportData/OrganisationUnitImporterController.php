<?php

namespace App\Http\Controllers\ImportData;

use App\Http\Controllers\Controller;
use App\Models\OrganisationUnit;
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
		
		OrganisationUnit::truncate();

		foreach($servers as $key => $server) {
			for ($i=1; $i <= 3; $i++) {  //Level 2
				$response = $this->callUrl($server.$i.'&paging=false');
				$response = json_decode($response);

				foreach($response->organisationUnits as $organisationUnit) {
					if($i == 3) {
						if(strpos(strtolower($organisationUnit->displayName), 'district') !== false) {
							$unit = OrganisationUnit::where('name', $organisationUnit->displayName)->first();
							if($key == 'central') {
								$save_data = [
									'central_api_id' => $organisationUnit->id,
									'name' => $organisationUnit->displayName,
									'level' => $i,
									'source' => 'DGHS',
								];
							} else {
								$save_data = [
									'community_api_id' => $organisationUnit->id,
									'name' => $organisationUnit->displayName,
									'level' => $i,
									'source' => 'DGHS',
								];
							}
							
							if($unit) {
								$unit->update($save_data);
							} else {
								OrganisationUnit::create($save_data);
							}
						}
					}else{
						$unit = OrganisationUnit::where('name', $organisationUnit->displayName)->first();
						if($key == 'central') {
							$save_data = [
								'central_api_id' => $organisationUnit->id,
								'name' => $organisationUnit->displayName,
								'level' => $i,
								'source' => 'DGHS',
							];
						} else {
							$save_data = [
								'community_api_id' => $organisationUnit->id,
								'name' => $organisationUnit->displayName,
								'level' => $i,
								'source' => 'DGHS',
							];
						}
						
						if($unit) {
							$unit->update($save_data);
						} else {
							OrganisationUnit::create($save_data);
						}
					}
				}

			}
		}

		dd('done');
	}
}
