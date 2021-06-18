<?php

/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/19/17
 * Time: 7:12 PM
 */
namespace Stanford\GoProd;
use \REDCap as REDCap;
include_once 'messages.php';

 function IsProjectAdmin(){

    // set username of the current user in project
    $this_user = USERID;

    // Get array of user privileges for a single user in project (will have username as array key)
    $rights = REDCap::getUserRights($this_user);

    // If $rights returns NULL, then user does not have access to this project
    if (empty($rights)) exit("User $this_user does NOT have access to this project.");

    // Check if user can create new records
    if ($rights[$this_user]['record_create'] or SUPER_USER==1) {
        //print "User $this_user CAN create records.\n";

        return true;
    } else {
        exit(lang('USER_RIGHTS'));
    }


}

function TextBreak($question_variable){
    global $Proj;
    // Adding : Intrument Name, instrument

    $label1=$Proj->metadata[$question_variable];
    $label1=$label1['element_label'];
    $label1=REDCap::filterHtml ( $label1 );
    $label1 = wordwrap($label1, 30, "<br />");

return $label1;
}

// Find path to redcap_connect.php
function findRedcapConnect()
{
    $dir = __DIR__;
    while ( !file_exists( $dir . "/redcap_connect.php" ) ) {
        if ($dir == dirname($dir)) {
            throw new Exception("Unable to locate redcap_connect.php");
        } else {
            $dir = dirname($dir);
        }
    }
    return $dir . "/redcap_connect.php";
}


function CleanString($string){

    // first preparing the strings.
    //for $string1
    //remove spaces at the end and convert in lowercase
    $word1=trim(strtolower($string));
    //remove spaces between words
    $word1 = str_replace(' ', '_', $word1);
    //remove tabs
    $word1 = preg_replace('/\s+/','_',$word1);
    $word1 = str_replace('__', '_', $word1);

    return $word1;
}



$protocol_number="3326";

function logIt($msg, $level = "INFO") {
//	global $custom_path;
    $custom_path = "/var/log/redcap/alvaro.log";
    file_put_contents( $custom_path,	date( 'Y-m-d H:i:s' ) . "\t" . $level . "\t" . $msg . "\n", FILE_APPEND );
}



//function PrintPencilIcon($link){
//    return '<a href=' . $link . ' target="_blank" ><img src=' . APP_PATH_IMAGES .'pencil.png></a>';
//
//}

/*  Save-load-Update data from external project     */

function LoadAllData($pid){


}





function CheckIfRuleIsActive($Rule,$pid_stats){





}

function projectMode(){
    global $Proj;
    return $Proj->project['status'];
}


//This is used to limit what checklist items are return to an end user
function draftedFields(){
    global $Proj;

    $status = projectMode();
    if($status == "1") {
        $return = array();
        $new_fields = array_diff(array_keys($Proj->metadata_temp), array_keys($Proj->metadata));
        array_walk_recursive($new_fields, function($a) use (&$return) { $return[] = $a; });
        return $return;
    } else {
        return [];
    }
}