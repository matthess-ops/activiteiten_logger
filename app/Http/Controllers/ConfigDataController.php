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
        error_log(\json_encode($formData));
        $arrayKeys = array_keys($formData);
        $optionkey =str_replace("_"," ",$arrayKeys[2]) ;
        $keyToRemove = str_replace("_"," ",$arrayKeys[1]);
        $valueToRemove = str_replace("_"," ",$formData[$arrayKeys[1]]);
        error_log("which option=".$optionkey."/ key to remove =".$keyToRemove."/ option to remove =".$valueToRemove );

        $timerData = TimerData::find(1);
        $column = $timerData->fixedOptions;
        if($optionkey == "Remove Group"){
            error_log("remove group ".$keyToRemove);
            unset($column[$keyToRemove]);
            $timerData->fixedOptions = $column;
            $timerData->save();


        }
        if($optionkey == "Remove Option"){
            error_log("remove value ".$optionkey);
            $keyValues = $column[$keyToRemove];
            
            $newKeyValues = [];
            foreach ($keyValues as $keyValue) {
                if($keyValue != $valueToRemove){
                    array_push($newKeyValues,$keyValue);
                }
            }

            error_log(\json_encode($newKeyValues ));
            $column[$keyToRemove] =  $newKeyValues;
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

        // // error_log("KEY VALUE= ".$queryKey." ".$queryValue);


        if(empty($queryValue) ){

        }else{
            $timerData =TimerData::find(1);
            $scaledOptions =$timerData->scaledOptions;
            array_push($scaledOptions,$queryValue);
            $timerData->scaledOptions =$scaledOptions;
            $timerData->save();


        }
        return redirect()->route('ConfigData.index');

    }

    public function createNewFixed(Request $request){
        error_log("createNewFixed called");
        $formData = $request->all();
        // // error_log("create new fixed ",json_encode($formData));
        if(!empty($formData["fixedOptions"])){
            $fixedGroupName = $formData["fixedOptions"];
            $fixedGroupOptions =array_splice($formData,2);
            $newGroupOptions = [];
            foreach ($fixedGroupOptions  as $key => $value) {
                if(!empty($value)){

                    array_push($newGroupOptions,$value);
                }
            }

            // // error_log(print_r( $newGroupOptions,true));
            $timerData =TimerData::find(1);
            $timerDataFixedOptions = $timerData->fixedOptions;
            $timerDataFixedOptions[$fixedGroupName] =$newGroupOptions;
            $timerData->fixedOptions = $timerDataFixedOptions;
            $timerData->save();

            
        }
    






        
        return redirect()->route('ConfigData.index');


    }


    public function removeScaledOption(Request $request){
        error_log("removeScaledOption called");

        $scaledOption = $request->input("scaledOptions");
      
        if(empty($scaledOption )){
            // error_log("removeScaledOption empty");

        }else{
            // error_log("removeScaledOption is not empty");
            // error_log($scaledOption);

            $timerData =TimerData::find(1);
            $scaledVars = $timerData['scaledOptions'];
            $newScaledoptions = [];
           foreach ($scaledVars as $scaledVar) {
               if($scaledVar !=$scaledOption){
                array_push($newScaledoptions,$scaledVar);
               }
           }
            // error_log("old scaled vars ".json_encode($scaledVars));
            // error_log("new scaled vars ".json_encode($newScaledoptions));

            // unset($column[array_search($scaledOption, $column)]);

            $timerData->scaledOptions = $newScaledoptions;
            $timerData->save();


        }

        return redirect()->route('ConfigData.index');


    }

    public function storeFixed(Request $request){
        error_log("storeFixed called");
        $values = $request->all();
        error_log(json_encode($values));
       

        // error_log("values are");
        // error_log(print_r($values ,true));

        $keyValueOfInterest = array_splice($values,1);
        $key = array_key_first($keyValueOfInterest);
        $value = $keyValueOfInterest[$key];
        $cleanKey = str_replace("_"," ",$key);

        error_log($key." ".$value." ".$cleanKey);

     

        if(empty($value)){
            // error_log("storeFixed empty");

        }else{
            // error_log("storeFixed not empty".$valueKey[0]);
            $timerData =TimerData::find(1);

            $column = $timerData['fixedOptions'];
         
            $arrayOfInterest = $column[$cleanKey];

            array_push($arrayOfInterest,$value);

            $column[$cleanKey] = $arrayOfInterest;
            $timerData->fixedOptions = $column;
            $timerData->save();


        }
        // error_log($value[$valueKey[0]] );
        return redirect()->route('ConfigData.index');


    }

    public function store(Request $request){
        error_log("store called");
        $values = $request->all();
        $value = array_splice($values,1) ;
        $valueKey = array_keys($value);

        
        if(empty($value[$valueKey[0]] )){
            // error_log("empty");

        }else{
            // error_log("not empty");
            $timerData =TimerData::find(1);
            $arrayOfInterest = $timerData[$valueKey[0]];
            array_push($arrayOfInterest,$value[$valueKey[0]]);
            $timerData[$valueKey[0]] = $arrayOfInterest;
            $timerData->save();
            // error_log(print_r( $arrayOfInterest,true));


        }
        // error_log($value[$valueKey[0]] );
        return redirect()->route('ConfigData.index');

    }
}
