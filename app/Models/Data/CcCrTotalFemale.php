<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class CcCrTotalFemale extends Model
{
    //
	protected $table = "cc_cr_total_female";
	protected $fillable = ['value','period','period_name','organisation_unit','category_option_combo'];
}
