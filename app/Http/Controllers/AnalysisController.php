<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CurlHelper;
use App\Jobs\FetchDataValue;
use App\Jobs\FetchDataElements;

use App\DataSets;
use App\DataElements;
use App\OrganizationUnit;
use App\CategoryCombos;
use App\CategoryOptionCombos;

class AnalysisController extends Controller
{
    use CurlHelper;
		private $baseUrl = "https://centraldhis.mohfw.gov.bd/dhismohfw/api/26/";
		private $dataSetIds = ['MRAMSldVeTu'=>[], 'zD5f2fDwkZW'=>[], 'R1tTwMwmi8o'=>[], 'Gq8qQ6vFMhD'=>[]];
    private $baseDiction = [
      'central'=>[
        'baseUrl'=>"https://centraldhis.mohfw.gov.bd/dhismohfw/api/",
        'dataSetIds'=>['MRAMSldVeTu','zD5f2fDwkZW']
      ], 
      'community'=>[
        'baseUrl'=>"https://communitydhis.mohfw.gov.bd/nationalcc/api/",
        'dataSetIds'=>['R1tTwMwmi8o','Gq8qQ6vFMhD']
      ]
    ];

		// public function __construct() {
		// 	$baseUrl =  = "https://centraldhis.mohfw.gov.bd/dhismohfw/api/26/";
		// }

    public function getDataSet($datasetId='') {
      $keys = array_keys($this->baseDiction);
      for($i = 0; $i < count($keys); $i++) {
        $baseUrl = $this->baseDiction[$keys[$i]]['baseUrl'];
        $dataSets = $this->baseDiction[$keys[$i]]['dataSetIds'];
        for($j = 0; $j < count($dataSets); $j++) {
          $response = $this->callUrl($baseUrl."/dataSets/".$dataSets[$j].".json");
          $response = json_decode($response);
          // dd($response);
          // $unit = new Datasets();
          // $unit->api_id = $response->id;
          // $unit->name = $response->name;
          // $unit->server = $keys[$i];
          // $unit->save();
          // dd($response->name);
          $this->dataSetIds[$dataSets[$j]] = $response->name;
        }
      }
      return array("dataSets"=>$this->dataSetIds);
    }

    

     public function getDataValueSet($datasetId='', Request $request) {
    	$data = $request->all();
      $dataSet = $data['dataSet'];
      $ds = DataSets::where('api_id',$dataSet)->first();
      $period = $data['period'];
      // $dataElements = $data['dataElement'];
      $organization = $data['organization'];
      $responses = $this->getDataElements($dataSet);
      $dx = '';
      for ($i=0; $i < count($responses); $i++) { 
        if($i == count($responses) - 1)
          $dx .= $responses[$i]->id;
        else
          $dx .= $responses[$i]->id.';';
      }
      // for ($i=0; $i < count($dataElements); $i++) { 
      //   if($i == count($dataElements) - 1)
      //     $dx .= $dataElements[$i];
      //   else
      //     $dx .= $dataElements[$i].';';
      // }

      $pe='';
      for ($i=0; $i < count($period); $i++) { 
        if($i == count($period) - 1)
          $pe .= $period[$i];
        else
          $pe .= $period[$i].';';
      }
      $ou = $organization;
      
      // $organizationId = OrganizationUnit::where('name', $organization)->first();
      $baseUrl = '';
      if(strcasecmp($ds->server, "central") == 0){
        $baseUrl = $this->baseDiction['central']['baseUrl'];
      }else if(strcasecmp($ds->server, "community") == 0){
        $baseUrl = $this->baseDiction['community']['baseUrl'];
      }
      // dd($organizationId->api_id);
      // $orgId = $organizationId->api_id;
      // dd($orgId);
      $query = $baseUrl."analytics.json?dimension=dx:".$dx."&dimension=ou:".$ou.'&dimension=pe:'.$pe;
      dd($query);
      $response = $this->callUrl($query); 
      
      $response = json_decode($response);
      $metadata = $response->metaData;
      // dd($metadata);
      $rows = ($response->rows);
      $actualData = [];
      $divisionArr = [];
      $datesArr = [];
      $elementsArr = [];
      foreach($rows as $keyrow=>$row){
        foreach($row as $key=>$value){
        // dd($currRow[0]);
          // dd($metadata->items->$value);
          
          if($key == 0) {
            $actualData[$keyrow]['element'] = $metadata->items->$value->name;
            if(!in_array($metadata->items->$value->name, $elementsArr)) {
              array_push($elementsArr, $metadata->items->$value->name);
            }
          }
          else if($key == 1) {
            $actualData[$keyrow]['organisation'] = $metadata->items->$value->name;
            if(!in_array($metadata->items->$value->name, $divisionArr)) {
              array_push($divisionArr, $metadata->items->$value->name);
            }
          }
          else if($key == 2) {
            $actualData[$keyrow]['period'] = $value;
            if(!in_array($metadata->items->$value->name, $datesArr)) {
              array_push($datesArr, $metadata->items->$value->name);
            }
          }
          else if($key == 3)
            $actualData[$keyrow]['value'] = $value;
          
        }
        // $actualData[$i][$metadata->$currRow[0]->name] = $metadata->$currRow[0]->name;
        // $actualData[$i][$metadata->$currRow[1]->name] = $metadata->$currRow[1]->name;
        // $actualData[$i]['period'] = $currRow[2];
        // $actualData[$i]['value'] = $currRow[3];
      }
      usort($actualData, $this->build_sorter('period'));
      array_multisort(array_column($actualData, 'period'), SORT_ASC,
                array_column($actualData, 'organisation'), SORT_ASC,
                $actualData);
      
      $sortedArray = [];
      for ($i=0; $i < count($actualData); $i++) { 
        $sortedArray[$actualData[$i]['period']][$i] = $actualData[$i];
      }
      // dd($sortedArray);
      // exit();
      return view('nutrition.partials.analyticsValueSet')->with(array('actualData'=>$sortedArray, 'metadata'=>$metadata, 'divisionArr'=>$divisionArr, 'datesArr'=>$datesArr, 'elementsArr'=>$elementsArr))->render();
    }

    function build_sorter($key) {
        return function ($a, $b) use ($key) {
            return strnatcmp($a[$key], $b[$key]);
        };
    }

    public function getDataElements($datasetId='') { 
    	$keys = array_keys($this->baseDiction);
      $responses = [];
      $dataIds = [];
      for($i = 0; $i < count($keys); $i++) {
        $baseUrl = $this->baseDiction[$keys[$i]]['baseUrl'];
        $dataSets = $this->baseDiction[$keys[$i]]['dataSetIds'];
        
        for($j = 0; $j < count($dataSets); $j++) {
          $response = $this->callUrl($baseUrl."/dataSets/".$dataSets[$j].".json?fields=dataSetElements[dataElement[id,name]]");
          $response = json_decode($response);
          $dataSetElements = $response->dataSetElements;
          for ($k=0; $k < count($dataSetElements); $k++) { 
            $dataElement = $dataSetElements[$k]->dataElement;
            // dd($dataElement);
            array_push($responses, $dataElement);
          }
        }
      }
      return $responses;
    }

    // public function getDataElements($datasetId='') {
    //   $baseUrl = '';
    //   $keys = array_keys($this->baseDiction);
    //   for($i = 0; $i < count($keys); $i++) {
    //     $dataSets = $this->baseDiction[$keys[$i]]['dataSetIds'];
    //     if(in_array($datasetId, $dataSets))
    //       $baseUrl = $this->baseDiction[$keys[$i]]['baseUrl'];
    //   }
    //   $response = $this->callUrl($baseUrl."/dataSets/".$datasetId.".json?fields=dataElements[id,name]"); 
    //   $response = json_decode($response);
    //   $response = $response->organisationUnits;
    //   dd($response);
    //   // $keys = array_keys($this->dataSetIds);
    //   $dataSet = [];
    //   $datas = [];
    //   for($i = 0; $i < count($response); $i++) {
    //     // $job = new FetchDataValue($response[$i]->id);
    //     // $val = $this->dispatch($job);
    //     // array_push($datas, $val);
    //     $dataSet[$response[$i]->id] = $response[$i]->name;
    //   }
    //   // dd($datas);
    //   // dd($datas);
    //   sort($dataSet);
    //   return array("dataSets"=>$dataSet);
    // }
}
