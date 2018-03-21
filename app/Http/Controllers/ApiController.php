<?php

namespace App\Http\Controllers;

use App\Traits\CurlHelper;
use Illuminate\Http\Request;
use App\Jobs\FetchDataValue;
use App\Jobs\FetchDataElements;

use App\DataSets;
use App\DataElements;
use App\OrganizationUnit;
use App\CategoryCombos;
use App\CategoryOptionCombos;

class ApiController extends Controller
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

    

    public function getPeriods() {
      $least_year = 2014;
      $least_year_num = 14;

      $current_year = date('Y');
      $current_year_num = substr($current_year,-2);

      $current_month = date('m');
      $current_year_month = $current_year . $current_month;

      $years_months = array();
      $years_months_string = null;

      for ($year=14; $year <= $current_year_num; $year++) { 

        if($year !== (int)$current_year_num) {
          for ($month = 1; $month <= 12; $month++) { 
            (strlen($month) < 2) ? $month = 0 . $month : $month;
            array_push($years_months, '20'.$year.$month);
          }
        } else {
          for ($month = 1; $month <= $current_month; $month++) { 
            (strlen($month) < 2) ? $month = 0 . $month : $month;
            array_push($years_months, '20'.$year.$month);
          }
        }
      }
      return array('periods'=>$years_months);
    }

    public function getOrganizationUnit($datasetId='') {
      $baseUrl = '';
      $keys = array_keys($this->baseDiction);
      for($i = 0; $i < count($keys); $i++) {
        $dataSets = $this->baseDiction[$keys[$i]]['dataSetIds'];
        if(in_array($datasetId, $dataSets))
          $baseUrl = $this->baseDiction[$keys[$i]]['baseUrl'];
      }
    	$response = $this->callUrl($baseUrl."/dataSets/".$datasetId.".json?fields=organisationUnits[id,name]");	
  		$response = json_decode($response);
  		$response = $response->organisationUnits;
  		// dd($response);
    	// $keys = array_keys($this->dataSetIds);
    	$dataSet = [];
      $datas = [];
    	for($i = 0; $i < count($response); $i++) {
        // $job = new FetchDataValue($response[$i]->id);
        // $val = $this->dispatch($job);
        // array_push($datas, $val);
    		$dataSet[$response[$i]->id] = $response[$i]->name;
    	}
    	// dd($datas);
      // dd($datas);
      sort($dataSet);
    	return array("dataSets"=>$dataSet);
    }

    public function getDataSetValues($id = '', Request $request) {
      $data = $request->all();
      $dataSet = $data['dataSet'];
      $period = $data['period'];
      $organization = $data['organization'];
      $organizationId = OrganizationUnit::where('name', $organization)->first();
      if($organizationId != null) {
        $baseUrl = '';
        if(strcasecmp($organizationId->server, "central") == 0){
          $baseUrl = $this->baseDiction['central']['baseUrl'];
        }else if(strcasecmp($organizationId->server, "community") == 0){
          $baseUrl = $this->baseDiction['community']['baseUrl'];
        }
        // dd($organizationId->api_id);
        $orgId = $organizationId->api_id;
        // dd($orgId);
        $query = $baseUrl."dataValueSets?dataSet=".$dataSet."&orgUnit=".$orgId.'&period='.$period;
        // dd($query);
        $response = $this->callUrl($query); 
        // dd($response);
        $response = json_decode($response);

        $returnedData = [];
        
        $dataValues =  $response->dataValues;
        for($i = 0; $i < count($dataValues); $i++) {
          // dd($dataValues[$i]->dataElement);
          $dElem = DataElements::where('api_id', $dataValues[$i]->dataElement)->first();
          $returnedData[$i]['dataElement'] =  $dElem->name;
          $returnedData[$i]['period'] = $dataValues[$i]->period;
          $org = OrganizationUnit::where('api_id', $dataValues[$i]->orgUnit)->first();
          $returnedData[$i]['orgUnit'] = $org->name;
          $returnedData[$i]['value'] =  $dataValues[$i]->value;
          $catOptCombo = CategoryOptionCombos::where('api_id', $dataValues[$i]->categoryOptionCombo)->first();
          $returnedData[$i]['categoryOptionCombos'] = $catOptCombo->name;
        }
        return view('nutrition.partials.dataValueSet', compact('returnedData'))->render();
      }
    }

    // public function getDataValueSet($datasetId='') {
    //   $response = $this->callUrl($this->baseUrl."/dataSets/".$datasetId.".json?fields=organisationUnits[id,name]"); 
    //   $response = json_decode($response);
    //   $response = $response->organisationUnits;
    //   // dd($response);
    //   // $keys = array_keys($this->dataSetIds);
    //   $dataSet = [];
    //   for($i = 0; $i < count($response); $i++) {
    //     // $dataSet[$response[$i]->id] = $response[$i]->name;
    //     // $dataSet[$i]['id'] = $response[$i]->id;
    //     // $dataSet[$i]['name'] = $response[$i]->name;
    //     $dataSet[$i] = $response[$i];
    //   }
    //   // dd($dataSet);
    //   $urls = [];
    //   $responses = [];
    //   $orgs = '';
    //   $params = array(
    //     // 'url'=>'https://play.dhis2.org/dev//api/26/dataElements?fields=dataElements~paging(1;20)',
    //     'return_transfer' => true,
    //     'postfields' => '',//grant_type=refresh_token&refresh_token=e175038d-10e9-45f4-a0e3-6b0837eba84f',
    //     'post' => false,
    //     'headers' => array(
    //       "Accept: application/json",
    //       "content-type: application/x-www-form-urlencoded",
    //       "Authorization: Basic ".base64_encode('view:DGHS1234')
    //       // "Authorization: Basic ".base64_encode('demo:1e6db50c-0fee-11e5-98d0-3c15c2c6caf6')
    //     )
    //   );
    //   $batch_size = 32;
    //   $totalLoops = count($dataSet)/$batch_size;
    //   // dd($totalLoops);
    //   // dd(array_chunk($dataSet, 32));
    //   $totalLoops = array_chunk($dataSet, 32);
    //   foreach ($totalLoops as $loops) {
    //     $urls = [];
    //     foreach($loops as $key=>$data) {
    //       // print_r($data->id);exit();
    //       array_push($urls, "https://centraldhis.mohfw.gov.bd/dhismohfw/api/dataValueSets?dataSet=".$datasetId."&orgUnit=".$data->id."&period=201401");
    //     }
    //     $r = $this->multiRequest($params, $urls);
    //     array_push($responses, $r);
    //   }
      
    //   // // echo $orgs; exit();
    //   // // sort($dataSet);
    //   // $query = $this->baseUrl."dataValueSets?dataSet=".$datasetId."&period=201401".$orgs;
    //   // // echo $query; exit();
    //   // $response = $this->callUrl($this->baseUrl."dataValueSets?dataSet=".$datasetId."&period=201401".$orgs); 
    //   // $response = json_decode($response);
    //   // dd($response);
    //   // $urls=[
    //   // "https://centraldhis.mohfw.gov.bd/dhismohfw/api/dataValueSets?dataSet=MRAMSldVeTu&orgUnit=WZfjur8ksV6&period=201401&period=201402&period=201403&period=201404&period=201405&period=201406&period=201407&period=201408&period=201409&period=201410&period=201411&period=201412&period=201501&period=201502&period=201503&period=201504&period=201505&period=201506&period=201507&period=201508&period=201509&period=201510&period=201511&period=201512&period=201601&period=201602&period=201603&period=201604&period=201605&period=201606&period=201607&period=201608&period=201609&period=201610&period=201611&period=201612&period=201701&period=201702&period=201703&period=201704&period=201705&period=201706&period=201707&period=201708&period=201709&period=201710&period=201711&period=201712",
     
    //   // "https://centraldhis.mohfw.gov.bd/dhismohfw/api/dataValueSets?dataSet=MRAMSldVeTu&orgUnit=WZfjur8ksV6&period=201512",
    //   // ];
    //   dd($responses);
    //   exit();
    //   $r = $this->multiRequest($params, $urls);
    //   dd($r);
    //   // return array("dataSets"=>$dataSet);
    // }


    public function getDataValueSet($datasetId='') {
      $response = $this->callUrl($this->baseUrl."/dataSets/".$datasetId.".json?fields=organisationUnits[id,name]"); 
      $response = json_decode($response);
      $response = $response->organisationUnits;
      // dd($response);
      // $keys = array_keys($this->dataSetIds);
      $dataSet = [];
      for($i = 0; $i < count($response); $i++) {
        // $dataSet[$response[$i]->id] = $response[$i]->name;
        // $dataSet[$i]['id'] = $response[$i]->id;
        // $dataSet[$i]['name'] = $response[$i]->name;
        $dataSet[$i] = $response[$i];
      }
      // dd($dataSet);
      $urls = [];
      $responses = [];
      $orgs = '';
      $params = array(
        // 'url'=>'https://play.dhis2.org/dev//api/26/dataElements?fields=dataElements~paging(1;20)',
        'return_transfer' => true,
        'postfields' => '',//grant_type=refresh_token&refresh_token=e175038d-10e9-45f4-a0e3-6b0837eba84f',
        'post' => false,
        'headers' => array(
          "Accept: application/json",
          "content-type: application/x-www-form-urlencoded",
          "Authorization: Basic ".base64_encode('view:DGHS1234')
          // "Authorization: Basic ".base64_encode('demo:1e6db50c-0fee-11e5-98d0-3c15c2c6caf6')
        )
      );
      $batch_size = 32;
      $totalLoops = count($dataSet)/$batch_size;
      // dd($totalLoops);
      // dd(array_chunk($dataSet, 32));
      $totalLoops = array_chunk($dataSet, 32);
      foreach ($totalLoops as $loops) {
        $urls = [];
        foreach($loops as $key=>$data) {
          // print_r($data->id);exit();
          array_push($urls, "https://centraldhis.mohfw.gov.bd/dhismohfw/api/analytics/dataValueSets?dataSet=".$datasetId."&orgUnit=".$data->id."&period=201401");
        }
        $r = $this->multiRequest($params, $urls);
        array_push($responses, $r);
      }
      
      // // echo $orgs; exit();
      // // sort($dataSet);
      // $query = $this->baseUrl."dataValueSets?dataSet=".$datasetId."&period=201401".$orgs;
      // // echo $query; exit();
      // $response = $this->callUrl($this->baseUrl."dataValueSets?dataSet=".$datasetId."&period=201401".$orgs); 
      // $response = json_decode($response);
      // dd($response);
      // $urls=[
      // "https://centraldhis.mohfw.gov.bd/dhismohfw/api/dataValueSets?dataSet=MRAMSldVeTu&orgUnit=WZfjur8ksV6&period=201401&period=201402&period=201403&period=201404&period=201405&period=201406&period=201407&period=201408&period=201409&period=201410&period=201411&period=201412&period=201501&period=201502&period=201503&period=201504&period=201505&period=201506&period=201507&period=201508&period=201509&period=201510&period=201511&period=201512&period=201601&period=201602&period=201603&period=201604&period=201605&period=201606&period=201607&period=201608&period=201609&period=201610&period=201611&period=201612&period=201701&period=201702&period=201703&period=201704&period=201705&period=201706&period=201707&period=201708&period=201709&period=201710&period=201711&period=201712",
     
      // "https://centraldhis.mohfw.gov.bd/dhismohfw/api/dataValueSets?dataSet=MRAMSldVeTu&orgUnit=WZfjur8ksV6&period=201512",
      // ];
      dd($responses);
      exit();
      $r = $this->multiRequest($params, $urls);
      dd($r);
      // return array("dataSets"=>$dataSet);
    }

    public function callUrl($url) {
      $returnVal1 = $this->callCurl(array(
        // 'url'=>'https://play.dhis2.org/dev//api/26/dataElements?fields=dataElements~paging(1;20)',
        'url'=>$url,
        'return_transfer' => true,
        'postfields' => '',//grant_type=refresh_token&refresh_token=e175038d-10e9-45f4-a0e3-6b0837eba84f',
        'post' => false,
        'headers' => array(
          "Accept: application/json",
          "content-type: application/x-www-form-urlencoded",
          "Authorization: Basic ".base64_encode('view:DGHS1234')
          // "Authorization: Basic ".base64_encode('demo:1e6db50c-0fee-11e5-98d0-3c15c2c6caf6')
        )
      ));
      if($returnVal1['error']) {
        echo 'Error: '.$returnVal1['msg'];
      } else {
        // $response1 = json_decode($returnVal1['msg']);
        return ($returnVal1['msg']);
      }
    }

     private function callCurl($params) {
      $curl = curl_init();
      // $name = generateRandomString();
      // $cid = generateRandomString();
      curl_setopt_array($curl, array(
        // CURLOPT_URL => "https://play.dhis2.org/dev/uaa/oauth/token",
        CURLOPT_URL => $params['url'],//"https://play.dhis2.org/dev/api/oAuth2Clients",
        CURLOPT_RETURNTRANSFER => $params['return_transfer'],//true,
        CURLOPT_POSTFIELDS => $params['postfields'],//'{"name" : "'.$name.'","cid" : "'.$cid.'","secret" : "1e6db50c-0fee-11e5-98d0-3c15c2c6caf6","grantTypes" : ["password","refresh_token","authorization_code"],"redirectUris" : ["http://www.example.org"]}',
        CURLOPT_POST => $params['post'],//true,
        CURLOPT_HTTPHEADER => $params['headers'],
        // CURLOPT_CUSTOMREQUEST => 'GET',
        // array(
        //   "Accept: application/json",
        //   "Content-Type: application/json",
        //   "Authorization: Basic ".base64_encode('admin:district')
        //   // "Authorization: Basic ".base64_encode('demo:1e6db50c-0fee-11e5-98d0-3c15c2c6caf6')
        // )
      ));

      $response = curl_exec($curl);
      $error = curl_error($curl);
      curl_close($curl);
      if($error) {
        return array('error'=>true, 'msg'=>$error);
      } else {
        return array('error'=>false, 'msg'=>$response);
      }
    }

    function multiRequest($params, $data, $options = array()) {
      // array of curl handles
      $curly = array();
      // data to be returned
      $result = array();
     
      // multi handle
      $mh = curl_multi_init();
     
      // loop through $data and create curl handles
      // then add them to the multi-handle
      foreach ($data as $id => $d) {
     
        $curly[$id] = curl_init();
     
        curl_setopt_array($curly[$id], array(
        // CURLOPT_URL => "https://play.dhis2.org/dev/uaa/oauth/token",
        CURLOPT_URL => $d,//"https://play.dhis2.org/dev/api/oAuth2Clients",
        CURLOPT_RETURNTRANSFER => $params['return_transfer'],//true,
        CURLOPT_POSTFIELDS => $params['postfields'],//'{"name" : "'.$name.'","cid" : "'.$cid.'","secret" : "1e6db50c-0fee-11e5-98d0-3c15c2c6caf6","grantTypes" : ["password","refresh_token","authorization_code"],"redirectUris" : ["http://www.example.org"]}',
        CURLOPT_POST => $params['post'],//true,
        CURLOPT_HTTPHEADER => $params['headers'],
        // CURLOPT_CUSTOMREQUEST => 'GET',
        // array(
        //   "Accept: application/json",
        //   "Content-Type: application/json",
        //   "Authorization: Basic ".base64_encode('admin:district')
        //   // "Authorization: Basic ".base64_encode('demo:1e6db50c-0fee-11e5-98d0-3c15c2c6caf6')
        // )
      ));
     
        curl_multi_add_handle($mh, $curly[$id]);
      }
     
      // execute the handles
      $running = null;
      do {
        curl_multi_exec($mh, $running);
      } while($running > 0);
     
     
      // get content and remove handles
      foreach($curly as $id => $c) {
        $result[$id] = curl_multi_getcontent($c);
        curl_multi_remove_handle($mh, $c);
      }
     
      // all done
      curl_multi_close($mh);
     
      return $result;
    }

    public function getDataElements($id = null) {
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
            $dataSet = DataSets::where('api_id', $dataSets[$j])->first();

              $unit = new DataElements();
              $unit->api_id = $dataElement->id;
              $unit->name = $dataElement->name;
              $unit->server = $keys[$i];
              $unit->data_set_id = $dataSet->id;
              $unit->save();
            // if(in_array($dataElement->id, $dataIds))
            //   continue;
            // else {
            //   array_push($dataIds, $dataElement->id);
            //   $dataSet = DataSets::where('api_id', $dataSets[$j])->first();

            //   $unit = new DataElements();
            //   $unit->api_id = $dataElement->id;
            //   $unit->name = $dataElement->name;
            //   $unit->server = $keys[$i];
            //   $unit->data_set_id = $dataSet->id;
            //   $unit->save();
            // }
          }
          // array_push($responses, $response);
          // $this->dataSetIds[$dataSets[$j]] = $response;
        }
      }
      // dd($responses);
      
      // for ($i=0; $i < count($responses); $i++) { 
      //   $dataSetElements = $responses[$i]->dataSetElements;
      //   for($j=0; $j < count($dataSetElements); $j++) {
      //     $dataElements = $dataSetElements[$j]->dataElement;
      //     // dd($dataSetElements[$j]->dataElement);
      //     // dd($dataElements);
      //     if(in_array($dataElements->id, $dataIds))
      //       continue;
      //     else {
      //       array_push($dataIds, $dataElements->id);
      //       $unit = new DataElements();
      //       $unit->api_id = $dataElements->id;
      //       $unit->name = $dataElements->name;
      //       // $unit->save();
      //     }
      //   }
      // }
    }

    // public function getOrganizationUnit($datasetId='') {
    //   $keys = array_keys($this->baseDiction);
    //   $responses = [];
    //   $ids = [];
    //   for($i = 0; $i < count($keys); $i++) {
    //     $baseUrl = $this->baseDiction[$keys[$i]]['baseUrl'];
    //     $dataSets = $this->baseDiction[$keys[$i]]['dataSetIds'];
        
    //     for($j = 0; $j < count($dataSets); $j++) {
    //       // $response = $this->callUrl($baseUrl."/dataSets/".$dataSets[$j].".json?fields=organisationUnits[id,name,level]");
    //       $response = $this->callUrl($baseUrl."organisationUnits.json?paging=false&fields=[id,name,level]");
    //       $response = json_decode($response);
    //       $organisationUnits = $response->organisationUnits;
    //       // dd($organisationUnits);
    //       for ($k=0; $k < count($organisationUnits); $k++) { 

    //         if(in_array($organisationUnits[$k]->id, $ids)) {

    //         } else {
    //           array_push($ids,$organisationUnits[$k]->id);
    //           $unit = new OrganizationUnit();
    //           $unit->api_id = $organisationUnits[$k]->id;
    //           $unit->name = $organisationUnits[$k]->name;
    //           $unit->server = $keys[$i];
    //           $unit->level = $organisationUnits[$k]->level;
    //           $unit->save();
    //         }
    //       }
    //       // array_push($responses, $response);
    //       // $this->dataSetIds[$dataSets[$j]] = $response;
    //     }
    //   }
     
    // }
  
}
