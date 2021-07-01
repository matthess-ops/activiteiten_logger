<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TimerData;
use App\Logs;
use Carbon\Carbon;

class TimerDataController extends Controller
{
    private function getTodayLogs(){
        $logs = Logs::whereDate('start', Carbon::now())->get("log");
        return $logs;
      

    }


    public function readTimerData(){
      $todayLogs = $this-> getTodayLogs();
      $timerData = TimerData::find(1);
      $kakos = ["fack"=>"beh","kek"=>"beh","kak"=>"beh"];

      $startTime = "empty";
      
      if(!empty($timerData['previousLog'])){
          $startTime =$timerData['previousLog'];

      }
      $timerData["todayLogs"] = $todayLogs;
      //volgende keer eerste alle vars in dictionary stoppen voo retrun
      return view('newview',$timerData,$startTime); //$timerData,$startTime,$test
    }

    public function updateSelection(Request $request){
        $values = $request->all();
    
        $data = $values["suggestion"];

        $dataJson = json_decode($data,TRUE );
        // error_log(print_r($dataJson,true) );


        $timerData =TimerData::find(1);
        $timerData->currentSelections	= $dataJson;
        $timerData->save();
        return redirect('/');

    }


    public function createLog(){


    }


    public function startTimer(Request $request){
        error_log("start timer values are");
        $data = $request->all();
        $values = array_splice($data , 1);

        $newarray = [];
        foreach ($values as $key => $value) {
            $withoutUnderscore = str_replace("_"," ",$key);
            $newarray[$withoutUnderscore] = $value;
        }


        $timerData =TimerData::find(1);
        $timerData->currentSelections	= $newarray;
        $timerData->save();

        //to create previouslog add to $newa
        if($timerData->timerRunning == true){
            error_log("timer is running");
            // should create a log because timer should not be running
            $timerData->timerRunning	=  false;
            $timerData->save();

            $timerData =TimerData::find(1);
            $newLog = $timerData->previousLog;
            $newLog["endTimestamp"] = Carbon::now()->timestamp;
            $log = new Logs();
            $log->log = $newLog;
            $log->end = Carbon::now();
            $log->start = Carbon::createFromTimestamp($newLog["startTimestamp"]);
            $log->save();


        }else{
            error_log("timer is not running");

            $previouslog = $newarray;
            $previouslog["startTimestamp"] =  Carbon::now()->timestamp;
            $timerData =TimerData::find(1);
            $timerData->previousLog	=  $previouslog;
                        $timerData->timerRunning	=  true;

            error_log(print_r($previouslog,true) );
            $timerData->save();


    


        }

  

        







        return redirect('/');


    }
}
