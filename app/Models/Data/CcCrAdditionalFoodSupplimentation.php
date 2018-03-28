<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class CcCrAdditionalFoodSupplimentation extends Model
{
	protected $table = "cc_cr_additional_food_supplimentation";
	protected $fillable = [
		'value', 'period', 'period_name', 'organisation_unit', 'category_option_combo', 'import_date',
	];
}
