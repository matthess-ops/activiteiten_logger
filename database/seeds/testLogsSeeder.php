<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Logs;

class testLogsSeeder extends Seeder
{

    private $data =[
        'mainActivities'=> ["werken","rusten","huishouden","verzorging","ontspanning"],
        'subActivities'=> ["programmeren","lezen","onderzoek","afwassen","koken","douchen","film kijken"],
        'scaledOptions'=>["pijn level","geluk level"],
        'fixedOptions' => [
            "pijnstillers"=>["ibruprofen","temgesic","paracetamol"],
            "houding" => ["zitten","liggen","bank"],
        ],
        "experiments"=>["2 uur per dag werken","elke dag lopen"],
        "currentSelections"=>[
            "mainActivities"=>"rusten",
            'subActivities'=> "lezen",
            "pijn level" => "4",
            "geluk level" =>"9",
            "pijnstillers"=>"temgesic",
            "houding" => "liggen",
            "experiments"=>"elke dag lopen",
        ],

        "suggestions"=>[
        [
            "mainActivities"=>"huishouden",
            'subActivities'=> "lezen",
            "pijn level" => "4",
            "geluk level" =>"2",
            "pijnstillers"=>"temgesic",
            "houding" => "liggen",
            "experiments"=>"elke dag lopen"
        ],
        [
            "mainActivities"=>"werken",
            'subActivities'=> "lezen",
            "pijn level" => "1",
            "geluk level" =>"1",
            "pijnstillers"=>"ibruprofen",
            "houding" => "liggen",
            "experiments"=>"elke dag lopen"
        ],
        [
            "mainActivities"=>"ontspanning",
            'subActivities'=> "lezen",
            "pijn level" => "4",
            "geluk level" =>"2",
            "pijnstillers"=>"ibruprofen",
            "houding" => "liggen",
            "experiments"=>"elke dag lopen"
        ],
        [
            "mainActivities"=>"rusten",
            'subActivities'=> "lezen",
            "pijn level" => "10",
            "geluk level" =>"1",
            "pijnstillers"=>"ibruprofen",
            "houding" => "liggen",
            "experiments"=>"elke dag lopen"
        ],
     



    ],




    ];


    private function getRandomValueArray($inputArray){

        return $inputArray[array_rand($inputArray, 1)];   
    }

    private function saveLog($logArray){

        $log = new Logs();
        $log->log = $logArray;
        $log->end = Carbon::createFromTimestamp($logArray["endTimestamp"]);
        $log->start = Carbon::createFromTimestamp($logArray["startTimestamp"]);
        $log->save();
    }

    private function createLog($startTimestamp,$endTimestamp){
                // {"mainActivities":"rusten","subActivities":"lezen",
                    // "experiments":"elke dag lopen","pijn level":"4",
                    // "geluk level":"9","pijnstillers":"temgesic","houding":"liggen",
                    // "startTimestamp":1623153504,"endTimestamp":1623153510}

        $log = [];
    

        $log["mainActivities"] = $this->getRandomValueArray($this->data["mainActivities"]);
        $log["subActivities"] = $this->getRandomValueArray($this->data["subActivities"]);
     
        $log["experiments"] =  $this->getRandomValueArray($this->data["experiments"]);


        foreach ($this->data["scaledOptions"] as $value) {
            $log[$value] =rand(0,10);
        }

      

        foreach ($this->data["fixedOptions"] as $key => $value) {
            $log[$key] =$this->getRandomValueArray($value);
        }

        $log["startTimestamp"] = $startTimestamp;
        $log["endTimestamp"] = $endTimestamp;

        $this->saveLog($log);

    }


    public function run()
    {
        $startTimestamp;
        $currentTimestamp;

        $startTimestamp = Carbon::now()->timestamp;
        $currentTimestamp =  $startTimestamp;

        for ($log=0; $log < 500; $log++) { 
            $randomLogTimeMin = rand(5,10);
            $logStartTimestamp = $currentTimestamp;
            $logEndTimestamp =  $currentTimestamp+($randomLogTimeMin*60);
            // error_log("start ". $currentTimestamp." end ".$logEndTimestamp." diff ".($logEndTimestamp-$currentTimestamp)/60);

            $currentTimestamp = $logEndTimestamp;

            $this->createLog($logStartTimestamp,$logEndTimestamp);
        }


     



    }

    }

