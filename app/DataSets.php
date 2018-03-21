<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DataElements;
class DataSets extends Model
{
    //
	public function dataelements() {
		return $this->hasMany('App\DataElements', 'data_set_id');
	}
}
