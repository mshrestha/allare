<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurlController extends Controller
{
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

    public function getAccessToken() {
      $returnVal1 = $this->callCurl(array(
        'url'=>'https://play.dhis2.org/dev/uaa/oauth/token',
        'return_transfer' => true,
        'postfields' => 'grant_type=password&username=admin&password=district',
        'post' => true,
        'headers' => array(
          "Accept: application/json",
          "content-type: application/x-www-form-urlencoded",
          "Authorization: Basic ".base64_encode('OnKzmW4PNo:1e6db50c-0fee-11e5-98d0-3c15c2c6caf6')
          // "Authorization: Basic ".base64_encode('demo:1e6db50c-0fee-11e5-98d0-3c15c2c6caf6')
        )
      ));
      if($returnVal1['error']) {
        echo 'Error: '.$returnVal1['msg'];
      } else {
        $response1 = json_decode($returnVal1['msg']);
        print_r($response1);
      }
    }

    public function refreshToken() {
      $returnVal1 = $this->callCurl(array(
        'url'=>'https://play.dhis2.org/dev/uaa/oauth/token',
        'return_transfer' => true,
        'postfields' => 'grant_type=refresh_token&refresh_token=3d599ca6-6a2f-4aaf-b9ad-6f8dc4e879a6',
        'post' => true,
        'headers' => array(
          "Accept: application/json",
          "content-type: application/x-www-form-urlencoded",
          "Authorization: Basic ".base64_encode('OnKzmW4PNo:1e6db50c-0fee-11e5-98d0-3c15c2c6caf6')
          // "Authorization: Basic ".base64_encode('demo:1e6db50c-0fee-11e5-98d0-3c15c2c6caf6')
        )
      ));
      if($returnVal1['error']) {
        echo 'Error: '.$returnVal1['msg'];
      } else {
        $response1 = json_decode($returnVal1['msg']);
        print_r($response1);
      }
    }

    public function periodFormat($url) {
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
        echo($returnVal1['msg']);
      }
    }

    public function dataSet($id='') {
      $this->periodFormat('http://103.247.238.67:8080/dhismohfw/api/dataSets/'.$id);
    }

    public function dataElement($id='') {
      $this->periodFormat('http://103.247.238.67:8080/dhismohfw/api/dataElements/'.$id);
    }

    public function dataElementGroup($id='') {
      $this->periodFormat('http://103.247.238.67:8080/dhismohfw/api/dataElementGroups/'.$id);
    }

    public function dataForm($id='') {
      $this->periodFormat('http://103.247.238.67:8080/dhismohfw/api/dataEntryForms/'.$id);
    }

    public function categoryCombo($id='') {
      $this->periodFormat('http://103.247.238.67:8080/dhismohfw/api/categoryCombos/'.$id);
    }
    
    public function categoryComboOption($id='') {
      $this->periodFormat('http://103.247.238.67:8080/dhismohfw/api/categoryOptionCombos/'.$id);
    }

    public function dataSetElements($id='') {
      $this->periodFormat('http://103.247.238.67:8080/dhismohfw/api/dataSetElements/'.$id);
    }  

    public function organizationGroup($id='') {
      $this->periodFormat('http://103.247.238.67:8080/dhismohfw/api/organisationUnitGroups/'.$id);
    }  

    

    public function createAccessUser() {
      $name = $this->generateRandomString();
      $cid = $this->generateRandomString();
      echo $name.'--'.$cid;
      $returnVal = $this->callCurl(array(
        'url'=>'https://play.dhis2.org/dev/api/oAuth2Clients',
        'return_transfer' => true,
        'postfields' => '{"name" : "'.$name.'","cid" : "'.$cid.'","secret" : "1e6db50c-0fee-11e5-98d0-3c15c2c6caf6","grantTypes" : ["password","refresh_token","authorization_code"],"redirectUris" : ["http://www.example.org"]}',
        'post' => true,
        'headers' => array(
          "Accept: application/json",
          "Content-Type: application/json",
          "Authorization: Basic ".base64_encode('admin:district')
          // "Authorization: Basic ".base64_encode('demo:1e6db50c-0fee-11e5-98d0-3c15c2c6caf6')
        )
      ));

      if($returnVal['error']) {
        echo 'Error: '.$returnVal['msg'];
      } else {
        // $request = new Request();
        // $request->setRequestName('Create Client');
        // $request->setUser('Create Client');
        // $request->setRequestName('Create Client');
        // $request->setRequestName('Create Client');
        // $request->setRequestName('Create Client');
        // $request->setRequestName('Create Client');
        $response = json_decode($returnVal['msg']);
        // print_r(gettype($response->response->responseType));
        print_r($response);
        // {"httpStatus":"Created","httpStatusCode":201,"status":"OK","response":{"responseType":"ObjectReport","klass":"org.hisp.dhis.security.oauth2.OAuth2Client","uid":"nsCQZY7aeeU"}}
        if(strcasecmp($response->httpStatus, 'Created') == 0) {
          echo $name.'--<br />'.$cid;
        }
      }
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
