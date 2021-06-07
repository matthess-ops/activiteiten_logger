<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\Activityoptions;


class DataController extends Controller
{
    public function store(){
        error_log("wat is er loos");

        $data = request('suggestion');
        $dataDecoded = str_replace("-"," ",$data); 

        $dataJson = json_decode($dataDecoded,TRUE );
        error_log(print_r($dataJson));


        $activityOption= Activityoptions::find(1);
        $activityOption->currentSelections	= $dataJson;
        $activityOption->save();



        return redirect('/');
    }

    public function storeTest(Request $request){
        $values = $request->all();
        var_dump($values);

    }

    public function storeNewSelection(Request $request){
        $values = $request->all();
        $newSelections;
        foreach ($values as $key => $value) {
            $replaceValue = str_replace("-"," ","tering") ;
            $newSelections[str_replace("-"," ",$key)] = str_replace("-"," ",$value);
        }
      
        var_dump($values);
    
        // return "kak";

     

    }

    public function readData(){
   
        $data =[
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
    
            "test"=>["aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaspjodfjfffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklklkluuuuuuuuuuuuuuuuuuuuuuuuuuuuasdf"],
    
            "test2" => [
                "foo" => "bar",
                "bar" => "foo",
            ],
    
    
        ];
        $activityOption= Activityoptions::find(1);
        if ($activityOption == null) {
            error_log("");

        } else {
            $selectedOption = $activityOption->currentSelections;
            $data["currentSelections"] = $activityOption->currentSelections;
            $data['mainActivities'] = $activityOption->mainActivities;
            $data['subActivities'] = $activityOption->subActivities;
            $data['scaledOptions'] = $activityOption->scaledOptions;
            $data['fixedOptions'] = $activityOption->fixedOptions;
            $data['experiments'] = $activityOption->experiments;
            $data['suggestions'] = $activityOption->suggestions;

        }
        
    
    
        

        return view('testboostrap',$data );


    }


}
