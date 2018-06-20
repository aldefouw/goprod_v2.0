<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 6/19/18
 * Time: 3:33 PM
 */


namespace Stanford\GoProd;
/** @var \Stanford\GoProd\GoProd $module */


//echo "entro en ajax";
//exit;

//include_once  $module->getModulePath().'classes/ReadWriteLogging.php';
//include_once  $module->getUrl('/classes/ReadWriteLogging.php');
include_once  'classes/ReadWriteLogging.php';

// error_log("URLSSSSS" );
// error_log($module->getUrl('/classes/ReadWriteLogging.php'));
                            //$res= new namespace\ReadWriteLogging(15);
                            $res= new ReadWriteLogging($_GET['pid']);
                            //echo $_GET['rule'].$_GET['pid'];
                            //include_once 'classes/ReadWriteLogging.php';
                            $res->UpdateConfig($_GET['rule'],"alvarologAJAXX".rand(2,88));
                            $res->SetConfig($_GET['rule'],"ss");
                            $res->GetConfig($_GET['rule']);
                           // echo $res->PrintConfig($_GET['rule']);
