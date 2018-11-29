<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 4/20/18
 * Time: 11:31 AM
 */
namespace Stanford\GoProd;


function  MissingIRB(){

    $Rule['title']=lang('IRB_TITLE');
    $Rule['body']=lang('IRB_BODY');
    $Rule['risk']="danger"; // level of risk: warning, danger or info.

    $phat_to_rule= dirname(dirname(__FILE__)) . '/classes/Check_pi_irb_type.php';


    if(!@include_once($phat_to_rule)){ error_log("Failed to include:: $phat_to_rule");}

    $res= new check_pi_irb_type();
    $Rule['results']=$res::MissingIRB();


    error_log("*****MissingIRB*************************************************");
    error_log(print_r($Rule, TRUE));
    error_log("******************************************************");


    return  $Rule;
}


/** EXAMPLE OF THE RETURNED ARRAY

Array
(
[title] => IRB Information is not complete.
[body] => For a research project the Institutional Review Board (IRB) Number is required. Please add it in the "Modify project title, purpose, etc." button under the Project Setup
[risk] => danger
[results] => Array
            (
            [0] => Array
                    (
                        [0] => Project Setup
                        [1] => IRB is missing
                        [2] => <a target="_blank" class="btn btn-link" href=" /redcap/redcap_v8.9.2/ProjectSetup/index.php?to_prod_plugin=3&pid=15"  >Review</a>
                    )
            )

)




 * */