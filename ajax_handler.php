<?php

 namespace Stanford\GoProd;

//$votecap = new \Stanford\GoProd\GoProd($_GET['pid']);
//include_once "../../redcap_v8.0.0/ExternalModules/classes/ExternalModules.php";
namespace Stanford\GoProd;

/** @var \Stanford\GoProd\GoProd $module */
include_once "classes/utilities.php";


 $current_url = $_SERVER['REQUEST_URI'];
//$current_url=$module->getUrl('views');

//$base = parse_url($current_url, PHP_URL_PATH);
$base = $current_url;

//$new_base_url = $base . "?pid=" . $_GET['pid'] ."&id=".$_GET['id']. "&";
$new_base_url = $base . "&";


//if(!isset($_SESSION['data_dictionary'])){$_SESSION['data_dictionary'] = \REDCap::getDataDictionary('array');}
 //$data_dictionary_array= \REDCap::getDataDictionary('array');

//project information
//global $Proj;
//require_once 'messages.php';

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
    "IdentifiersError",
    "PIErrors",
    "IRBErrors",
    "TestRecordsErrors",
    "NumberOfFieldsByForm",
    "ValidatedFields",
    "MyFirstInstrumentError",
    "NotDesignatedFormsErrors",
    //"AllSet",   //"PrintSuccess"
    //"VariableNamesWithTheSameNameThanAnEventName",
    // "ResearchErrors",
    // "JustForFunErrors",
    );
     echo json_encode($RuleNames);
}

function PrintTr($title_text,$body_text,$span_label,$a_tag){

       $value=

        '<tr class="gp-tr" style="display: none">
            <td  class="gp-icon" width="20">   
                    <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                    
            </td>
            <td class="gp-info-content">
                <div class="gp-title-content ">
                    <strong>
                        '.$title_text. ' <span class="title-text-plus" style="color: #b9b9b9"><small>(less)</small></span>
                    </strong>   
                </div>
                    
                <div class="gp-body-content overflow " >
                    <p>
                        ' .$body_text.' 
                    </p>
                </div>
            </td>
            <td class="center " width="100">               
                    '.$span_label.' 
            </td>
            <td class="gp-actions center" width="100">               
                 <div class="gp-actions-link" style="display: none"><small>'.$a_tag.'</small></div>
                 
            </td>
        </tr>';
      // $value=htmlentities(stripslashes(utf8_encode($value)), ENT_QUOTES);

       return $value;

}
function PrintOtherOrUnknownErrors($DataDictionary, $similarity){
        include_once "classes/Check_other_or_unknown.php";
        $res= new check_other_or_unknown();
        $array=$res::CheckOtherOrUnknown($DataDictionary, $similarity);

        if(!empty($array)){

            global $new_base_url;
            $link= $new_base_url . "i=" . rawurlencode("views/other_or_unknown_view.php");
           //$link="views/other_or_unknown_view.php";
            $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote='.$link.' data-isloaded="false" data-remote-target="#ResultsModal">'.lang('VIEW').'</a>';
            $span='<span class="label label-warning">'.lang('WARNING').'</span>';
            $print=PrintTr(lang('OTHER_OR_UNKNOWN_TITLE'),lang('OTHER_OR_UNKNOWN_BODY'),$span,$a);
            $result["OtherOrUnknownErrors"]= array("Results"=>$array,"Html"=>$print);

           return $result;
        }else return false;

    }
function PrintBranchingLogicErrors($DataDictionary){

        include_once "classes/Check_presence_of_branching_and_calculated_variables.php";
        $res= new check_presence_of_branching_and_calculated_variables();
        $array=$res::CheckIfBranchingLogicVariablesExist($DataDictionary);
        if (!empty($array)){
            global $new_base_url;
            $link= $new_base_url . "i=" . rawurlencode("views/presence_of_branching_logic_variables_view.php");
            //$link= $module->getUrl("views/presence_of_branching_logic_variables_view.php");
            $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote='.$link.' data-isloaded="false" data-remote-target="#ResultsModal">'.lang('VIEW').' </a>';
            $span='<span class="label label-danger">'.lang('DANGER').'</span>';

            $print=PrintTr(lang('BRANCHING_LOGIC_TITLE'),lang('BRANCHING_LOGIC_BODY'),$span,$a);
            $result["BranchingLogicErrors"]= array("Results"=>$array,"Html"=>$print);
            return $result;


        }else return false;
    }
function PrintCalculatedFieldsErrors($DataDictionary){
    include_once "classes/Check_presence_of_branching_and_calculated_variables.php";
    $res= new check_presence_of_branching_and_calculated_variables();
    $array=$res::CheckIfCalculationVariablesExist($DataDictionary);
    if (!empty($array)){
        global $new_base_url;
        $link= $new_base_url . "i=" . rawurlencode("views/presence_of_calculated_variables_view.php");
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote='.$link.' data-isloaded="false" data-remote-target="#ResultsModal">'.lang('VIEW').' </a>';
        $span='<span class="label label-danger">'.lang('DANGER').'</span>';
        //$_SESSION["CalculatedFieldsErrors"]= $array;

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
        global $new_base_url;
        $link= $new_base_url . "i=" . rawurlencode("views/asi_logic_view.php");
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote='.$link.' data-isloaded="false" data-remote-target="#ResultsModal">'.lang('VIEW').' </a>';
        $span='<span class="label label-danger">'.lang('DANGER').'</span>';
       // $_SESSION["ASILogicErrors"]= $array;

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
        global $new_base_url;
        $link= $new_base_url . "i=" . rawurlencode("views/queue_logic_view.php");

        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote='.$link.' data-isloaded="false" data-remote-target="#ResultsModal">'.lang('VIEW').' </a>';
        $span='<span class="label label-danger">'.lang('DANGER').'</span>';



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
        global $new_base_url;
        $link= $new_base_url . "i=" . rawurlencode("views/data_quality_logic_view.php");
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote='.$link.' data-isloaded="false" data-remote-target="#ResultsModal">'.lang('VIEW').' </a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';

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
        global $new_base_url;
        $link= $new_base_url . "i=" . rawurlencode("views/reports_logic_view.php");
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote='.$link.' data-isloaded="false" data-remote-target="#ResultsModal">'.lang('VIEW').' </a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        $print=PrintTr(lang('REPORTS_LOGIC_TITLE'),lang('REPORTS_LOGIC_BODY'),$span,$a);
        $result["ReportsLogicErrors"]= array("Results"=>$array,"Html"=>$print);

        return $result;




    }else return  false;

}
function PrintTodayInCalculationsErrors($DataDictionary){
    include_once "classes/Check_presence_of_branching_and_calculated_variables.php";
    $res= new check_presence_of_branching_and_calculated_variables();
    $array=$res::CheckIfTodayExistInCalculations($DataDictionary);
    if (!empty($array)){
        global $new_base_url;
        $link= $new_base_url . "i=" . rawurlencode("views/today_calculations_view.php");
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote='.$link.' data-isloaded="false" data-remote-target="#ResultsModal">'.lang('VIEW').' </a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        //$_SESSION["TodayExistInCalculations"]= $array;

        $print=PrintTr(lang('CALCULATED_TODAY_TITLE'),lang('CALCULATED_TODAY_BODY'),$span,$a);
        $result["TodayInCalculationsErrors"]= array("Results"=>$array,"Html"=>$print);

        return $result;



    }else return false;
}
function PrintVariableNamesWithTheSameNameAsAnEventNameErrors(){
    include_once "classes/Check_presence_of_branching_and_calculated_variables.php";
    $res= new check_presence_of_branching_andcalculated_variables();
    $array=$res::VariableNamesWithTheSameNameAsAnEventName();
    if (!empty($array)){
        global $new_base_url;
        $link= $new_base_url . "i=" . rawurlencode("views/variables_with_same_name_as_event_view.php");
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote='.$link.' data-isloaded="false" data-remote-target="#ResultsModal">'.lang('VIEW').' </a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        //$_SESSION["VariableNamesWithTheSameNameThanAnEventName"]= $array;

        $print=PrintTr(lang('VAR_NAMES_EVENT_NAMES_TITLE'),lang('VAR_NAMES_EVENT_NAMES_BODY'),$span,$a);
        $result["VariableNamesWithTheSameNameThanAnEventName"]= array("Results"=>$array,"Html"=>$print);

        return $result;



    }else return false;


}
function PrintDatesConsistentErrors($DataDictionary){
    include "classes/Check_dates_consistency.php";
    $res= new check_dates_consistency();
    $array=$res::IsDatesConsistent($DataDictionary);
    if (!empty($array)){
        global $new_base_url;
        $link= $new_base_url . "i=" . rawurlencode("views/dates_consistency_view.php");
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote='.$link.' data-isloaded="false" data-remote-target="#ResultsModal">'.lang('VIEW').'</a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        $print=PrintTr(lang('DATE_CONSISTENT_TITLE'),lang('DATE_CONSISTENT_BODY'),$span,$a);
        $result["DatesConsistentErrors"]= array("Results"=>$array,"Html"=>$print);
        return $result;

    }else return false;


}
function PrintYesNoConsistentErrors($DataDictionary){
    include_once "classes/Check_consistency_for_lists.php";
    $res= new check_consistency_for_lists();
    $array=$res::IsYesNoConsistent($DataDictionary);
    if (!empty($array)){
        global $new_base_url;
            $link= $new_base_url . "i=" . rawurlencode("views/consistency_yes_no_view.php");
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote='.$link.' data-isloaded="false" data-remote-target="#ResultsModal">'.lang('VIEW').'</a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        $_SESSION["YesNoConsistentErrors"]= $array;
        $print=PrintTr(lang('YES_NO_TITLE'),lang('YES_NO_BODY'),$span,$a);
        $result["YesNoConsistentErrors"]= array("Results"=>$array,"Html"=>$print);
        return $result;

    }else return false;


}
function PrintPositiveNegativeConsistentErrors($DataDictionary){
    include_once "classes/Check_consistency_for_lists.php";
    $res= new check_consistency_for_lists();
    $array=$res::IsPositiveNegativeConsistent($DataDictionary);
    if (!empty($array)){
        global $new_base_url;
        $link= $new_base_url . "i=" . rawurlencode("views/consistency_positive_negative_view.php");
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote='.$link.' data-isloaded="false" data-remote-target="#ResultsModal">'.lang('VIEW').'</a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        $print=PrintTr(lang('POSITIVE_NEGATIVE_TITLE'),lang('POSITIVE_NEGATIVE_BODY'),$span,$a);
        $result["PositiveNegativeConsistentErrors"]= array("Results"=>$array,"Html"=>$print);
        return $result;

    }else return  false ;


}
function PrintIdentifiersErrors($DataDictionary){
    include_once "classes/Check_identifiers.php";
    $res= new check_identifiers();
    $identifiers_found=$res::AnyIdentifier($DataDictionary);
    if (!$identifiers_found){

        $a='<a  target="_blank"  role="button" class="btn" href=" '.APP_PATH_WEBROOT . 'index.php?pid='.$_GET['pid'].'&route=IdentifierCheckController:index" >'.lang('EDIT').'</a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';

        $print=PrintTr(lang('IDENTIFIERS_TITLE'),lang('IDENTIFIERS_BODY'),$span,$a);
        $result["IdentifiersError"]= array("Results"=>"null","Html"=>$print);

        return $result;


    }else return false;
}
function PrintPIErrors($proj){
    include_once "classes/Check_pi_irb_type.php";
    $res= new check_pi_irb_type();
    $pi_found=$res::PIExist($proj);
    if (!$pi_found){
        $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?to_prod_plugin=3&pid='.$_GET['pid'].'"  >'.lang('PROJECT_SETUP').'</a>';
        $span='<span class="label label-danger">'.lang('DANGER').'</span>';

        $print=PrintTr(lang('PI_TITLE'),lang('PI_BODY'),$span,$a);
        $result["PIErrors"]= array("Results"=>"null","Html"=>$print);

        return $result;

    }else return false;


}
function PrintIRBErrors($proj){
    include_once "classes/Check_pi_irb_type.php";
    $res= new check_pi_irb_type();
    $pi_found=$res::IRBExist($proj);
    if (!$pi_found){
        $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?to_prod_plugin=3&pid='.$_GET['pid'].'"  >'.lang('PROJECT_SETUP').'</a>';
        $span='<span class="label label-danger">'.lang('DANGER').'</span>';

        $print=PrintTr(lang('IRB_TITLE'),lang('IRB_BODY'),$span,$a);
        $result["IRBErrors"]= array("Results"=>"null","Html"=>$print);

        return $result;

    }else return false;


}
function PrintResearchErrors($proj){
    include_once "classes/Check_pi_irb_type.php";
    $res= new check_pi_irb_type();
    $research_found=$res::IsAResearchProject($proj);
    if (!$research_found){
        $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?to_prod_plugin=3&pid='.$_GET['pid'].'"  >'.lang('PROJECT_SETUP').'</a>';
        $span='<span class="label label-info">'.lang('INFO').'</span>';

        $print=PrintTr(lang('RESEARCH_PROJECT_TITLE'),lang('RESEARCH_PROJECT_BODY'),$span,$a);
        $result["ResearchErrors"]= array("Results"=>"null","Html"=>$print);

        return $result;

    }else return false;
}
function PrintJustForFunErrors($proj){
    include_once "classes/Check_pi_irb_type.php";
    $res= new check_pi_irb_type();
    $jff_found=$res::IsJustForFunProject($proj);
    if ($jff_found){
        $_SESSION["IsJustForFun"]= $jff_found;
        $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?to_prod_plugin=3&pid='.$_GET['pid'].'"  >'.lang('PROJECT_SETUP').'</a>';
        $span='<span class="label label-danger">'.lang('DANGER').'</span>';
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
        $span='<span class="label label-danger">'.lang('DANGER').'</span>';
        $print=PrintTr(lang('TEST_RECORDS_TITLE'),lang('TEST_RECORDS_BODY'),$span,$a);
        $result["TestRecordsErrors"]= array("Results"=>"null","Html"=>$print);
        return $result;
    }else return false;
}
function PrintNumberOfFieldsInForms($DataDictionary,$max_recommended){
    include_once 'classes/Check_number_of_fields_by_form.php';
    $res= new check_number_of_fields_by_form();
    $array=$res::getFormsWithToManyFields($DataDictionary,$max_recommended);
    if (!empty($array)){
        global $new_base_url;
        $link= $new_base_url . "i=" . rawurlencode("views/number_of_fields_by_form_view.php");
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote='.$link.' data-isloaded="false" data-remote-target="#ResultsModal">'.lang('VIEW').'</a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        //$_SESSION["NumberOfFieldsByForm"]= $array;
        $print=PrintTr(lang('MAX_NUMBER_OF_RECORDS_TITLE'),lang('MAX_NUMBER_OF_RECORDS_BODY'),$span,$a);
        $result["NumberOfFieldsByForm"]= array("Results"=>$array,"Html"=>$print);
        return $result;
    }else return false;

}
function PrintValidatedFields($DataDictionary,$min_percentage){
    include_once 'classes/Check_field_validation.php';
    $res= new check_field_validation();
    $array=$res::getMinimumOfValidatedFields($DataDictionary,$min_percentage);

    if (!empty($array)){
        $a= '<u>'.lang('VALIDATED_FIELDS').'</u>'.$array[0].'<br><u>'.lang('TEXT_BOX_FIELDS').'</u>'.$array[1];
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';


        $print=PrintTr(lang('NUMBER_VALIDATED_RECORDS_TITLE'),lang('NUMBER_VALIDATED_RECORDS_BODY'),$span,$a);
        $result["ValidatedFields"]= array("Results"=>"null","Html"=>$print);
        return $result;

    }else{

        return false;
    }

}
function  MyFirstInstrumentError(){
    include_once "classes/Check_my_first_instrument_presence.php";
    $res= new check_my_first_instrument_presence();
    $my_first_instrument_found=$res::IsMyFirstInstrument();
    if ($my_first_instrument_found){
        $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?to_prod_plugin=3&pid='.$_GET['pid'].'"  >'.lang('PROJECT_SETUP').'</a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        $print=PrintTr(lang('MY_FIRST_INSTRUMENT_TITLE'),lang('MY_FIRST_INSTRUMENT_BODY'),$span,$a);
        $result["MyFirstInstrumentError"]= array("Results"=>"null","Html"=>$print);
        return $result;
    }else return false;
}
function  NotDesignatedFormsErrors(){
    include_once "classes/Check_un_designated_longitudinal_forms.php";
    $res= new check_un_designated_longitudinal_forms();
    $array=$res::NotDesignatedForms();
    if (!empty($array)){
        global $new_base_url;
        $link= $new_base_url . "i=" . rawurlencode("views/undesignated_forms_view.php");
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote='.$link.' data-isloaded="false" data-remote-target="#ResultsModal">'.lang('VIEW').' </a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        //$_SESSION["NotDesignatedFormsErrors"]= $array;
        $print=PrintTr(lang('NOT_DESIGNATED_FORMS_TITLE'),lang('NOT_DESIGNATED_FORMS_BODY'),$span,$a);
        $result["NotDesignatedFormsErrors"]= array("Results"=>$array,"Html"=>$print);
        return $result;

    }else return false;
}
function PrintSuccess(){
//TODO: send directly to move to production screen
    $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?to_prod_plugin=3&pid='.$_GET['pid'].'"  >'.lang('PROJECT_SETUP').'</a>';
    $span='<span class="label label-success">'.lang('SUCCESS').'</span>';
    return PrintTr(lang('READY_TO_GO_TITLE'),lang('READY_TO_GO_BODY'),$span,$a);
}

$functName = $_REQUEST['f'];

switch ($functName) {
    case "PrintRulesNames":
        PrintRulesNames();
        break;
    case "OtherOrUnknownErrors":
        $data_dictionary_array= \REDCap::getDataDictionary('array');
        $res = json_encode(PrintOtherOrUnknownErrors($data_dictionary_array, 95));
        echo $res;
        break;
    case "BranchingLogicErrors":
        $data_dictionary_array= \REDCap::getDataDictionary('array');
        $res = json_encode(PrintBranchingLogicErrors($data_dictionary_array));
        echo $res;
        break;
    case "CalculatedFieldsErrors":
        $data_dictionary_array= \REDCap::getDataDictionary('array');
        $res = json_encode(PrintCalculatedFieldsErrors($data_dictionary_array));
        echo $res;
        break;
    case "ASILogicErrors":
        $res = json_encode(PrintASILogicErrors());
        echo $res;
        break;
    case "QueueLogicErrors":
        $res = json_encode(PrintQueueLogicErrors());
        echo $res;
        break;
    case "DataQualityLogicErrors":
        $res = json_encode(PrintDataQualityLogicErrors());
        echo $res;
        break;
    case "ReportsLogicErrors":
        $res = json_encode(PrintReportsLogicErrors());
        echo $res;
        break;
    case "TodayInCalculationsErrors":
        $data_dictionary_array= \REDCap::getDataDictionary('array');
        $res = json_encode(PrintTodayInCalculationsErrors($data_dictionary_array));
        echo $res;
        break;
    case "VariableNamesWithTheSameNameThanAnEventName":
        //echo PrintVariableNamesWithTheSameNameAsAnEventNameErrors($data_dictionary_array);
        break;
    case "DatesConsistentErrors":
        $data_dictionary_array= \REDCap::getDataDictionary('array');
        $res = json_encode(PrintDatesConsistentErrors($data_dictionary_array));
        echo $res;
        break;
    case "YesNoConsistentErrors":
        $data_dictionary_array= \REDCap::getDataDictionary('array');
        $res = json_encode(PrintYesNoConsistentErrors($data_dictionary_array));
        echo $res;

        break;
    case "PositiveNegativeConsistentErrors":
        $data_dictionary_array= \REDCap::getDataDictionary('array');
        $res = json_encode(PrintPositiveNegativeConsistentErrors($data_dictionary_array));
        echo $res;
        break;
    case "IdentifiersError":
        $data_dictionary_array= \REDCap::getDataDictionary('array');
        $res = json_encode(PrintIdentifiersErrors($data_dictionary_array));
        echo $res;
        break;
    case "PIErrors":
        $res = json_encode(PrintPIErrors($Proj));
        echo $res;
        break;
    case "IRBErrors":
        $res = json_encode(PrintIRBErrors($Proj));
        echo $res;

        break;
    case "ResearchErrors":
        $res = json_encode(PrintResearchErrors($Proj));
        echo $res;

        break;
    case "JustForFunErrors":
        $res = json_encode(PrintJustForFunErrors($Proj));
        echo $res;
        break;
    case "TestRecordsErrors":
        $res = json_encode(PrintTestRecordsErrors());
        echo $res;
        break;
    case "NumberOfFieldsByForm":
        $data_dictionary_array= \REDCap::getDataDictionary('array');
        $res = json_encode(PrintNumberOfFieldsInForms($data_dictionary_array, 100));
        echo $res;
        break;

    case "ValidatedFields":
        $data_dictionary_array= \REDCap::getDataDictionary('array');
        $res = json_encode(PrintValidatedFields($data_dictionary_array, 0.05));
        echo $res;
        break;
    case "MyFirstInstrumentError":
        $res = json_encode(MyFirstInstrumentError());
        echo $res;

        break;
    case "NotDesignatedFormsErrors":
        $res = json_encode(NotDesignatedFormsErrors());
        echo $res;

        break;
    case "AllSet":
        echo PrintSuccess();
        break;
    default:
        //echo "<B>Not Valid Rule</B> <br>".$functName;
        break;
}

//todo: Metrics
/*to capture the metrics*/
//require_once 'stanford_metrics.php';




