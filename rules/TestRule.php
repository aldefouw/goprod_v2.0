<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 4/20/18
 * Time: 11:31 AM
 */
namespace Stanford\GoProd;


function  TestRule(){

    $Rule['title']="this is the tile of the rule";
    $Rule['body']="Here is the explanation  of why this is a problem.....";
    $Rule['risk']="warning"; // level of risk: warning, danger or info.

    $phat_to_rule= dirname(dirname(__FILE__)) . '/classes/Check_other_or_unknown.php';

    if(!@include_once($phat_to_rule)){ error_log("Failed to include:: $phat_to_rule");}


    $res= new check_other_or_unknown();
    $Rule['results']=$res::CheckOtherOrUnknown();

//    error_log( print_r($array, TRUE));
    error_log( print_r($Rule, TRUE));
    if(!empty($Rule)){
        return $Rule;
    }else return array();




}
