<?php

namespace App\Http\Controllers\ImportData;

use App\Http\Controllers\Controller;
use App\Models\CategoryOptionCombo;
use App\Traits\CurlHelper;
use Illuminate\Http\Request;

class CategoryOptionComboImporterController extends Controller
{
	use CurlHelper;

	public function import() {
		$servers = [
			'central' => 'https://centraldhis.mohfw.gov.bd/dhismohfw/api/categoryOptionCombos.json?paging=false',
			'community' => 'https://communitydhis.mohfw.gov.bd/nationalcc/api/categoryOptionCombos.json?paging=false'
		];

		foreach($servers as $key => $server) {
			$response = $this->callUrl($server);
			$response = json_decode($response);
			
			foreach($response->categoryOptionCombos as $row) {	
				$categoryOptionCombo = new CategoryOptionCombo;
				$categoryOptionCombo->api_id = $row->id;
				$categoryOptionCombo->name = $row->displayName;
				$categoryOptionCombo->server = $key;
				$categoryOptionCombo->import_date = date('Y-m-d');
				$categoryOptionCombo->save();
			}
		}

		dd('done');
	}
}
