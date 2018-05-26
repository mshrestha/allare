<?php 

namespace App\Traits;

trait CurlHelper
{
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
          "Authorization: Basic ".base64_encode('view:DGHS@1234')
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
}