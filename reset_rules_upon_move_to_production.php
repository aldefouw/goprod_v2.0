<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 6/19/18
 * Time: 3:33 PM
 */
namespace Stanford\GoProd;
/** @var \Stanford\GoProd\GoProd $module */

require_once  'classes/ReadWriteLogging.php';

foreach($module->GetListOfAllRules() as $rule){
    ////This is the new setting for this rule within the project
    $new_setting = $module->getProjectSetting($rule, $module->getProjectId());

    //Log all of this to project-specific log
    $res= new ReadWriteLogging($module->getProjectId());
    $res->logEvent($rule, $new_setting);
    $res->standardLog("Reason for Enabling Rule: Moved to Production", $rule);
}

