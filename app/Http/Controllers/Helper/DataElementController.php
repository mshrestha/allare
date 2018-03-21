<?php

namespace App\Http\Controllers\Helper;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Traits\CurlHelper;

class DataElementController extends Controller
{
  use CurlHelper;

  public function getDataElements() {
  	$url = config('static.centralBaseUrl').config('static.datasetEP').'/'.config('static.centralDataSet')[1].'.json?paging=false&fields=dataSetElements[dataElement[name,id]]';
  	$responses = $this->callUrl($url);
  	$responses = json_decode($responses);
  	$dataElements = [];
  	$dataSetElements = $responses->dataSetElements;
  	sort($dataSetElements);
  	for ($i=0; $i < count($dataSetElements); $i++) { 
  		$dataElement = $dataSetElements[$i]->dataElement;
  		// $dataElements[$i]['id'] = $dataElement->id;
  		// $dataElements[$i]['name'] = $dataElement->name;
  		$dataElements[$dataElement->id] = $dataElement->name;
  	}
  	return array('programmes'=>$dataElements);
  }

  public function getDataElementCategory(Request $request) {
  	$data = $request->all();
  	$dataElement = $data['dataElement'];
  	$url = config('static.centralBaseUrl').config('static.dataelementEP').'/'.$dataElement.'.json';
  	$responses = $this->callUrl($url);
  	$responses = json_decode($responses);
  	// dd($responses->categoryCombo);
  	// if($responses.has('categoryCombo')) {
  		$catetegoryCombo = $responses->categoryCombo;
	  	// dd($catetegoryCombo);
	  	$newUrl = config('static.centralBaseUrl').config('static.categoryComboEP').'/'.$catetegoryCombo->id.'.json?fields=:all,categoryOptionCombos[id,name]';
	  	$responses1 = $this->callUrl($newUrl);
	  	$responses1 = json_decode($responses1);
	  	if(isset($responses1->categoryOptionCombos)) {
		  	$catetegoryOptionCombos = $responses1->categoryOptionCombos;
		  	$affectedArr = [];
		  	for ($i=0; $i < count($catetegoryOptionCombos); $i++) { 
		  		// $affectedArrs[$i]['id'] = $catetegoryOptionCombos[$i]->id;
		  		// $affectedArrs[$i]['name'] = $catetegoryOptionCombos[$i]->name;
		  		$affectedArrs[$catetegoryOptionCombos[$i]->id] = $catetegoryOptionCombos[$i]->name;
		  	}
		  	// usort($affectedArrs, $this->build_sorter('name'));
		  	return array('exists'=>'true', 'affectedArrs' => $affectedArrs);
	  	}else {
	  		return array('exists'=>false);
	  	}
  }

  function build_sorter($key) {
    return function ($a, $b) use ($key) {
      return strnatcmp($a[$key], $b[$key]);
    };
  }

  public function getDataValueSet(Request $request) {
  	$data = $request->all();
  	$platformDiction = $data['platformDiction'];
  	
  	$dx = '';
  	if($platformDiction['affected'] == -1)
  		$dx = $platformDiction['programme'];
  	else
  		$dx = $platformDiction['programme'].'.'.$platformDiction['affected'];

  	$pe = 'LAST_MONTH';
  	if(strcasecmp('last_month', $platformDiction['period']) == 0 || strcasecmp('last_6_month', $platformDiction['period']) == 0 ) {
  		$pe = $platformDiction['period'];
  	}else{
  		$platformDiction['period'] = str_replace(',', ';', $platformDiction['period']);
  		$pe = $platformDiction['period'];
  	}
  	$url = config('static.centralBaseUrl').config('static.dataValueEP').'?dimension=dx:'.$dx.'&dimension=pe:'.$pe.'&dimension=ou:'.$platformDiction['division'].'&displayProperty=NAME';
  	// dd($url);
  	$responses = $this->callUrl($url);
  	$responses = json_decode($responses);
  	$dataValues = $responses->dataValues;
  	// $labels = [];
  	// $data = [];
  	// $bgColor = [];
  	// $bdColor = [];
  	// for ($i=0; $i < count($dataValues); $i++) { 
  		
  	// }
  	return array('dataValueSets'=>$responses);
  }
}
