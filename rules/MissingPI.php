<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 4/20/18
 * Time: 11:31 AM
 */
namespace Stanford\GoProd;


function  MissingPI(){
    $Rule['configured_name'] = 'missing_pi';
    $Rule['title']=lang('PI_TITLE');
    $Rule['body']=lang('PI_BODY');
    $Rule['risk']="danger"; // level of risk: warning, danger or info.

    $phat_to_rule= dirname(dirname(__FILE__)) . '/classes/Check_pi_irb_type.php';

    if(!@include_once($phat_to_rule)){ error_log("Failed to include:: $phat_to_rule");}

    $res= new check_pi_irb_type();
    $Rule['results']=$res::MissingPI();

    return $Rule;
}


/** EXAMPLE OF THE RETURNED ARRAY
 *
Array
(
[title] => Missing PI name and last name.
[body] => For a research project the name of the principal investigator (PI) is required. Please add it in the "Modify project title, purpose, etc." button under the Project Setup-> Modify project title, purpose, etc. -> Name of P.I. (if applicable):.
[risk] => danger
[results] => Array
        (
        [0] => Array
            (
            [0] => Project Setup
            [1] => PI is missing
            [2] => <a target="_blank" class="btn btn-link" href=" /redcap/redcap_v8.9.2/ProjectSetup/index.php?to_prod_plugin=3&pid=15"  >Review</a>
            )

        )

)
 *
 * */