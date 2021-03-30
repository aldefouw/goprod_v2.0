<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 4/20/18
 * Time: 11:31 AM
 */
namespace Stanford\GoProd;

function  TestRule(){

    global $config_json;

    $Rule['configured_name'] = 'test_records';
    $Rule['title']=lang('TEST_RECORDS_TITLE');

    $body = str_replace('#NUMBER_RECORDS#', $config_json['test_records']['no_records'], lang('TEST_RECORDS_BODY'));
    $body = str_replace('#NUMBER_EXPORTS#', $config_json['test_records']['no_exports'], $body);

    $Rule['body']= $body;
    $Rule['risk']=$config_json['test_records']['type']; // level of risk: warning, danger or info.

    $phat_to_rule= dirname(dirname(__FILE__)) . '/classes/Check_count_test_records_and_exports.php';

    if(!@include_once($phat_to_rule)){ error_log("Failed to include:: $phat_to_rule");}


    $res= new check_count_test_records_and_exports();
    $Rule['results']=$res::CheckTestRecordsAndExports();

//    error_log( print_r($array, TRUE));
    error_log( print_r($Rule, TRUE));
    if(!empty($Rule)){
        return $Rule;
    }else return array();




}
