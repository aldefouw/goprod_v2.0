<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 5/31/18
 * Time: 3:06 PM
 */

namespace Stanford\GoProd;
include_once "utilities.php";
use \REDCap as REDCap;

class ReadWriteLogging
{
    public $config, $project_id;

    // Instantiate the object with the project_id
    public function __construct($project_id) {
        if ($project_id) {
            $this->project_id = intval($project_id);
        } else {
            logIt("Called outside of context of project", "ERROR");
            exit();
        }
    }

    // Write the current config event to the log
    public function logEvent($rulename,$value) {
        $sql_log = json_encode($this->config);
        REDCap::logEvent("GoProd:Rule", "$rulename = $value", $sql_log, null, null, $this->project_id);
    }

    //Write anything to the log
    public function standardLog($value, $rulename = "Rule"){
        $sql_log = json_encode($this->config);
        REDCap::logEvent("GoProd:".$rulename, $value, $sql_log, null, null, $this->project_id);
    }
}