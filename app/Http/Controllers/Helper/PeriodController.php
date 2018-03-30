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
    
  	return $periods['periods'];

}