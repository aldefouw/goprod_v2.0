<?php
namespace Stanford\GoProd;


function ResearchErrors(){

    $Rule['title']=lang('RESEARCH_PROJECT_TITLE');
    $Rule['body']=lang('RESEARCH_PROJECT_BODY');
    $Rule['risk']="info"; // level of risk: warning, danger or info.

//    $res= new check_other_or_unknown();
//    $Rule['results']=$res::CheckOtherOrUnknown();
//    error_log( print_r($array, TRUE));

    $phat_to_rule= dirname(dirname(__FILE__)) . '/classes/Check_pi_irb_type.php';

    if(!@include_once($phat_to_rule)){ error_log("Failed to include:: $phat_to_rule");}
    $res= new check_pi_irb_type();
    if(!$res::IsAResearchProject()) {
        $Rule['results'] = array();
    } else {
        $Rule['results'] =false;
    }
    //error_log( print_r($Rule, TRUE));
    return $Rule;

}



