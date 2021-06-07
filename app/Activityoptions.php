<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activityoptions extends Model
{
    protected $table = "activityoptions";
    protected $casts = [
        'currentSelections'=>'array',
'mainActivities' => 'array',
'subActivities' => 'array',
'scaledOptions' => 'array',
'fixedOptions' => 'array',
'experiments' => 'array',
'suggestions' => 'array',
    ];
}


