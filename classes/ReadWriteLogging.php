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

//        global $Proj;
//        if ($Proj == null) {
//            $Proj = new Project($project_id);
//        }
//        $this->longitudinal = $Proj->longitudinal;
    }


    // Scans the log for the latest Rule configuration
    public function GetConfig($rulename) {
//		logIt(__FUNCTION__, "DEBUG");

        // Convert old querystring-based autonotify configurations to the log-based storage method
        //$this->checkForUpgrade();
        // Load from the log
        $sql = "SELECT l.sql_log, l.ts
			FROM redcap_log_event l WHERE
		 		l.project_id = " . intval($this->project_id) . "
			-- AND l.page = 'PLUGIN'
			AND l.description = 'GoProd:$rulename'
			ORDER BY ts DESC LIMIT 1";
        $q = db_query($sql);
//		logIt(__FUNCTION__ . ": sql: $sql","DEBUG");
        if (db_num_rows($q) == 1) {
            // Found config!
            $row = db_fetch_assoc($q);
            $this->config = json_decode($row['sql_log'], true);


            if (isset($this->config['triggers'])) {
                $this->triggers = json_decode(htmlspecialchars_decode($this->config['triggers'], ENT_QUOTES), true);
            }
            //logIt(__FUNCTION__ . ": Found version with ts ". $row['ts'],"INFO");
            return true;
        } else {
            // No previous config was found in the logs
            logIt(__FUNCTION__ . ": No config saved in logs for this project", "INFO");
            return false;
        }
    }

    // Write the current config to the log
    public function SetConfig($rulename,$value) {
        $sql_log = json_encode($this->config);
        REDCap::logEvent("GoProd:$rulename", "$rulename= $value", $sql_log, null, null, $this->project_id);
        logIt(__FUNCTION__ . ": Saved configuration", "INFO");

        // Update the DET url if needed
      //  self::isDetUrlNotAutoNotify(true);
//        $this->saveConfig2();
    }

    public function UpdateConfig($rulename,$value){
         $this->config[$rulename]=$value;
    }

    public function PrintConfig($rulename){

        return $this->config[$rulename];

    }

// input: all rule names array , returns array of currently active rules
    public function GetActiveRules($AllRules){
        //$array= array();
        foreach ($AllRules as $rule){
              $this->GetConfig($rule);
              error_log("AQUI##  $rule");
              //error_log(print_r($AllRules,TRUE));
              error_log(print_r($this->config,TRUE));
              error_log("AQUI## FIN");
              $test=(string)$this->PrintConfig($rule);
              if($test==='0'){
                  error_log("all test: $test and ruel is  $rule");
                  error_log($test);
                  error_log("all rules: ");
                  error_log(print_r($AllRules,TRUE));
                  $index = array_search($rule, $AllRules);
                  if($index !== false){
                      unset($AllRules[$index]);
                  }else
                  {
                      error_log("entro al ese  y el index es:::$index");
                      exit();
                  }

                  error_log("reglas22 removiendolas rules:::::::$AllRules::::::::$index");
                  error_log(print_r($AllRules,TRUE));
              }
        }
     return $AllRules;
    }
}