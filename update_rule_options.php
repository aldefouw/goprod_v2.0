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

////Set the rule to false in the project settings
$module->setProjectSetting($_GET['rule'], 'disabled', $_GET['pid']);

////This is the new setting for this rule within the project
$new_setting = $module->getProjectSetting($_GET['rule'], $_GET['pid']);

//This is where the justification is set
$module->setProjectSetting($_GET['rule'].'Justification', $_GET['justification'], $_GET['pid']);

var_dump($_GET);

//Log all of this to project-specific log
$res= new ReadWriteLogging($_GET['pid']);
$res->logEvent($_GET['rule'], $new_setting);
$res->standardLog("Justification: ".$_GET['justification']);