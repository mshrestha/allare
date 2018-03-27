<?php

namespace App\Http\Controllers\Helper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\CurlHelper;

use App\Model\AncCounselCountry;
use App\Model\AncCounselDivision;

class UpdateDBController extends Controller
{
	use CurlHelper;
    public function updateANCCounsel() {
    	$url = 'https://communitydhis.mohfw.gov.bd/nationalcc/api/26/analytics.json?dimension=dx:WfrGlt9gYxW.YF2ivOyo5jG&dimension=pe:LAST_MONTH;201801;201701;201702;201703;201704;201705;201706;201707;201708;201709;201710;201711;201712;201601;201602;201603;201604;201605;201606;201607;201608;201609;201610;201611;201612;201501;201502;201503;201504;201505;201506;201507;201508;201509;201510;201511;201512;201401;201402;201403;201404;201405;201406;201407;201408;201409;201410;201411;201412;201301;201302;201303;201304;201305;201306;201307;201308;201309;201310;201311;201312;&filter=ou:dNLjKwsVjod&displayProperty=NAME&outputIdScheme=UID';
    	$responses = $this->callUrl($url);
    	$responses = json_decode($responses);
    	$metaData = $responses->metaData->items;
    	// dd($responses);
    	$dataValues = $responses->rows;
    	foreach ($dataValues as $keyrow => $row) {
            $unit = new AncCounselCountry();
            $unit->organization = 'dNLjKwsVjod';
            foreach ($row as $key => $value) {
                // print_r($value); echo '<br />';
                if($key == 0) {
                    $unit->name = $metaData->$value->name;
                }
                else if($key == 1) {
                    $unit->period = $value;
                    $unit->period_name = $metaData->$value->name;
                }
                else if($key == 2) {
                    $unit->value = $value;
                }
            }
            // dd($unit);
            $unit->save();
    	}
    }

    // public function($pe, $ou, $model) {

    // }
}
