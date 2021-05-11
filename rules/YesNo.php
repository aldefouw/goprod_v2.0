<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 4/20/18
 * Time: 11:31 AM
 */
namespace Stanford\GoProd;

function YesNo(){

    global $config_json;

    $Rule['configured_name'] = 'branching_logic';
    $Rule['title']=lang('YES_NO_TITLE');
    $Rule['body']=lang('YES_NO_BODY');
    $Rule['risk']=$config_json['branching_logic']['type']; // level of risk: warning, danger or info.

    $phat_to_rule= dirname(dirname(__FILE__)) . '/classes/Check_consistency_for_lists.php';

    if(!@include_once($phat_to_rule)){ error_log("Failed to include:: $phat_to_rule");}

    $res= new check_consistency_for_lists();
    $Rule['results']=$res::IsYesNoConsistent();

    return  $Rule;

}
