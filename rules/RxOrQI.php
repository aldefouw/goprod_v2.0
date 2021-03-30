<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 4/20/18
 * Time: 1:52 PM
 */


namespace Stanford\GoProd;

/* EM@partners.org*/


function RxOrQI(){

    $Rule['configured_name'] = 'rx_or_qi';
    $Rule['title']=lang('NOT_RX_OR_QI_TITLE');
    $Rule['body']=lang('NOT_RX_OR_QI_BODY');
    $Rule['risk']="danger"; // level of risk: warning, danger or info.

    $phat_to_rule= dirname(dirname(__FILE__)) . '/classes/Check_pi_irb_type.php';

    if(!@include_once($phat_to_rule)){ error_log("Failed to include:: $phat_to_rule");}
    $res= new check_pi_irb_type();
    $Rule['results']=$res::IsRxOrQI();
    return  $Rule;
}
