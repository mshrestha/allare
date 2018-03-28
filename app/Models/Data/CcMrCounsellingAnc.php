<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class CcMrCounsellingAnc extends Model
{
	protected $table = "cc_mr_counselling_anc";
	protected $fillable = ['value','period','period_name','organisation_unit','category_option_combo'];
}
