<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class CcCrAdditionalFoodSupplimentation extends Model
{
	protected $table = "cc_cr_additional_food_supplimentation";
	protected $fillable = [
		'value', 'period', 'period_name', 'organisation_unit', 'category_option_combo', 'import_date',
	];

	public function categoryOptionCombo() {
		return $this->belongsTo('App\Models\CategoryOptionCombo', 'category_option_combo', 'api_id');
	}

	public function organisationUnitCentral() {
		return $this->belongsTo('App\Models\OrganisationUnit', 'organisation_unit', 'central_api_id');
	}

	public function organisationUnitCommunity() {
		return $this->belongsTo('App\Models\OrganisationUnit', 'organisation_unit', 'community_api_id');
	}
}
