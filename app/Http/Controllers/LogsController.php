<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TimerData;
use App\Logs;
use Carbon\Carbon;

// all functions responsible for selecting logs
//updates next version
// 1: refactoring
// 2: validate all data and prompt user with alert messages when needed use ->withInput method to do this
// 3: returning view() or redirect distinction. Only use views for get request and redirects for post request.
// 4: rename all the function to better reflect their function
// 5: replace variable whitespace with underscores.


class LogsController extends Controller
{

    // get all posts between posted start and end date and return date.
    public function getLogs(Request $request){
        $values = $request->all();
        $timerData = TimerData::find(1);
        $startTimestamp= Carbon::parse($values['log-start']);
        $endTimestamp = Carbon::parse($values['log-end']);
        $logs = Logs::whereDate('start','>=' ,$startTimestamp )->whereDate('end','<=',$endTimestamp)->get("log");
        $dates = ["startDate"=>$values['log-start'],"endDate"=>$values['log-end']];
        return view('logs',["timerData"=>$timerData,"logss"=>$logs,"datesIn"=>$dates]);     
    
    }


    // 1: change the associated blade so that it doesnt require the empty var.
    public function index(){
    $timerData = TimerData::find(1);
    $logs = [];

    $dates = ["startDate"=>"","endDate"=>""];

    return view('logs',["timerData"=>$timerData,"logss"=>$logs,"datesIn"=>$dates]);     }

 
}
