<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataElements extends Model
{
    //
	public function datasets() {
		return $this->belongsTo('App\DataSets', 'data_set_id');
	}
}
