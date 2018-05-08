<?php 

namespace App\Traits;

use App\Models\OrganisationUnit;

trait OrganisationHelper
{
  public function getOrganisations($server) {
    $organisations = OrganisationUnit::all();
    $orgArray = [];
    $orgQueryString = '';
    $orgIdArr = [];
    for ($i=0; $i < count($organisations); $i++) { 
      // if(in_array($organisations[$i], $orgArray))
      //   array_push($orgArray, $organisations[$i]);
      if(!$this->existsInArray($orgArray, $organisations[$i])) {
        array_push($orgArray, $organisations[$i]);
        if($server == 'community') {
          $orgQueryString .= $organisations[$i]->community_api_id.';';
          array_push($orgIdArr, $organisations[$i]->community_api_id);
        }
        else if ($server == 'central') {
          $orgQueryString .= $organisations[$i]->central_api_id.';';
          array_push($orgIdArr, $organisations[$i]->central_api_id);
        }
      }
    }
    $orgQueryString = rtrim($orgQueryString,";");
    return array('organisations'=>$orgArray, 'organisation_string' => $orgQueryString, 'organisation_unit_array' => $orgIdArr);
  }

  public function existsInArray($arr, $val) {
    for ($i=0; $i < count($arr); $i++) { 
      if($arr[$i]->id == $val->id) {
        return true;
      }
    }
    return false;
  }

}

