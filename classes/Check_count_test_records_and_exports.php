<?php

/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/7/17
 * Time: 5:45 PM
 */

namespace Stanford\GoProd;
// Call the REDCap Connect file in the main "redcap" directory
//require_once "../../../redcap_connect.php";
require_once 'utilities.php';

//NOTICE: when the project is moved to production made the Survey Responses and created records are deleted
// If the project is a copy then the log is reset to 0. that is ok since you may need to test this new project.


/*
 * Me parece robusta tu solución, creo que esta bien asi. Lo único seria ver si puede esto ser mas claro para el usuario, tal vez como dices, poniendo “tested records”
 * y yo agregaría abajo alguna nota: “tested records do not include any recrods that could have been imported into the project when it was created”.
 *  Algo asi…  Me alegro de que todo esta funcionando bien!
 *
 * */





class check_count_test_records_and_exports
{

    public static function CreateResultArray($where, $issue, $link)
    {
        $tmp = array();
        array_push($tmp, $where, $issue, $link);
        $tmp1[0] = $tmp;
        return $tmp1;
    }

    /**
     * @param $string
     * @return mixed|string
     */
    public static function CleanString($string){

        // first preparing the strings.
        //for $string1
        //remove spaces at the end and convert in lowercase
        $word1=trim(strtolower($string));
        //remove spaces between words
        $word1 = str_replace(' ', '_', $word1);
        //remove tabs
        $word1 = preg_replace('/\s+/','_',$word1);
        $word1 = str_replace('__', '_', $word1);

        return $word1;
    }


    /**
     * @return array // Return  Array with number of exports an records created.
     */
    public static function CheckTestRecordsAndExports(){
        global $config_json;

        //project information
        $create_record_array=Array(self::CleanString('Create survey response (Auto calculation)'),self::CleanString('Create survey response'),self::CleanString('Created Response'),self::CleanString('Create record'),self::CleanString('Create record (API)'),self::CleanString( 'Create record (API) (Auto calculation)'),self::CleanString('Create record (Auto calculation)'),self::CleanString('Create record (import)'));
        $export_data_array=Array(self::CleanString('Export data'),self::CleanString('Export data (API Playground)'),self::CleanString( 'Export data (API)'),self::CleanString('Export data (CSV raw with return codes)'));
        $count_records=0;
        $count_exports=0;
        $total= Array();
        $sql = "SELECT description FROM redcap_log_event where project_id=".$_GET['pid'];
        $result = db_query( $sql );
        while ( $result1 = db_fetch_assoc( $result ) )
        {
            if(in_array(self::CleanString($result1[description]), $create_record_array)           ){
                $count_records++;
            }elseif (in_array(self::CleanString($result1[description]),$export_data_array)){
                $count_exports++;
            }
        }

        if($count_records < $config_json['test_records']['no_records'] && $count_exports < $config_json['test_records']['no_exports']) {

            $where = "Insufficient Records & Exports Testing";//TODO: create the lang file variable
            $issue = "There has not been enough testing done in this project.  Please perform additional testing by creating records and exporting test data.";
            $link = '<a target="_blank" class="btn  btn-default review_btn" href=" ' . APP_PATH_WEBROOT . 'DataEntry/record_status_dashboard.php?to_prod_plugin=3&pid=' . $_GET['pid'] . '"  >' . lang('VIEW') . '</a>';
            $array = self::CreateResultArray($where, $issue, $link);

        } else if ($count_records < $config_json['test_records']['no_records']) {

            $where = "Insufficient Records";//TODO: create the lang file variable
            $issue = "There has not been enough testing done in this project.  Please perform additional testing by creating records.";
            $link = '<a target="_blank" class="btn  btn-default review_btn" href=" ' . APP_PATH_WEBROOT . 'DataEntry/record_status_dashboard.php?to_prod_plugin=3&pid=' . $_GET['pid'] . '"  >' . lang('VIEW') . '</a>';
            $array = self::CreateResultArray($where, $issue, $link);

        } else if ($count_exports < $config_json['test_records']['no_exports']) {

            $where = "Insufficient Exports";//TODO: create the lang file variable
            $issue = "There has not been enough testing done in this project.  Please perform additional testing by exporting test data.";
            $link = '<a target="_blank" class="btn  btn-default review_btn" href=" ' . APP_PATH_WEBROOT . 'DataEntry/record_status_dashboard.php?to_prod_plugin=3&pid=' . $_GET['pid'] . '"  >' . lang('VIEW') . '</a>';
            $array = self::CreateResultArray($where, $issue, $link);
        } else {
            $array = array();
        }

        return $array;
    }

}