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

    //Abstract all the fields into succinct foreach loop
    //This way whenever we add a new field, as long as we follow the naming convention, changes are applied
    foreach($_POST as $key => $value){
        foreach($_POST[$key] as $k => $v){
            if(isset($_POST[$key][$k])) {
                $json[$key][$k] = trim($_POST[$key][$k]);
            }
        }
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

