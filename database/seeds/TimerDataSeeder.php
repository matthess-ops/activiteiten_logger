<?php

use Illuminate\Database\Seeder;

class TimerDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {
 
         $data =[
             'timerRunning'=>False,
             'previousLog'=>[
                "mainActivities"=>"rusten",
                'subActivities'=> "lezen",
                "pijn level" => "4",
                "geluk level" =>"9",
                "pijnstillers"=>"temgesic",
                "houding" => "liggen",
                "experiments"=>"elke dag lopen",
                "startTimestamp"=>1622543389,
            ],
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
 
   
         $currentSelections = json_encode($data['currentSelections'],true);
         $mainActivities = json_encode($data['mainActivities'],true);
         $subActivities = json_encode($data['subActivities'],true);
         $scaledOptions = json_encode($data['scaledOptions'],true);
         $fixedOptions = json_encode($data['fixedOptions'],true);
         $experiments = json_encode($data['experiments'],true);
         $suggestions = json_encode($data['suggestions'],true);
         $previousLog = json_encode($data['previousLog'],true);
         $timerRunning = $data['timerRunning'];

 
         error_log("test seeder runned");
         DB::table('timer_data')->insert([
             'currentSelections'=>$currentSelections,
             'mainActivities' => $mainActivities,
             'subActivities' => $subActivities,
             'scaledOptions' => $scaledOptions,
             'fixedOptions' => $fixedOptions,
             'experiments' => $experiments,
             'suggestions' => $suggestions,
             'previousLog'=>$previousLog,
             'timerRunning'=> $timerRunning,
 
         ]);
     }
 }
 
 

