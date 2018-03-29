<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class ImciStuntingPercent extends Model
{
    //
	protected $table = "imci_stunting_percent";
	protected $fillable = ['value','period','period_name','organisation_unit','category_option_combo'];
}
