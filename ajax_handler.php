<?php
/**
 * Created by Alvaro Alvarez.
 * User: alvaro1
 * Date: 3/7/18
 * Time: 5:48 PM
 *
 * This file is executed/called by the javascript file js/ajax_calls.js and depending on the $_GET string used to call it,it will return:
    1. The list of Active Rules or
    2. Execute and print the requested rule
 *
 */

 namespace Stanford\GoProd;

/** @var \Stanford\GoProd\GoProd $module */
include_once "classes/utilities.php";
include_once  'classes/ReadWriteLogging.php';

//$PathRulesFolder="rules/"; //folder with all rules is called in the code by using $GLOBALS['PathRulesFolder']



/**************************************************************************************
This code prevents multiple calls of the same rule using $_GET['i'] as a flag
 * in order to show the results on the #ResultsModal  and exit to avoid re run the rules
***************************************************************************************/


$current_url = $_SERVER['REQUEST_URI'];
$base = $current_url;
$new_base_url = $base . "&";

if (isset($_GET['i'])) {
    $page = rawurldecode( $_GET['i'] );
    $base = dirname(__FILE__);
    $file = $base.DS.$page;
    if (file_exists($file)) {
        error_log("About to inc $file");
        include_once $file;
    } else {
        error_log("$file does not exist");
    }
    exit(); //to avoid loading again all rules
}

 /*******************************************************************************************************
 HERE IS THE MAIN CALL if $_GET['rule']= GetListOfActiveRules  then return the list of active rules
 in any other case run the given rule  CallRule($function_name);
 ********************************************************************************************************/

$function_name = $_GET['rule']; //
 if($function_name==="GetListOfActiveRules"){ //if wants the sit of rules
     $res= $module->GetListOfActiveRules();
     echo json_encode($res);
     exit(); // stop executing once finish.
 }

 $module->CallRule($function_name);




//todo: Metrics
/*to capture the metrics*/
//require_once 'stanford_metrics.php';




