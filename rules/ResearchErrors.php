<?php
namespace Stanford\GoProd;


function ResearchErrors(){

    $Rule['configured_name'] = 'research_errors';
    $Rule['title']=lang('RESEARCH_PROJECT_TITLE');
    $Rule['body']=lang('RESEARCH_PROJECT_BODY');
    $Rule['risk']="info"; // level of risk: warning, danger or info.

    $phat_to_rule= dirname(dirname(__FILE__)) . '/classes/Check_pi_irb_type.php';

   // $test= new CreateRuleHelper();

    if(!@include_once($phat_to_rule)){ error_log("Failed to include:: $phat_to_rule");}
    $res= new check_pi_irb_type();
    $Rule['results']=$res::IsAResearchProject();
    return  $Rule;
}



