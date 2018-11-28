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

$PathRulesFolder="rules/"; //folder with all rules is called in the code by using $GLOBALS['PathRulesFolder']



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
     $res= GetListOfActiveRules();
     echo json_encode($res);
     exit(); // stop executing once finish.
 }

 CallRule($function_name);


 /**********************************************************************************************************
 Read all file names on the /rules folder and creates an array with all the names removing the .php part
 ..... -maybe PrintRulesNames is not the best name-
  **********************************************************************************************************/
function GetListOfActiveRules(){
    $RuleNames = array();
    $url= __DIR__.'/'.$GLOBALS['PathRulesFolder'];
    foreach (scandir($url) as $filename)
    {
        if(ctype_upper(substr($filename, 0, 1)) ){
            $filename=preg_replace('/\.[^.]+$/','',$filename);
            array_push($RuleNames, $filename);
        }
    }

    //TODO: filter skipped rules::
    //load skipped rules from logg
   // $res= new ReadWriteLogging($_GET['pid']);
  //  $RuleNames=$res->GetActiveRules($RuleNames);


    return $RuleNames;
}

/*********************************************************************************
 * Call and execute a given rule --- returns (print) the json_encode  for the view
 ********************************************************************************* */
function CallRule($RuneName){

    //path to the rule folder

    $phat_to_rule=$GLOBALS['PathRulesFolder'].$RuneName.'.php';

    //Dynamic include the path of the rule in order to be called -- exit if fails
    if(!@include_once($phat_to_rule)) {
        error_log("Failed to include:: $phat_to_rule");
        exit();
    }

    //Check if the path and function exist. if not then exit.
    if (!(function_exists(__NAMESPACE__."\\".$RuneName))) {
        error_log( "Problem loading  $RuneName does not exist");
        exit();
    }

     //Call the Rule the function  call_user_func helps to call functions directly from a path  and save the result in $ResultRulesArray
     $ResultRulesArray = call_user_func(__NAMESPACE__."\\".$RuneName);
   //read the results sof the function: if the rule returns true, then extract the Html to present on the views - if not return false
    if(!empty($ResultRulesArray['results'])){
        //if found problems
        $a=PrintAHref("views/results.php");// results.php is the DATA TABLE that shows the list of issues
        $span=PrintLevelOfRisk($ResultRulesArray['risk']);
        $print=PrintTr($ResultRulesArray['title'],$ResultRulesArray['body'],$span,$a,$RuneName);
        $ResultRulesArray=$ResultRulesArray['results'];
        $result[$RuneName]= array("Results"=>$ResultRulesArray,"Html"=>$print);
        $res = json_encode($result);
        echo $res;
    }
    else {
       //if no problem found
       error_log(">>>>>Call Rule returns false with rule= $RuneName <<<<<");
       $res=json_encode(false);
       echo $res;
       }
}


/***************************************************************************************
 * The functions below are in chagrge of printing, and adding the HTML to the rules
 *
 * (probably in the future this group of functions will be moved to an external class)
 *
 ************************************************************************************** */

 function PrintTr($title_text,$body_text,$span_label,$a_tag,$rulename){
     $value=
         '<tr class="gp-tr" id="'.$rulename.'" style="display: none">
            <td class="gp-info-content">
                <div class="gp-title-content gp-text-color">
                      <b>'.$title_text.' </b> 
                     <span class="title-text-plus" style="color: #7ec6d7"><small>(hide)</small></span> 
                </div>
                    
                <div class="gp-body-content overflow  gp-text-color" >
                    <p class="list-group-item-text" >
                        ' .$body_text.' 
                    </p>
                </div>
            </td>
            <td class="center " width="100">               
                    '.$span_label.' 
            </td>
            <td class="gp-actions center" width="100">               
                 <div class="gp-actions-link" style="display: none">'.$a_tag.'</div>    
            </td>
        </tr>';
     // $value=htmlentities(stripslashes(utf8_encode($value)), ENT_QUOTES);
     return $value;
 }
//Print the level of risk or the rule
 function PrintLevelOfRisk($type){
     $size='fa-2x';
     switch ($type) {

         case "warning":
             $risk_title=lang('WARNING');
             $risk_color='text-warning';
             //$risk_icon='glyphicon glyphicon-exclamation-sign';
             $risk_icon='fa fa-exclamation-triangle';
             break;
         case "danger":
             $risk_title=lang('DANGER');
             $risk_color='text-danger';
             $risk_icon='fa fa-fire';
             break;
         case "success":
             $risk_title=lang('SUCCESS');
             $risk_color='text-success';
             $risk_icon='fa fa-thumbs-up';
             $size='fa-5x';
             break;
         case "info":
             $risk_title=lang('INFO');
             $risk_color='text-info';
             $risk_icon='fa fa-info-circle';
             break;
         default: //just in case
             $risk_title=lang('INFO');
             $risk_color='text-info';
             $risk_icon='fa fa-info-circle';
     }
     return '<abbr title='.$risk_title.'><span class="'.$size.' '.$risk_icon.' '.$risk_color.'" aria-hidden="true"></span></abbr>';
 }
 function PrintAHref($link_to_view){
     global $new_base_url;
     $link= $new_base_url . "i=" . rawurlencode($link_to_view);
     return '<a href="#ResultsModal" role="button"   class="btn  btn-default btn-lg review_btn" data-toggle="modal" data-link='.$link.' data-is-loaded="false">'.lang('VIEW').'</a>';
 }



//todo: Metrics
/*to capture the metrics*/
//require_once 'stanford_metrics.php';




