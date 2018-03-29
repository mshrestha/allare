<?php

namespace App\Http\Controllers\Helper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Traits\CurlHelper;
use App\Traits\PeriodHelper;

class PeriodController extends Controller
{
	use CurlHelper, PeriodHelper;

  public function getPeriodsMonthly() {
    $periods = $this->getPeriods();
    $periods = $periods['periods'];
    $periodArr = [];
    foreach ($periods as $key => $value) {
    	$periodArr[$key] = '';
    	for ($i=0; $i < count($periods[$key]); $i++) { 
    		$periodArr[$key] .= $periods[$key][$i].';';
    	}
    	$periodArr[$key] = rtrim($periodArr[$key], ';');
    }
    return $periodArr;
  }

}