<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class CcMrWeightInKgAnc extends Model
{
	protected $table = "cc_mr_weight_in_kg_anc";
	protected $fillable = ['value','period','period_name','organisation_unit','category_option_combo'];
}
