<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class CcMrAncIfaDistribution extends Model
{
    protected $table = "cc_mr_anc_ifa_distribution";
    protected $fillable = ['value','period','period_name','organisation_unit','category_option_combo'];
}
