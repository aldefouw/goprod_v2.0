<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 4/20/18
 * Time: 1:52 PM
 */

namespace Stanford\GoProd;

require_once __DIR__."../../classes/table_formatting.php";

//tiene que retornar en $Rule['results'] un array con datos o vacio si es positivo  o false si no se encotro el problema
function OtherOrUnknown(){
    global $config_json;

    $Rule['configured_name'] = 'other_or_unknown';
    $Rule['title']=lang('OTHER_OR_UNKNOWN_TITLE');
    $Rule['body']=lang('OTHER_OR_UNKNOWN_BODY');
    $Rule['risk']=$config_json['other_or_unknown']['type']; // level of risk: warning, danger or info.
//    $Rule['status'] //actvie- inactive -skiped
    $phat_to_rule= dirname(dirname(__FILE__)) . '/classes/Check_other_or_unknown.php';
    if(!@include_once($phat_to_rule)){ error_log("Failed to include:: $phat_to_rule");}

    $res= new check_other_or_unknown();

    $Rule['results']=TransformToThreeColumns($res::CheckOtherOrUnknown());

//    if(empty($Rule['results'])){
//        $Rule['results']=false;
//    }
    return $Rule;

}