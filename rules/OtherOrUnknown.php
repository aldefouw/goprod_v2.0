<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 4/20/18
 * Time: 1:52 PM
 */


namespace Stanford\GoProd;


function OtherOrUnknown(){

    $Rule['title']=lang('OTHER_OR_UNKNOWN_TITLE');
    $Rule['body']=lang('OTHER_OR_UNKNOWN_BODY');
    $Rule['risk']="warning"; // level of risk: warning, danger or info.


    $phat_to_rule= dirname(dirname(__FILE__)) . '/classes/Check_other_or_unknown.php';

    if(!@include_once($phat_to_rule)){ error_log("Failed to include:: $phat_to_rule");}

    $res= new check_other_or_unknown();
    $Rule['results']=$res::CheckOtherOrUnknown();
   // error_log( print_r($Rule, TRUE));
    //if problems not found
    if(empty($Rule['results'])){$Rule['results']=false;}
    return $Rule;

}


//tiene que retornar en $Rule['results'] un array con datos o vacio si es positivo  o false si no se encotro el problema