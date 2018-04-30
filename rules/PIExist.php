<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 4/20/18
 * Time: 11:31 AM
 */
namespace Stanford\GoProd;


function  PIExist(){

    $Rule['title']=lang('PI_TITLE');
    $Rule['body']=lang('PI_BODY');
    $Rule['risk']="danger"; // level of risk: warning, danger or info.

    $phat_to_rule= dirname(dirname(__FILE__)) . '/classes/Check_pi_irb_type.php';

    if(!@include_once($phat_to_rule)){ error_log("Failed to include:: $phat_to_rule");}

    $res= new check_pi_irb_type();
    $pi_found=$res::PIExist();
    if (!$pi_found){
        // send an array with error
        $Rule['results'] = array();

        return $Rule;
    }else {$Rule['results']=false;}

return $Rule;


}
