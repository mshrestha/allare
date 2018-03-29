<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class CcCrExclusiveBreastFeeding extends Model
{
    //
	
	protected $table = "cc_cr_exclusive_breast_feeding";
	protected $fillable = ['value','period','period_name','organisation_unit','category_option_combo'];
}
