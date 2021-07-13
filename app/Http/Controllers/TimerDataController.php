<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TimerData;
use App\Logs;
use Carbon\Carbon;

//updates next version
// 1: refactoring
// 2: validate all data and prompt user with alert messages when needed use ->withInput method to do this
// 3: returning view() or redirect distinction. Only use views for get request and redirects for post request.
// 4: rename all the function to better reflect their function
// 5: replace variable whitespace with underscores.

class TimerDataController extends Controller
{
    // get the logs of today, needed to create the statics bar graph in dashboard
    private function getTodayLogs()
    {
        $logs = Logs::whereDate('start', Carbon::now())->get("log");
        return $logs;
    }

    // get and update new suggestions in Timer on dashboard page.
    // The logs of the previous 7 days are picked, from these logs the logs 1 hour before and after the current time are selected
    // the options in these logs are then used to update the suggestions column in the timer_data. These logs are selected
    // because the likelyhood that the options of these logs are going to be used in the next log is quite high.
    // 
    public function getNewSuggestions()
    {
        $startDate = Carbon::now()->subDays(7);
        $endDate = Carbon::now();
        $previousWeekLogs = Logs::whereBetween('start', [$startDate, $endDate])->get();
        $startHours=   Carbon::now()->subHours(1)->hour;
        $endHours=   Carbon::now()->addHours(1)->hour;
        $logsCurrentTime = [];
        foreach ($previousWeekLogs as $entry) {
            $carbonStart = Carbon::parse($entry["start"])->hour;
            $carbonEnd = Carbon::parse($entry["end"])->hour;
            $newEntry = $entry["log"];
            unset($newEntry["startTimestamp"]);
            unset($newEntry["endTimestamp"]);

            if($carbonStart>$startHours && $carbonEnd<$endHours){
            
                array_push($logsCurrentTime, $newEntry);  

            }

           
        }
        // error_log("starhours ".$startHours."end hours ".$endHours );
        // error_log("previous week logs ".count($previousWeekLogs));
        // error_log("current 2 hours logs ".count($logsCurrentTime));
        // error_log(json_encode($logsCurrentTime));
        $newSuggestions = array_slice($logsCurrentTime, 0, 7); // 7 are the number of logs that are going to be used as suggestions
        $timerData = TimerData::find(1);
        $timerData->suggestions    = $newSuggestions;
        $timerData->save();


    }

    // this the main get function.
    // 1: make from all the data outputs seperate functions.
    public function readTimerData()
    {
        $this->getNewSuggestions();
        $todayLogs = $this->getTodayLogs();
        $timerData = TimerData::find(1);
        $startTime = "empty";

        if (!empty($timerData['previousLog'])) {
            $startTime = $timerData['previousLog'];
        }
        $timerData["todayLogs"] = $todayLogs; // dirty hack to get the todaylog into the view, see below for solution
        //Next time put all the different data sources in one dictionary before passing it to the view.
        //this makes it alot easier to add other data sources when needed.
        return view('newview', $timerData, $startTime); 
    }

    //update the the current selected options with the entered selections
    public function updateSelection(Request $request)
    {
        $values = $request->all();

        $data = $values["suggestion"];

        $dataJson = json_decode($data, TRUE);


        $timerData = TimerData::find(1);
        $timerData->currentSelections    = $dataJson;
        $timerData->save();
        return redirect('/');
    }


  

    //If the timer is running and the stop button is pressed, the previouslog 
    //in the database is retrieved and updated with the end and start time. If the
    //timer is not running the selected values are saved as previouslog.

    //1: Replace all white spaces in variables with underscore. 
    public function startTimer(Request $request)
    {
        $data = $request->all();
        $values = array_splice($data, 1);

        $newarray = [];
        foreach ($values as $key => $value) {
            $withoutUnderscore = str_replace("_", " ", $key);
            $newarray[$withoutUnderscore] = $value;
        }


        $timerData = TimerData::find(1);
        $timerData->currentSelections    = $newarray;
        $timerData->save();

        //to create previouslog add to $newa
        if ($timerData->timerRunning == true) {
            // create a new log because timer is running and switch timerRunning  var to False
            $timerData->timerRunning    =  false;
            $timerData->save();

            $timerData = TimerData::find(1);
            $newLog = $timerData->previousLog;
            $newLog["endTimestamp"] = Carbon::now()->timestamp;
            $log = new Logs();
            $log->log = $newLog;
            $log->end = Carbon::now();
            $log->start = Carbon::createFromTimestamp($newLog["startTimestamp"]);
            $log->save();
        } else {
            //  timer is not running therefore save the posted data as previouslog, also update timerRunning to True
            $previouslog = $newarray;
            $previouslog["startTimestamp"] =  Carbon::now()->timestamp;
            $timerData = TimerData::find(1);
            $timerData->previousLog    =  $previouslog;
            $timerData->timerRunning    =  true;
            $timerData->save();
        }

        return redirect('/');
    }
}
