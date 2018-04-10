<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class GeoJson extends Model
{
    //
	protected $table = "geo_json";
	protected $fillable = ['code','organisation_unit','coordinates','import_date','server','source'];

	public function organisationUnit() {
		return $this->belongsTo('App\Models\OrganisationUnit', 'organisation_unit', 'api_id');
	}
}
