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

//    $res= new check_other_or_unknown();
//    $Rule['results']=$res::CheckOtherOrUnknown();
//    error_log( print_r($array, TRUE));
    $phat_to_rule= dirname(dirname(__FILE__)) . '/classes/Check_pi_irb_type.php';

    if(!@include_once($phat_to_rule)){ error_log("Failed to include:: $phat_to_rule");}

    $res= new check_pi_irb_type();

    //if this project is just for fun
    if($res::IsJustForFunProject()){
        // send an array with error
        $Rule['results'] = array();
    } else {

        $Rule['results']=false;
    }
    error_log( "ESTO RETORNA JUST FORG+FUUNN");
     error_log( print_r($Rule, TRUE));
    return $Rule;

}


//tiene que retornar en $Rule['results'] un array con datos o vacio si es positivo  o false si no se encotro el problema