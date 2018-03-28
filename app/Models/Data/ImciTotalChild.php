<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class ImciTotalChild extends Model
{
    //
	protected $table = "imci_total_children";
	protected $fillable = ['value','period','period_name','organisation_unit','category_option_combo'];
}
