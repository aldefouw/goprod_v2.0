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
    //Decode the file contents into JSON
    $json = json_decode(file_get_contents($file),TRUE);

    //Abstract all the fields into succinct foreach loop
    //This way whenever we add a new field, as long as we follow the naming convention, changes are applied
    foreach($json as $key => $value){
        foreach($json[$key] as $k => $v){
            if($k == 'active') {
                $json[$key][$k] = isset($_POST[$key][$k]) ? true: false;
            } else if (isset($_POST[$key][$k])) {
                $json[$key][$k] = trim($_POST[$key][$k]);
            }
        }
    }

    //Write this JSON to a file
    file_put_contents($file, json_encode($json));

} else {

    echo 'Error.  /config/config.json does not exist!';

}

