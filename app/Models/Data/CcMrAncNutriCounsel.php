<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class CcMrAncNutriCounsel extends Model
{
	protected $table = "cc_mr_anc_nutri_counsel";
	protected $fillable = ['value','period','period_name','organisation_unit','category_option_combo'];
}
