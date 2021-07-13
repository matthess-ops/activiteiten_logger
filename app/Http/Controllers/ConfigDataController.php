<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TimerData;

// functions that are associated with CRUD timerData variables

//updates next version
// 1: refactoring
// 2: validate all data and prompt user with alert messages when needed use ->withInput method to do this
// 3: returning view() or redirect distinction. Only use views for get request and redirects for post request.
// 4: rename all the function to better reflect their function
// 5: replace variable whitespace with underscores.
// 6: group all CRUD functions associated  of the mainActivities, subActivites, fixedActivties and scaledActivities
class ConfigDataController extends Controller
{
    //return all TimerData to the view
    public function index()
    {
        $timerData = TimerData::find(1);

        return view('config', $timerData);
    }

    //remove the whole fixed activities group or only one option of the group.
    // for example, the group could Houding with the options ,zitten,staan, liggen zijn.
    // this function can either remove the whole group (Houding) with its options (zitten,staan,liggen)
    // or only one of the options eg (zitten)
    public function removeFixedGroupOrOption(Request $request)
    {

        $formData = $request->all();
        $arrayKeys = array_keys($formData);
        $optionkey = str_replace("_", " ", $arrayKeys[2]);
        $keyToRemove = str_replace("_", " ", $arrayKeys[1]);
        $valueToRemove = str_replace("_", " ", $formData[$arrayKeys[1]]);

        // remove whole group e.g Houding
        $timerData = TimerData::find(1);
        $column = $timerData->fixedOptions;
        if ($optionkey == "Remove Group") {
            unset($column[$keyToRemove]);
            $timerData->fixedOptions = $column;
            $timerData->save();
        }
        //remove group option e.g Zitten
        if ($optionkey == "Remove Option") {
            $keyValues = $column[$keyToRemove];

            //could not use unset here, because unset doenst work with multidimensional stuff.
            $newKeyValues = [];
            foreach ($keyValues as $keyValue) {
                if ($keyValue != $valueToRemove) {
                    array_push($newKeyValues, $keyValue);
                }
            }
            $column[$keyToRemove] =  $newKeyValues;
            $timerData->fixedOptions = $column;
            $timerData->save();
        }


        return redirect()->route('ConfigData.index');
    }

    // store a new scaled activity.
    public function storeScaled(Request $request)
    {

        $formData = $request->all();

        $queryData = array_splice($formData, 1);
        $queryKey = array_keys($queryData)[0];
        $queryValue = $queryData[$queryKey];

        // // error_log("KEY VALUE= ".$queryKey." ".$queryValue);

        if (empty($queryValue)) {
        } else {
            $timerData = TimerData::find(1);
            $scaledOptions = $timerData->scaledOptions;
            array_push($scaledOptions, $queryValue);
            $timerData->scaledOptions = $scaledOptions;
            $timerData->save();
        }
        return redirect()->route('ConfigData.index');
    }
    //save a new fixed activities group and its options
    public function createNewFixed(Request $request)
    {
        $formData = $request->all();
        if (!empty($formData["fixedOptions"])) {
            $fixedGroupName = $formData["fixedOptions"];
            $fixedGroupOptions = array_splice($formData, 2);
            $newGroupOptions = [];
            foreach ($fixedGroupOptions  as $key => $value) {
                if (!empty($value)) {

                    array_push($newGroupOptions, $value);
                }
            }

            $timerData = TimerData::find(1);
            $timerDataFixedOptions = $timerData->fixedOptions;
            $timerDataFixedOptions[$fixedGroupName] = $newGroupOptions;
            $timerData->fixedOptions = $timerDataFixedOptions;
            $timerData->save();
        }

        return redirect()->route('ConfigData.index');
    }

    //remove scaled activity option
    public function removeScaledOption(Request $request)
    {

        $scaledOption = $request->input("scaledOptions");

        if (empty($scaledOption)) { //this should not happen 
            error_log("removeScaledOption empty");
        } else {


            $timerData = TimerData::find(1);
            $scaledVars = $timerData['scaledOptions'];
            $newScaledoptions = [];
            foreach ($scaledVars as $scaledVar) {
                if ($scaledVar != $scaledOption) {
                    array_push($newScaledoptions, $scaledVar);
                }
            }


            $timerData->scaledOptions = $newScaledoptions;
            $timerData->save();
        }

        return redirect()->route('ConfigData.index');
    }

    // store fixed option
    public function storeFixed(Request $request)
    {
        $values = $request->all();
        error_log(json_encode($values));

        $keyValueOfInterest = array_splice($values, 1);
        $key = array_key_first($keyValueOfInterest);
        $value = $keyValueOfInterest[$key];
        $cleanKey = str_replace("_", " ", $key);

        // error_log($key . " " . $value . " " . $cleanKey);



        if (empty($value)) {
            // error_log("storeFixed empty");

        } else {
            $timerData = TimerData::find(1);

            $column = $timerData['fixedOptions'];

            $arrayOfInterest = $column[$cleanKey];

            array_push($arrayOfInterest, $value);

            $column[$cleanKey] = $arrayOfInterest;
            $timerData->fixedOptions = $column;
            $timerData->save();
        }
        return redirect()->route('ConfigData.index');
    }
    // store mainActivites or subActivities option to their appropiate database arrays
    public function store(Request $request)
    {
        error_log("store called");
        $values = $request->all();
        $value = array_splice($values, 1);
        $valueKey = array_keys($value); // this is either mainActivities or subActivites


        if (empty($value[$valueKey[0]])) {
            // error_log("empty");

        } else {
            $timerData = TimerData::find(1);
            $arrayOfInterest = $timerData[$valueKey[0]]; // here the mainActivities/subActivities array of timerData is selected
            array_push($arrayOfInterest, $value[$valueKey[0]]);
            $timerData[$valueKey[0]] = $arrayOfInterest;
            $timerData->save();


        }
        return redirect()->route('ConfigData.index');
    }
}
