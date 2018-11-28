<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 8/14/18
 * Time: 1:19 PM
 */

namespace Stanford\GoProd;


function  BranchingLogicErrors(){

    $Rule['title']="this is the tile of the rule";
    $Rule['body']="Here is the explanation  of why this is a problem.....";
    $Rule['risk']="warning"; // level of risk: warning, danger or info.

    $phat_to_rule= dirname(dirname(__FILE__)) . '/classes/Check_presence_of_branching_and_calculated_variables.php';

    if(!@include_once($phat_to_rule)){ error_log("Failed to include:: $phat_to_rule");}

    $res= new check_presence_of_branching_and_calculated_variables();
    $Rule['results']=$res::CheckIfBranchingLogicVariablesExist();

   error_log( "qqqqquiiiiiiiiiiiiiii;;;");
   error_log( print_r($Rule, TRUE));
    error_log( "finnnn;;;");

    return  $Rule;




}