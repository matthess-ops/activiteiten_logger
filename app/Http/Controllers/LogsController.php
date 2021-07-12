<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TimerData;
use App\Logs;
use Carbon\Carbon;


class LogsController extends Controller
{


    public function getLogs(Request $request){
        $values = $request->all();
        $timerData = TimerData::find(1);
        error_log("startdate is ".$values['log-start']);
        // $startTimestamp = Carbon::createFromFormat("YYYY-MM-DD", $values['log-start']);
        $startTimestamp= Carbon::parse($values['log-start']);
        $endTimestamp = Carbon::parse($values['log-end']);

        // error_log("kut format ".$startTimestamp->toDateString());

        $logs = Logs::whereDate('start','>=' ,$startTimestamp )->whereDate('end','<=',$endTimestamp)->get("log");
        error_log("nr of logs found ".count($logs));

        $dates = ["startDate"=>$values['log-start'],"endDate"=>$values['log-end']];

        return view('logs',["timerData"=>$timerData,"logss"=>$logs,"datesIn"=>$dates]);     
    
        // $data = $values["suggestion"];

        // $dataJson = json_decode($data,TRUE );
        // // error_log(print_r($dataJson,true) );


        // $timerData =TimerData::find(1);
        // $timerData->currentSelections	= $dataJson;
        // $timerData->save();
        // return redirect('/');

    }



    public function index(){
    //  error_log("dit werkt");
    // $logs = ["beh"=>"thest","bedddh"=>"thddest"];
    $timerData = TimerData::find(1);
    $logs = [];



    $dates = ["startDate"=>"","endDate"=>""];

    return view('logs',["timerData"=>$timerData,"logss"=>$logs,"datesIn"=>$dates]);     }

 
}
