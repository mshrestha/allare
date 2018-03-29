<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class ImciExclusiveBreastFeeding extends Model
{
    //
	protected $table = "imci_exclusice_breast_feeding";
    protected $fillable = ['value','period','period_name','organisation_unit','category_option_combo'];
}
