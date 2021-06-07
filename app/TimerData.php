<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimerData extends Model
{
    protected $table = "timer_data";
    protected $casts = [
        'currentSelections'=>'array',
'mainActivities' => 'array',
'subActivities' => 'array',
'scaledOptions' => 'array',
'fixedOptions' => 'array',
'experiments' => 'array',
'suggestions' => 'array',
'timerRunning' => 'boolean',
'previousLog' => 'array',
    ];
}
