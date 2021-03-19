<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 5/8/17
 * Time: 1:19 PM
 */

if ( !$_SERVER['REQUEST_METHOD'] == 'POST'  ) {
    exit();
}

$file = $GLOBALS['modulePath'].'/settings/config.json';

if(file_exists($file)){

    $contents = file_get_contents($file, TRUE);
    $json = json_decode(file_get_contents($file),TRUE);


    if(isset($_POST['other_or_unknown']['type'])) {
        $json['other_or_unknown']['type'] = trim($_POST['other_or_unknown']['type']);
    }
    if(isset($_POST['other_or_unknown']['recommended_values'])) {
        $json['other_or_unknown']['recommended_values'] = trim($_POST['other_or_unknown']['recommended_values']);
    }
    if(isset($_POST['other_or_unknown']['keywords'])) {
        $json['other_or_unknown']['keywords'] = trim($_POST['other_or_unknown']['keywords']);
    }

    if(isset($_POST['yes_no']['type'])) {
        $json['yes_no']['type'] = trim($_POST['yes_no']['type']);
    }
    if(isset($_POST['yes_no']['keywords_yes'])) {
        $json['yes_no']['keywords_yes'] = trim($_POST['yes_no']['keywords_yes']);
    }
    if(isset($_POST['yes_no']['keywords_no'])) {
        $json['yes_no']['keywords_no'] = trim($_POST['yes_no']['keywords_no']);
    }

    if(isset($_POST['test_records']['type'])) {
        $json['test_records']['type'] = trim($_POST['test_records']['type']);
    }
    if(isset($_POST['test_records']['no_exports'])) {
        $json['test_records']['no_records'] = trim($_POST['test_records']['no_records']);
    }
    if(isset($_POST['test_records']['no_exports'])) {
        $json['test_records']['no_exports'] = trim($_POST['test_records']['no_exports']);
    }

    if(isset($_POST['test_records']['type'])) {
        $json['positive_negative']['type'] = trim($_POST['positive_negative']['type']);
    }
    if(isset($_POST['positive_negative']['keywords_positive'])) {
        $json['positive_negative']['keywords_positive'] = trim($_POST['positive_negative']['keywords_positive']);
    }
    if(isset($_POST['positive_negative']['keywords_negative'])) {
        $json['positive_negative']['keywords_negative'] = trim($_POST['positive_negative']['keywords_negative']);
    }

    //If this is selected as active, check here
    $json['other_or_unknown']['active'] = (isset($_POST["other-active-selected"])) ? true : false;
    $json['yes_no']['active'] = (isset($_POST["yes-no-active-selected"])) ? true : false;
    $json['test_records']['active'] = (isset($_POST["test-records-active-selected"])) ? true : false;
    $json['positive_negative']['active'] = (isset($_POST["positive-negative-active-selected"])) ? true : false;


    //Write this JSON to a file
    file_put_contents($file, json_encode($json));

} else {

    echo 'Error.  /config/config.json does not exist!';

}

