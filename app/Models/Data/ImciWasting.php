<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class ImciWasting extends Model
{
    protected $table = "imci_wasting";
    protected $fillable = ['value','period','period_name','organisation_unit','category_option_combo'];
}


