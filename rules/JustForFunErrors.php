<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 4/20/18
 * Time: 1:52 PM
 */


namespace Stanford\GoProd;


function JustForFunErrors(){

    $Rule['title']=lang('JUST_FOR_FUN_PROJECT_TITLE');
    $Rule['body']=lang('JUST_FOR_FUN_PROJECT_BODY');
    $Rule['risk']="danger"; // level of risk: warning, danger or info.

    $phat_to_rule= dirname(dirname(__FILE__)) . '/classes/Check_pi_irb_type.php';

    if(!@include_once($phat_to_rule)){ error_log("Failed to include:: $phat_to_rule");}
    $res= new check_pi_irb_type();
    $Rule['results']=$res::IsJustForFunProject();
    return  $Rule;
}
//tiene que retornar en $Rule['results'] un array con datos  o false si no se encotro el problema