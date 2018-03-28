<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class ImciFemale extends Model
{
	protected $table = "imci_female";
	protected $fillable = ['value','period','period_name','organisation_unit','category_option_combo'];
}
