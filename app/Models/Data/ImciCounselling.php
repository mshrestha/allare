<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class ImciCounselling extends Model
{
	protected $table = "imci_counselling";
	protected $fillable = ['value','period','period_name','organisation_unit','category_option_combo'];
}
