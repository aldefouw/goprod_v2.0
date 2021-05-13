<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 4/20/18
 * Time: 11:31 AM
 */
namespace Stanford\GoProd;

function PositiveNegative(){

    global $config_json;

    $Rule['configured_name'] = 'positive_negative';
    $Rule['title']=lang('POSITIVE_NEGATIVE_TITLE');
    $Rule['body']=lang('POSITIVE_NEGATIVE_BODY');
    $Rule['risk']=$config_json['positive_negative']['type']; // level of risk: warning, danger or info.

    $phat_to_rule= dirname(dirname(__FILE__)) . '/classes/Check_consistency_for_lists.php';

    if(!@include_once($phat_to_rule)){ error_log("Failed to include:: $phat_to_rule");}

    $res= new check_consistency_for_lists();
    $Rule['results']=$res::IsPositiveNegativeConsistent();

    return  $Rule;

}
