<?php
/*
    Plugin Name: State and Zip Field Modifier (works only with Gravity Forms)
    Plugin URI: http://www.seoserpent.com/wordpress/gravity-forms-zip-codes-state-abbreviations
    Description: Plugin for altering gForms state data
    Author: Marty Martin
    Version: 1.1
    Author URI: http://seoserpent.com/
	Credits: Original code credits goes to Matthew Connerton.  I modified his original function and added a new function to trim the zip code as well.
*/  

add_action("gform_pre_submission", "pre_submission_state_handler");

function pre_submission_state_handler($form_meta){
  foreach($form_meta["fields"] as $field){
    if($field['type'] == "address"){
       foreach($field["inputs"] as $input){
          if($input['label'] == "State / Province"){
            $value = $_POST["input_" . str_replace('.', '_', $input["id"])];
            $_POST["input_" . str_replace('.', '_', $input["id"])] = shortenState($value);
          }
		  // Added by Marty Martin
		  if($input['label'] == "Zip / Postal Code"){
            $value = $_POST["input_" . str_replace('.', '_', $input["id"])];
            $_POST["input_" . str_replace('.', '_', $input["id"])] = shortenZip($value);
          }
      }
    }
  }
}

function shortenState($state){
    if(strlen($state) == 2){
      $newState = $state;
    }else{
      $state = ucwords(strtolower($state));
      switch($state){
        case "District of Columbia":
          $newState = "DC";
          break;
        case "Alaska":
          $newState = "AK";
          break;
        case "Alabama":
          $newState = "AL";
          break;
        case "Arkansas":
          $newState = "AR";
          break;
        case "Arizona":
          $newState = "AZ";
          break;
        case "California":
          $newState = "CA";
          break;
        case "Colorado":
          $newState = "CO";
          break;
        case "Connecticut":
          $newState = "CT";
          break;
        case "Delaware":
          $newState = "DE";
          break;
        case "Florida":
          $newState = "FL";
          break;
        case "Georgia":
          $newState = "GA";
          break;
        case "Hawaii":
          $newState = "HI";
          break;
        case "Iowa":
          $newState = "IA";
          break;
        case "Idaho":
          $newState = "ID";
          break;
        case "Illinois":
          $newState = "IL";
          break;
        case "Indiana":
          $newState = "IN";
          break;
        case "Kansas":
          $newState = "KS";
          break;
        case "Kentucky":
          $newState = "KY";
          break;
        case "Louisiana":
          $newState = "LA";
          break;
        case "Massachusetts":
          $newState = "MA";
          break;
        case "Maryland":
          $newState = "MD";
          break;
        case "Maine":
          $newState = "ME";
          break;
        case "Michigan":
          $newState = "MI";
          break;
        case "Minnesota":
          $newState = "MN";
          break;
        case "Missouri":
          $newState = "MO";
          break;
        case "Mississippi":
          $newState = "MS";
          break;
        case "Montana":
          $newState = "MT";
          break;
        case "North Carolina":
          $newState = "NC";
          break;
        case "North Dakota":
          $newState = "ND";
          break;
        case "Nebraska":
          $newState = "NE";
          break;
        case "New Hampshire":
          $newState = "NH";
          break;
        case "New Jersey":
          $newState = "NJ";
          break;
        case "New Mexico":
          $newState = "NM";
          break;
        case "Nevada":
          $newState = "NV";
          break;
        case "New York":
          $newState = "NY";
          break;
        case "Ohio":
          $newState = "OH";
          break;
        case "Oklahoma":
          $newState = "OK";
          break;
        case "Oregon":
          $newState = "OR";
          break;
        case "Pennsylvania":
          $newState = "PA";
          break;
        case "Rhode Island":
          $newState = "RI";
          break;
        case "South Carolina":
          $newState = "SC";
          break;
        case "South Dakota":
          $newState = "SD";
          break;
        case "Tennessee":
          $newState = "TN";
          break;
        case "Texas":
          $newState = "TX";
          break;
        case "Utah":
          $newState = "UT";
          break;
        case "Virginia":
          $newState = "VA";
          break;
        case "Vermont":
          $newState = "VT";
          break;
        case "Washington":
          $newState = "WA";
          break;
        case "Wisconsin":
          $newState = "WI";
          break;
        case "West Virginia":
          $newState = "WV";
          break;
        case "Wyoming":
          $newState = "WY";
          break;
      }
    }
    return $newState;
  }

// Added by Marty Martin
function shortenZip($zip) {
	if(strlen($zip) == 5){
		$newZip = $zip;
	} else {
		$newZip = substr($zip,0,5);
	}
	return $newZip;
}
?>