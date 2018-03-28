<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class ImciMale extends Model
{
	protected $table = "imci_male";
	protected $fillable = ['value','period','period_name','organisation_unit','category_option_combo'];
}
