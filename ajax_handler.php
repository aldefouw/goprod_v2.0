<?php

 namespace Stanford\GoProd;

//$votecap = new \Stanford\GoProd\GoProd($_GET['pid']);
//include_once "../../redcap_v8.0.0/ExternalModules/classes/ExternalModules.php";
//namespace Stanford\GoProd;

/** @var \Stanford\GoProd\GoProd $module */
include_once "classes/utilities.php";


//if(!isset($_SESSION['data_dictionary'])){$_SESSION['data_dictionary'] = \REDCap::getDataDictionary('array');}
 //$data_dictionary_array= \REDCap::getDataDictionary('array');

//project information
//global $Proj;
//require_once 'messages.php';

$current_url = $_SERVER['REQUEST_URI'];
$base = $current_url;
$new_base_url = $base . "&";

/* in order to show the results on the #ResultsModal  and exit to avoid re run the rules*/
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



function PrintRulesNames(){


    $RuleNames = array(

        "OtherOrUnknownErrors",
        "BranchingLogicErrors",
        "YesNoConsistentErrors",
        "PositiveNegativeConsistentErrors",
        "DatesConsistentErrors",
        "CalculatedFieldsErrors",
        "ASILogicErrors",
        "QueueLogicErrors",
        "DataQualityLogicErrors",
        "ReportsLogicErrors",
        "TodayInCalculationsErrors",
        "IdentifiersErrors",
        "PIErrors",
        "IRBErrors",
        "TestRecordsErrors",
        "NumberOfFieldsByForm",
        "ValidatedFields",
        "MyFirstInstrumentError",
        "NotDesignatedFormsErrors",
        //"VariableNamesWithTheSameNameThanAnEventName",
        "ResearchErrors",
        "JustForFunErrors"
    );
    $RuleNames = array(); //__DIR__
    //define('CLASSES',__DIR__.'/classes/');
    $url= __DIR__.'/rules/';
    error_log("URL: $url");
    //foreach (glob($url) as $filename)
    //foreach ( scandir(dirname(__FILE__)) as $filename)
    foreach (scandir($url) as $filename)
    {
        if(ctype_upper(substr($filename, 0, 1)) ){
            $filename=preg_replace('/\.[^.]+$/','',$filename);
            array_push($RuleNames, $filename);
            error_log("REGLA: $filename");
            //include rule
        }
    }
    error_log( print_r($RuleNames, TRUE));
    return $RuleNames;
}

function PrintTr($title_text,$body_text,$span_label,$a_tag){

       $value=

        '<tr class="gp-tr" style="display: none">
           
        
            <td class="gp-info-content">
                <div class="gp-title-content gp-text-color">
                      <b>'.$title_text.' </b> 
                     <span class="title-text-plus" style="color: #7ec6d7"><small>(hide)</small></span> 
                </div>
                    
                <div class="gp-body-content overflow " style="color: #585858" >
                    <h5 class="list-group-item-text" >
                        ' .$body_text.' 
                    </h5>
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
            $risk_icon='glyphicon glyphicon-warning-sign';
            break;
        case "danger":
            $risk_title=lang('DANGER');
            $risk_color='text-danger';
            $risk_icon='glyphicon glyphicon-fire';
            break;
        case "success":
            $risk_title=lang('SUCCESS');
            $risk_color='text-success';
            $risk_icon='glyphicon glyphicon-thumbs-up';
            $size='fa-5x';
            break;
        case "info":
            $risk_title=lang('INFO');
            $risk_color='text-info';
            $risk_icon='glyphicon glyphicon-info-sign';
            break;
        default: //just in case
            $risk_title=lang('INFO');
            $risk_color='text-info';
            $risk_icon='glyphicon glyphicon-info-sign';
    }
     return '<abbr title='.$risk_title.'><span class="'.$size.' '.$risk_icon.' '.$risk_color.'" aria-hidden="true"></span></abbr>';
}

function PrintAHref($link_to_view){
    global $new_base_url;
    $link= $new_base_url . "i=" . rawurlencode($link_to_view);
    return '<a href="#ResultsModal" role="button"   class="btn  btn-default btn-lg review_btn" data-toggle="modal" data-load-remote='.$link.' data-is-loaded="false" data-remote-target="#ResultsModal">'.lang('VIEW').'</a>';
}

//function PrintRule($link_rule,$link_rule_view){
//    include_once $link_rule;
//    $res= eval_rule();
//    $array=$res::CheckOtherOrUnknown($DataDictionary, $similarity);
//
//}




function CallRule($RuneName){
    //$res =  call_user_func('\Stanford\GoProd\Print'.$RuneName);
    $phat_to_rule='rules/'.$RuneName.'.php';
    if(!@include_once($phat_to_rule)){ error_log("Failed to include:: $phat_to_rule");}
    // call function
    //error_log("se  include:: $phat_to_rule");
       // $RuneName="/".$RuneName;
       if (!(function_exists(__NAMESPACE__."\\".$RuneName))) {
           error_log( "Problem loading  $RuneName does not exist");
           exit();
     }

     //Call the Rule

     $array = call_user_func(__NAMESPACE__."\\".$RuneName);
    // error_log("este es el array primero con $RuneName");
    // error_log( print_r($array, TRUE));

     //crete HTML if results
    error_log("Este es el array RESULTS:");
    error_log( print_r($array['results'], TRUE));
    //if(!empty($array['results'])){
    if(is_array($array['results']) or $array['results']===true){

        $a=PrintAHref("views/other_or_unknown_view.php");
        $span=PrintLevelOfRisk($array['risk']);
        $print=PrintTr($array['title'],$array['body'],$span,$a);
        error_log("este es el array result");
        error_log( print_r($array['results'], TRUE));
        $array=$array['results'];
        $result[$RuneName]= array("Results"=>$array,"Html"=>$print);
        $res = json_encode($result);
        error_log("esto Retorna la funcion Call RUle con $RuneName");
        error_log( print_r($res, TRUE));

        echo $res;

    }

    else {
        error_log(">>>>>Callrule retorno Falso con $RuneName<<<<<");
          $res=json_encode(false);

          echo $res;}



}



//foreach (glob("classes/*.php") as $filename)
//{
//    include_once $filename;
//}


function PrintOtherOrUnknownErrors(){
        // $array= call_user_func(array(__NAMESPACE__ .'\check_other_or_unknown', 'CheckOtherOrUnknown')); // As of PHP 5.3.0
     // $array=call_user_func(__NAMESPACE__ .'\check_other_or_unknown::CheckOtherOrUnknown');
       // error_log(  __NAMESPACE__ .'\classes\check_other_or_unknown::CheckOtherOrUnknown');
       // error_log( print_r($res, TRUE));
        include_once "classes/Check_other_or_unknown.php";
        $res= new check_other_or_unknown();
        $array=$res::CheckOtherOrUnknown();

        // include_once "classes/Check_other_or_unknown.php";
    //$array=TestOAU();

        if(!empty($array)){
            $a=PrintAHref("views/other_or_unknown_view.php");
            $span=PrintLevelOfRisk('warning');
            $print=PrintTr(lang('OTHER_OR_UNKNOWN_TITLE'),lang('OTHER_OR_UNKNOWN_BODY'),$span,$a);
            $result["OtherOrUnknownErrors"]= array("Results"=>$array,"Html"=>$print);
           return $result;
        }else return false;
    }

function PrintBranchingLogicErrors( ){
        include_once "classes/Check_presence_of_branching_and_calculated_variables.php";
        $res= new check_presence_of_branching_and_calculated_variables();
        $array=$res::CheckIfBranchingLogicVariablesExist( );
        if (!empty($array)){
            $a=PrintAHref("views/presence_of_branching_logic_variables_view.php");
            $span=PrintLevelOfRisk('danger');
            $print=PrintTr(lang('BRANCHING_LOGIC_TITLE'),lang('BRANCHING_LOGIC_BODY'),$span,$a);
            $result["BranchingLogicErrors"]= array("Results"=>$array,"Html"=>$print);
            return $result;
        }else return false;
    }

function PrintCalculatedFieldsErrors( ){
    include_once "classes/Check_presence_of_branching_and_calculated_variables.php";
    $res= new check_presence_of_branching_and_calculated_variables();
    $array=$res::CheckIfCalculationVariablesExist( );
    if (!empty($array)){
        $a=PrintAHref("views/presence_of_calculated_variables_view.php");
        $span=PrintLevelOfRisk('danger');
        $print=PrintTr(lang('CALCULATED_FIELDS_TITLE'),lang('CALCULATED_FIELDS_BODY'),$span,$a);
        $result["CalculatedFieldsErrors"]= array("Results"=>$array,"Html"=>$print);
        return $result;
    }else return false;
}
function PrintASILogicErrors(){
    include_once "classes/Check_presence_of_branching_and_calculated_variables.php";
    $res= new check_presence_of_branching_and_calculated_variables();
    $array=$res::CheckIfASILogicVariablesExist();
    if (!empty($array)){
        $a=PrintAHref("views/asi_logic_view.php");
        $span=PrintLevelOfRisk('danger');
        $print=PrintTr(lang('ASI_LOGIC_TITLE'),lang('ASI_LOGIC_BODY'),$span,$a);
        $result["ASILogicErrors"]= array("Results"=>$array,"Html"=>$print);
        return $result;
    }else return false;

}
function PrintQueueLogicErrors(){
    include_once "classes/Check_presence_of_branching_and_calculated_variables.php";
    $res= new check_presence_of_branching_and_calculated_variables();
    $array=$res::CheckIfQueueLogicVariablesExist();
    if (!empty($array)){
        $a=PrintAHref("views/queue_logic_view.php");
        $span=PrintLevelOfRisk('danger');
        $print=PrintTr(lang('QUEUE_LOGIC_TITLE'),lang('QUEUE_LOGIC_BODY'),$span,$a);
        $result["QueueLogicErrors"]= array("Results"=>$array,"Html"=>$print);
        return $result;
    }else return false;

}
function PrintDataQualityLogicErrors(){
    include_once "classes/Check_presence_of_branching_and_calculated_variables.php";
    $res= new check_presence_of_branching_and_calculated_variables();
    $array=$res::CheckIfDataQualityLogicVariablesExist();
    if (!empty($array)){
        $a=PrintAHref("views/data_quality_logic_view.php");
        $span=PrintLevelOfRisk('warning');
        $print=PrintTr(lang('DATA_QUALITY_LOGIC_TITLE'),lang('DATA_QUALITY_LOGIC_BODY'),$span,$a);
        $result["DataQualityLogicErrors"]= array("Results"=>$array,"Html"=>$print);
        return $result;
    }else return false;

}

function PrintReportsLogicErrors(){
    include_once "classes/Check_presence_of_branching_and_calculated_variables.php";
    $res= new check_presence_of_branching_and_calculated_variables();
    $array=$res::CheckIfReportsLogicVariablesExist();
    if (!empty($array)){
        $a=PrintAHref("views/reports_logic_view.php");
        $span=PrintLevelOfRisk('warning');
        $print=PrintTr(lang('REPORTS_LOGIC_TITLE'),lang('REPORTS_LOGIC_BODY'),$span,$a);
        $result["ReportsLogicErrors"]= array("Results"=>$array,"Html"=>$print);
        return $result;
    }else return  false;

}
function PrintTodayInCalculationsErrors( ){
    include_once "classes/Check_presence_of_branching_and_calculated_variables.php";
    $res= new check_presence_of_branching_and_calculated_variables();
    $array=$res::CheckIfTodayExistInCalculations( );
    if (!empty($array)){
        $a=PrintAHref("views/today_calculations_view.php");
        $span=PrintLevelOfRisk('warning');
        $print=PrintTr(lang('CALCULATED_TODAY_TITLE'),lang('CALCULATED_TODAY_BODY'),$span,$a);
        $result["TodayInCalculationsErrors"]= array("Results"=>$array,"Html"=>$print);
        return $result;
    }else return false;
}
function PrintVariableNamesWithTheSameNameAsAnEventNameErrors(){
    include_once "classes/Check_presence_of_branching_and_calculated_variables.php";
    $res= new check_presence_of_branching_and_calculated_variables();
    $array=$res::VariableNamesWithTheSameNameAsAnEventName();
    if (!empty($array)){
        $a=PrintAHref("views/variables_with_same_name_as_event_view.php");
        $span=PrintLevelOfRisk('warning');
        $print=PrintTr(lang('VAR_NAMES_EVENT_NAMES_TITLE'),lang('VAR_NAMES_EVENT_NAMES_BODY'),$span,$a);
        $result["VariableNamesWithTheSameNameThanAnEventName"]= array("Results"=>$array,"Html"=>$print);
        return $result;
    }else return false;


}
function PrintDatesConsistentErrors( ){
    include "classes/Check_dates_consistency.php";
    $res= new check_dates_consistency();
    $array=$res::IsDatesConsistent( );
    if (!empty($array)){
        $a=PrintAHref("views/dates_consistency_view.php");
        $span=PrintLevelOfRisk('warning');
        $print=PrintTr(lang('DATE_CONSISTENT_TITLE'),lang('DATE_CONSISTENT_BODY'),$span,$a);
        $result["DatesConsistentErrors"]= array("Results"=>$array,"Html"=>$print);
        return $result;
    }else return false;

}
function PrintYesNoConsistentErrors( ){
    include_once "classes/Check_consistency_for_lists.php";
    $res= new check_consistency_for_lists();
    $array=$res::IsYesNoConsistent( );
    if (!empty($array)){
        $a=PrintAHref("views/consistency_yes_no_view.php");
        $span=PrintLevelOfRisk('warning');
        $_SESSION["YesNoConsistentErrors"]= $array;
        $print=PrintTr(lang('YES_NO_TITLE'),lang('YES_NO_BODY'),$span,$a);
        $result["YesNoConsistentErrors"]= array("Results"=>$array,"Html"=>$print);
        return $result;

    }else return false;


}
function PrintPositiveNegativeConsistentErrors( ){
    include_once "classes/Check_consistency_for_lists.php";
    $res= new check_consistency_for_lists();
    $array=$res::IsPositiveNegativeConsistent( );
    if (!empty($array)){
        $a=PrintAHref("views/consistency_positive_negative_view.php");
        $span=PrintLevelOfRisk('warning');
        $print=PrintTr(lang('POSITIVE_NEGATIVE_TITLE'),lang('POSITIVE_NEGATIVE_BODY'),$span,$a);
        $result["PositiveNegativeConsistentErrors"]= array("Results"=>$array,"Html"=>$print);
        return $result;
    }else return  false ;

}
function PrintIdentifiersErrors( ){
    include_once "classes/Check_identifiers.php";
    $res= new check_identifiers();
    $identifiers_found=$res::AnyIdentifier( );
    if (!$identifiers_found){

        $a='<a  target="_blank"  role="button" class="btn btn-default" href=" '.APP_PATH_WEBROOT . 'index.php?pid='.$_GET['pid'].'&route=IdentifierCheckController:index" >'.lang('EDIT').'</a>';
        //$span='<span class="label label-warning">'.lang('WARNING').'</span>';
        $span=PrintLevelOfRisk('warning');
        $print=PrintTr(lang('IDENTIFIERS_TITLE'),lang('IDENTIFIERS_BODY'),$span,$a);
        $result["IdentifiersErrors"]= array("Results"=>"null","Html"=>$print);

        return $result;


    }else return false;
}
function PrintPIErrors(){
    include_once "classes/Check_pi_irb_type.php";
    $res= new check_pi_irb_type();
    $pi_found=$res::PIExist();
    if (!$pi_found){
        $a='<a  target="_blank" role="button" class="btn btn-default" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?to_prod_plugin=3&pid='.$_GET['pid'].'"  >'.lang('VIEW').'</a>';
        //$span='<span class="label label-danger">'.lang('DANGER').'</span>';
        $span=PrintLevelOfRisk('danger');
        $print=PrintTr(lang('PI_TITLE'),lang('PI_BODY'),$span,$a);
        $result["PIErrors"]= array("Results"=>"null","Html"=>$print);

        return $result;

    }else return false;


}
function PrintIRBErrors(){
    include_once "classes/Check_pi_irb_type.php";
    $res= new check_pi_irb_type();
    $pi_found=$res::IRBExist();
    if (!$pi_found){
        $a='<a  target="_blank" class="btn btn-default" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?to_prod_plugin=3&pid='.$_GET['pid'].'"  >'.lang('VIEW').'</a>';
        //$span='<span class="label label-danger">'.lang('DANGER').'</span>';
        $span=PrintLevelOfRisk('danger');
        $print=PrintTr(lang('IRB_TITLE'),lang('IRB_BODY'),$span,$a);
        $result["IRBErrors"]= array("Results"=>"null","Html"=>$print);

        return $result;

    }else return false;


}
function PrintResearchErrors(){
    include_once "classes/Check_pi_irb_type.php";
    $res= new check_pi_irb_type();
    $research_found=$res::IsAResearchProject();
    if ($research_found) {
        return false;
    } else {
        $a = '<a  target="_blank" class="btn btn-default" href=" ' . APP_PATH_WEBROOT . 'ProjectSetup/index.php?to_prod_plugin=3&pid=' . $_GET['pid'] . '"  >' . lang('VIEW') . '</a>';
        //$span='<span class="label label-info">'.lang('INFO').'</span>';
        $span = PrintLevelOfRisk('info');
        $print = PrintTr(lang('RESEARCH_PROJECT_TITLE'), lang('RESEARCH_PROJECT_BODY'), $span, $a);
        $result["ResearchErrors"] = array("Results" => "null", "Html" => $print);

        return $result;

    }
}
function PrintJustForFunErrors(){
    include_once "classes/Check_pi_irb_type.php";
    $res= new check_pi_irb_type();
    $jff_found=$res::IsJustForFunProject();
    if ($jff_found){
        $_SESSION["IsJustForFun"]= $jff_found;
        $a='<a  target="_blank" class="btn btn-default" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?to_prod_plugin=3&pid='.$_GET['pid'].'"  >'.lang('VIEW').'</a>';
        //$span='<span class="label label-danger">'.lang('DANGER').'</span>';
        $span=PrintLevelOfRisk('danger');
        $print=PrintTr(lang('JUST_FOR_FUN_PROJECT_TITLE'),lang('JUST_FOR_FUN_PROJECT_BODY'),$span,$a);
        $result["JustForFunErrors"]= array("Results"=>"null","Html"=>$print);
        return $result;
    }else{
        return false;
    }
}
function PrintTestRecordsErrors(){
    include_once "classes/Check_count_test_records_and_exports.php";
    $res= new check_count_test_records_and_exports();
    global $Proj;
    $array=$res::CheckTestRecordsAndExports();
    if (!empty($array) and $Proj->project['status']==0){
        $a= '<u>Exports:</u>'.$array[0].'<br><u> Records: </u>'.$array[1];
        //$span='<span class="label label-danger">'.lang('DANGER').'</span>';
        $span=PrintLevelOfRisk('danger');
        $print=PrintTr(lang('TEST_RECORDS_TITLE'),lang('TEST_RECORDS_BODY'),$span,$a);
        $result["TestRecordsErrors"]= array("Results"=>"null","Html"=>$print);
        return $result;
    }else return false;
}
function PrintNumberOfFieldsByForm(){
    include_once 'classes/Check_number_of_fields_by_form.php';
    $res= new check_number_of_fields_by_form();
    $array=$res::getFormsWithToManyFields();
    if (!empty($array)){
        $a=PrintAHref("views/number_of_fields_by_form_view.php");
        $span=PrintLevelOfRisk('warning');
        $print=PrintTr(lang('MAX_NUMBER_OF_RECORDS_TITLE'),lang('MAX_NUMBER_OF_RECORDS_BODY'),$span,$a);
        $result["NumberOfFieldsByForm"]= array("Results"=>$array,"Html"=>$print);
        return $result;
    }else return false;

}
function PrintValidatedFields(){
    include_once 'classes/Check_field_validation.php';
    $res= new check_field_validation();
    $array=$res::getMinimumOfValidatedFields();

    if (!empty($array)){
        $a= '<u>'.lang('VALIDATED_FIELDS').'</u>'.$array[0].'<br><u>'.lang('TEXT_BOX_FIELDS').'</u>'.$array[1];
        //$span='<span class="label label-warning">'.lang('WARNING').'</span>';
        $span=PrintLevelOfRisk('warning');

        $print=PrintTr(lang('NUMBER_VALIDATED_RECORDS_TITLE'),lang('NUMBER_VALIDATED_RECORDS_BODY'),$span,$a);
        $result["ValidatedFields"]= array("Results"=>"null","Html"=>$print);
        return $result;
    }else{
        return false;
    }
}

function  PrintMyFirstInstrumentError(){
    include_once "classes/Check_my_first_instrument_presence.php";
    $res= new check_my_first_instrument_presence();
    $my_first_instrument_found=$res::IsMyFirstInstrument();
    if ($my_first_instrument_found){
        $a='<a  target="_blank" class="btn btn-default" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?to_prod_plugin=3&pid='.$_GET['pid'].'"  >'.lang('PROJECT_SETUP').'</a>';
        //$span='<span class="label label-warning">'.lang('WARNING').'</span>';
        $span=PrintLevelOfRisk('warning');
        $print=PrintTr(lang('MY_FIRST_INSTRUMENT_TITLE'),lang('MY_FIRST_INSTRUMENT_BODY'),$span,$a);
        $result["MyFirstInstrumentError"]= array("Results"=>"null","Html"=>$print);
        return $result;
    }else return false;
}

function  PrintNotDesignatedFormsErrors(){
    include_once "classes/Check_un_designated_longitudinal_forms.php";
    $res= new check_un_designated_longitudinal_forms();
    $array=$res::NotDesignatedForms();
    if (!empty($array)){
        $a=PrintAHref("views/undesignated_forms_view.php");
        $span=PrintLevelOfRisk('warning');
        $print=PrintTr(lang('NOT_DESIGNATED_FORMS_TITLE'),lang('NOT_DESIGNATED_FORMS_BODY'),$span,$a);
        $result["NotDesignatedFormsErrors"]= array("Results"=>$array,"Html"=>$print);
        return $result;
    }else return false;
}

//function PrintSuccess(){
////TODO: send directly to move to production screen
//    $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?to_prod_plugin=3&pid='.$_GET['pid'].'"  >'.lang('PROJECT_SETUP').'</a>';
//    //$span='<span class="label label-success">'.lang('SUCCESS').'</span>';
//    $span=PrintLevelOfRisk('success');
//    return PrintTr(lang('READY_TO_GO_TITLE'),lang('READY_TO_GO_BODY'),$span,$a);
//}

//$functName = $_REQUEST['f'];
$functName = $_GET['f'];


if($functName==="PrintRulesNames"){
    $res= PrintRulesNames();
    echo json_encode($res);
    exit();
}
CallRule($functName);
//try{
//
//    //error_log(">>>==$functName  esta en el arreglo::::: ");
//    //$res =  call_user_func('\Stanford\GoProd\Print'.$functName);
//
//    $res=CallRule($functName);
//    if(!$res){
//        $res = json_encode($res);
//        echo $res;
//        exit();
//        }
//    $res = json_encode($res);
//       error_log(":::este es el RES de la funcion::: $functName");
//          error_log($res);
//    echo  $res;
//
//
//}catch (Exception $e) {
//    $msg= 'Message: ' .$e->getMessage();
//    error_log("####### $msg >>>>No esta ===>$functName ");
//} finally
//{
//    exit();
//}
//
//





//
//
//
//switch ($functName) {
//    case "PrintRulesNames":
//        PrintRulesNames($RuleNames);
//       // call_user_func_array(__NAMESPACE__."\PrintRulesNames",$RuleNames);
//
//        break;
//    case "OtherOrUnknownErrors":
//        //$data_dictionary_array= \REDCap::getDataDictionary('array');
//       // $res = json_encode(PrintOtherOrUnknownErrors($data_dictionary_array, 95));
//        $res = json_encode(PrintOtherOrUnknownErrors());
//        /* error_log("aqui abajo");
//         error_log($res);*/
//        echo $res;
//        break;
//    case "BranchingLogicErrors":
//
//        $res = json_encode(PrintBranchingLogicErrors());
//        echo $res;
//        break;
//    case "CalculatedFieldsErrors":
//
//        $res = json_encode(PrintCalculatedFieldsErrors());
//        echo $res;
//        break;
//    case "ASILogicErrors":
//        $res = json_encode(PrintASILogicErrors());
//        echo $res;
//        break;
//    case "QueueLogicErrors":
//        $res = json_encode(PrintQueueLogicErrors());
//        echo $res;
//        break;
//    case "DataQualityLogicErrors":
//        $res = json_encode(PrintDataQualityLogicErrors());
//        echo $res;
//        break;
//    case "ReportsLogicErrors":
//        $res = json_encode(PrintReportsLogicErrors());
//        echo $res;
//        break;
//    case "TodayInCalculationsErrors":
//
//        $res = json_encode(PrintTodayInCalculationsErrors());
//        echo $res;
//        break;
//    case "VariableNamesWithTheSameNameThanAnEventName":
//        //echo PrintVariableNamesWithTheSameNameAsAnEventNameErrors($data_dictionary_array);
//        break;
//    case "DatesConsistentErrors":
//
//        $res = json_encode(PrintDatesConsistentErrors());
//        echo $res;
//        break;
//    case "YesNoConsistentErrors":
//
//        $res = json_encode(PrintYesNoConsistentErrors());
//        echo $res;
//
//        break;
//    case "PositiveNegativeConsistentErrors":
//
//        $res = json_encode(PrintPositiveNegativeConsistentErrors());
//        echo $res;
//        break;
//    case "IdentifiersError":
//
//        $res = json_encode(PrintIdentifiersErrors());
//        echo $res;
//        break;
//    case "PIErrors":
//        $res = json_encode(PrintPIErrors());
//        echo $res;
//        break;
//    case "IRBErrors":
//        $res = json_encode(PrintIRBErrors());
//        echo $res;
//
//        break;
//    case "ResearchErrors":
//        $res = json_encode(PrintResearchErrors());
//        echo $res;
//
//        break;
//    case "JustForFunErrors":
//         $res = json_encode(PrintJustForFunErrors());
//        //$res =  call_user_func(array(__NAMESPACE__ , 'PrintJustForFunErrors'));
//        //$res =  call_user_func('\Stanford\GoProd\PrintJustForFunErrors');
//        //$res= json_encode($res);
//        echo $res;
//        break;
//    case "TestRecordsErrors":
//        $res = json_encode(PrintTestRecordsErrors());
//        echo $res;
//        break;
//    case "NumberOfFieldsByForm":
//        $res = json_encode(PrintNumberOfFieldsInForms());
//        echo $res;
//        break;
//
//    case "ValidatedFields":
//
//        $res = json_encode(PrintValidatedFields());
//        echo $res;
//        break;
//    case "MyFirstInstrumentError":
//        $res = json_encode(MyFirstInstrumentError());
//        echo $res;
//
//        break;
//    case "NotDesignatedFormsErrors":
//        $res = json_encode(NotDesignatedFormsErrors());
//        echo $res;
//
//        break;
//    case "AllSet":
//        echo PrintSuccess();
//        break;
//    default:
//        //echo "<B>Not Valid Rule</B> <br>".$functName;
//        break;
//}

//todo: Metrics
/*to capture the metrics*/
//require_once 'stanford_metrics.php';




