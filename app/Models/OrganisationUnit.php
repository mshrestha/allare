<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganisationUnit extends Model
{
    protected $fillable = [
    	'central_api_id', 'community_api_id', 'name', 'level', 'source'
    ];
}
