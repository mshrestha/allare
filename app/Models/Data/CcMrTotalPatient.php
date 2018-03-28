<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class CcMrTotalPatient extends Model
{
    //
	protected $table = "cc_mr_total_patient";
	protected $fillable = ['value','period','period_name','organisation_unit','category_option_combo'];
}
