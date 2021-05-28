<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 8/14/18
 * Time: 1:19 PM
 */

namespace Stanford\GoProd;

require_once __DIR__."../../classes/table_formatting.php";

function  BranchingLogicErrors(){

    global $config_json;

    $Rule['configured_name'] = 'branching_logic';
    $Rule['title']=lang('BRANCHING_LOGIC_TITLE');
    $Rule['body']=lang('BRANCHING_LOGIC_BODY');
    $Rule['risk']=$config_json['branching_logic']['type']; // level of risk: warning, danger or info.

    $phat_to_rule= dirname(dirname(__FILE__)) . '/classes/Check_presence_of_branching_and_calculated_variables.php';

    if(!@include_once($phat_to_rule)){ error_log("Failed to include:: $phat_to_rule");}

    $res= new check_presence_of_branching_and_calculated_variables();

    $Rule['results']=TransformToThreeColumns($res::CheckIfBranchingLogicVariablesExist());
    
    return  $Rule;
}