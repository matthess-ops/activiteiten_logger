<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TimerData;


class ConfigDataController extends Controller
{
    public function index(){
        $timerData =TimerData::find(1);

        return view('config',$timerData);
    }

    public function removeFixedGroupOrOption(Request $request){
        error_log("removeFixedGroupOrOption called");

        $formData = $request->all();
        error_log(print_r( $formData,true));

        $fixedGroup = array_keys($formData);


        $fixedGroupValue = $formData[$fixedGroup[1]];
        error_log("key value =".$fixedGroup[1]." ".$fixedGroupValue);

        $timerData = TimerData::find(1);
        $column = $timerData->fixedOptions;

        error_log(print_r( $column,true));

    
        if(array_key_exists("Remove_Group",$formData) == true){
            // error_log("removeFixedGroupOrOption Remove_group key pressed");
            unset($column[$fixedGroup[1]]);

            $timerData->fixedOptions = $column;
            $timerData->save();
        }


        if(array_key_exists("Remove_Option",$formData) == true){
            // error_log("removeFixedGroupOrOption Remove_option key pressed");
            $newValues =array();
            // str replace is een rotzooi dit komt omdat de keys een underscore krijgen
            // tijdens een post request, voortaan variabelen gebruiken die een underscore hebben
            //voortaan alle keys met underscore doen en dan in frontend str_replace doen
            foreach ($column[str_replace("_"," ",$fixedGroup[1])] as $option) {
                if($option !=$fixedGroupValue){
                    array_push($newValues,$option);
                }
            }
            
            $column[str_replace("_"," ",$fixedGroup[1])]= $newValues;
            error_log(print_r( $column,true));




            $timerData->fixedOptions = $column;
            $timerData->save();
        }


        return redirect()->route('ConfigData.index');


    }

    public function storeScaled(Request $request){
        error_log("storeScaled called");

        $formData = $request->all();
      
        $queryData =array_splice($formData,1) ;
        $queryKey = array_keys($queryData)[0];
        $queryValue = $queryData[$queryKey];

        error_log("KEY VALUE= ".$queryKey." ".$queryValue);


        if(empty($queryValue) ){
            error_log("storeScaled value empty");

        }else{
            error_log("storeFixed value not empty");
            $timerData =TimerData::find(1);
            $scaledOptions =$timerData->scaledOptions;
            array_push($scaledOptions,$queryValue);
            $timerData->scaledOptions =$scaledOptions;
            $timerData->save();


        }
        return redirect()->route('ConfigData.index');

    }

    public function createNewFixed(Request $request){
        $formData = $request->all();
        if(!empty($formData["fixedOptions"])){
            $fixedGroupName = $formData["fixedOptions"];
            $fixedGroupOptions =array_splice($formData,2);
            $newGroupOptions = [];
            foreach ($fixedGroupOptions  as $key => $value) {
                if(!empty($value)){

                    array_push($newGroupOptions,$value);
                }
            }

            error_log(print_r( $newGroupOptions,true));
            $timerData =TimerData::find(1);
            $timerDataFixedOptions = $timerData->fixedOptions;
            $timerDataFixedOptions[$fixedGroupName] =$newGroupOptions;
            $timerData->fixedOptions = $timerDataFixedOptions;
            $timerData->save();

            
        }
    






        
        return redirect()->route('ConfigData.index');


    }


    public function removeScaledOption(Request $request){

        $scaledOption = $request->input("scaledOptions");
      


  
       
        if(empty($scaledOption )){
            error_log("removeScaledOption empty");

        }else{
            error_log("removeScaledOption is not empty");
            error_log($scaledOption);

            $timerData =TimerData::find(1);
            $column = $timerData['scaledOptions'];

            unset($column[array_search($scaledOption, $column)]);
            error_log(print_r($column ,true));

            $timerData->scaledOptions = $column;
            $timerData->save();


        }

        return redirect()->route('ConfigData.index');


    }

    public function storeFixed(Request $request){
        $values = $request->all();
        // error_log(print_r( $values,true));
       

        error_log("values are");
        error_log(print_r($values ,true));

        $value = array_splice($values,1) ;
        $valueKey = array_keys($value);
     

        if(empty($value[$valueKey[0]] )){
            error_log("storeFixed empty");

        }else{
            error_log("storeFixed not empty".$valueKey[0]);
            $timerData =TimerData::find(1);
            $cleanNewKey = str_replace("_"," ",$valueKey[0]);

            $column = $timerData['fixedOptions'];
            error_log("lefuckddddddddddddddddd");
            error_log(print_r($column ,true));
            error_log(str_replace($valueKey[0],"_"," "));
            $arrayOfInterest = $column[$cleanNewKey];

            array_push($arrayOfInterest,$value[$valueKey[0]]);

            $column[$valueKey[0]] = $arrayOfInterest;
            $timerData->fixedOptions = $column;
            $timerData->save();


        }
        error_log($value[$valueKey[0]] );
        return redirect()->route('ConfigData.index');


    }

    public function store(Request $request){
        error_log("het doet");
        $values = $request->all();
        $value = array_splice($values,1) ;
        $valueKey = array_keys($value);

        
        if(empty($value[$valueKey[0]] )){
            error_log("empty");

        }else{
            error_log("not empty");
            $timerData =TimerData::find(1);
            $arrayOfInterest = $timerData[$valueKey[0]];
            array_push($arrayOfInterest,$value[$valueKey[0]]);
            $timerData[$valueKey[0]] = $arrayOfInterest;
            $timerData->save();
            error_log(print_r( $arrayOfInterest,true));


        }
        error_log($value[$valueKey[0]] );
        return redirect()->route('ConfigData.index');

    }
}
