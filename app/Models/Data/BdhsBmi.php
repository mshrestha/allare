<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class BdhsBmi extends Model
{
  protected $table = "bdhs_bmis";
	protected $fillable = [
		'value', 'period', 'period_name', 'organisation_unit', 'category_option_combo', 'import_date',
	];

	public function categoryOptionCombo() {
		return $this->belongsTo('App\Models\CategoryOptionCombo', 'category_option_combo', 'api_id');
	}

	public function organisationUnit() {
		return $this->belongsTo('App\Models\OrganisationUnit', 'organisation_unit', 'api_id');
	}
}