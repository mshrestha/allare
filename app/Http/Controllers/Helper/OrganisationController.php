<?php

namespace App\Http\Controllers\Helper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Traits\CurlHelper;

class OrganisationController extends Controller
{
	use CurlHelper;
  public function getOrganizationDivisions() {
    $urls = [config('static.centralBaseUrl'), config('static.communityBaseUrl')];
    $orgArr = [];
    for($i = 0; $i < count($urls); $i++) {
      $url = $urls[$i].config('static.orgUnitEP').'/dNLjKwsVjod?fields=children[:id,name]';
      $responses = $this->callUrl($url);
      $responses = json_decode($responses);
      $children = $responses->children;
      sort($children);
      for ($i=0; $i < count($children); $i++) {
      	if(!in_array($children[$i], $orgArr)) {
      		if(strcasecmp("Ukfjm01aMRf", $children[$i]->id) != 0)
      			// array_push($orgArr, $children[$i]);
            $orgArr[$children[$i]->id] = $children[$i]->name;
      	}
      }
    }
    return array("divisions"=>$orgArr);
  }
}
