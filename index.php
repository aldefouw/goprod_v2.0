<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/17/17
 * Time: 12:45 AM
 */
// large proj for testing 5749 , PID 9748 5292

namespace Stanford\GoProd;


/** @var \Stanford\GoProd\GoProd $module */


include_once APP_PATH_DOCROOT . "ProjectGeneral/header.php";

//$module = new GoProd();
global $Proj;

//$test=$module->getSystemSetting("enabled");
//$test=$module->getConfig();
//print_dump($test);
//$enabled_rules = $module->getProjectSetting('enabled_rules')

/*global $rc_autoload_function;

require_once dirname(__FILE__) . "/Classes/Twilio.php";
// Reset the class autoload function because Twilio's classes changed it
spl_autoload_register($rc_autoload_function);
*/


if (!isset($project_id)) {
       die('Project ID is a required field');
    }

 //$temp_name = USERID;
// $users = \REDCap::getUsers();
/* if (!in_array($temp_name, $users)) {
       print "User does NOT have access to this project.";

 }*/

require_once 'classes/messages.php';
require_once 'classes/utilities.php';


// Check if user can create new records, if not Exit.
 //IsProjectAdmin();




//echo $_SERVER['DOCUMENT_ROOT'];
//echo APP_PATH_WEBROOT;
//echo redcap_info();
$status=trim($Proj->project['status']);
// Warning if project is in production mode
if ( $status == 1) {
    echo lang('PRODUCTION_WARNING');
}
//REDCap Version Warning
if (\REDCap::versionCompare(REDCAP_VERSION, '8.1.0') < 0) {
    echo lang('VERSION_INFO');
}

?>



    <link rel="stylesheet" href="<?php echo $module->getUrl("styles/go_prod_styles.css");?>">
    <div class="projhdr"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> <?php echo lang('TITLE'); ?> </div>
    <div id="main-container">
        <div class="gp-text-color"> <span   ><?php echo lang('MAIN_TEXT');?></span> </div>
            <p></p>
        <button id="go_prod_go_btn" class="btn btn-md btn-primary btn-block">
            <span id="gp-run" ><?php echo lang('RUN');?></span>
            <span id="loader-count"></span>
            <span id="gp-extra-time" style="display: none" ><?php echo lang('LOADING_EXTRA_TIME');?> </span>
            <span id="gp-starting" style="display: none" ><?php echo lang('STARTING');?></span>
        </button>
        <div class="progress">
            <div class="progress-bar bg-warning progress-bar-striped "  role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <table  id="go_prod_table" style="display: none"  class="table table-striped" >
                <thead id="go_prod_thead">
                    <tr>

                        <th>
                            <h6 class="col_lable"><strong> <?php echo lang('VALIDATION');?></strong></h6>
                        </th>
                        <th width="100">
                            <h6 class=" col_lable center"><strong><?php echo lang('RESULT');?> </strong></h6>
                        </th>
                        <th width="100">
                            <h6 class=" col_lable center"><strong><?php echo lang('OPTIONS');?></strong></h6>
                        </th>
                    </tr>
                </thead>
                 <!--RESULTS ARE LOADED HERE-->
                <tbody id="go_prod_tbody">
                </tbody>
        </table>

        <div id="gp-loader"  style="display: none"  >
            <div class="lds-ripple"><div></div><div></div></div>
        </div>

<!--SUCCESS!:: IF we can not find any problem then show this        -->
<table class="table table-sm center"  id="allset1" style="display: none; alignment: center" >
   <tr>
       <td style="border: none">
            <strong>

                    <?php echo lang('READY_TO_GO_TITLE'); ?>

            </strong>
       </td>
   </tr>
   <tr>
        <td  style="border: none">
            <span class="fa-5x glyphicon glyphicon-thumbs-up text-success" aria-hidden="true"></span>
        </td>
    </tr>
    <tr class="gp-tr">
        <td class="gp-title-content " style="border: none"> <?php echo lang('READY_TO_GO_BODY'); ?></td>

    </tr>
</table>

    </div>

    <!--REUSABLE MODAL -->

    <div id="ResultsModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog  " role="document">
            <div class="modal-content">
                <div  class="modal-body">
                    <div id="remote-html">
                        <div id="gp-loader"><div class="lds-ripple"><div></div><div></div></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php

$goprod_workflow=$module->getProjectSetting("gopprod-workflow");
if ($goprod_workflow==0){
exit();
}
/*Remove the go to production button if the project is already in production mode*/
if($status == 0){
?>

    <div id='final-info'>
        <br>
        <h4 class="projhdr"><?php echo lang('NOTICE');?></h4>
    <hr>


    <ul class="list-group">
        <li class="list-group-item">
            <h5 class="list-group-item-heading"><?php echo lang('INFO_CITATION');?></h5>
            <p class="list-group-item-text"><?php echo $module->getSystemSetting('citation_text');?>  </p>
        </li>

        <li class="list-group-item">
            <h5 class="list-group-item-heading"><?php echo lang('INFO_STATISTICIAN_REVIEW');?>  </h5>
            <p class="list-group-item-text"> <?php echo lang('INFO_STATISTICIAN_REVIEW_BODY');?> </p>
        </li>
    </ul>

    <br />&nbsp;<br />

    <ul class="list-group">
        <li class="list-group-item">
            <h4 class="list-group-item-heading"><?php echo lang('INFO_WHAT_NETX');?></h4>
            <p class="list-group-item-text"> <?php echo $module->getSystemSetting('next_text');?></p>
        </li>
        <li class="list-group-item">
            <p class="list-group-item-text"><?php echo lang('INFO_WHAT_NETX_BODY_2');?></p>

        </li>
    </ul>

    <!-- em@partners.org: Adding Go to Production button-->
    <div align="center">
        <p class="list-group-item-text"><?php echo lang('I_AGREE_BODY');?></p>
        <button id="go_prod_accept_all1" class=" btn btn-md btn-success text-center "> <?php echo lang('I_AGREE');?> </button>
    </div>
    <!--Ajax calls -->
    <script>
        //psssing php variables
        var project_id=<?php echo $_GET['pid']; ?>;
        var geturl_ajax="<?php echo $module->getUrl('ajax_handler.php'); ?>";
    </script>
    <script type="text/javascript" src="<?php echo $module->getUrl("js/ajax_calls.js");?>"> </script>

    <script type="text/javascript">

        document.getElementById("go_prod_accept_all1").onclick = function(){
            // em@partners.org: 1. There is a bug in the next line that doesn't grab the entire URL address.
            //                     I had to add 'https://' by hand, and the server name by php.
            //                  2. Intented GoProd usage is meant to link the end of GoProd to the Production workflow
            //                     in which the user clicks the "Send request to move to production" button after
            //                     the GoProd takes them to the "Move to Prod" window. That's why we're using the
            //                     tag of to_prod_plugin=3.
            url = <?php  echo json_encode(APP_PATH_WEBROOT.'ExternalModules/?prefix=goprod&page=index&pid='.$_GET['pid'].'&to_prod_plugin=3')?>;
            location.href = url;
        };
    </script>

    <script type="text/javascript">
        /*Auto Run the report if the URL variable is to_prod_plugin=2 */
        $( document ).ready(function() {

            ready_to_prod = <?php echo json_encode($_GET["to_prod_plugin"])?>;

            if (ready_to_prod === '2'){
                $('button[id="go_prod_go_btn"]').trigger('click');
            }

            if (ready_to_prod === '3'){
                production = <?php echo json_encode(APP_PATH_WEBROOT.'ProjectSetup/index.php?pid='.$_GET['pid'].'&to_prod_plugin=1')?>;
                location.href = production;
            }

        });
    </script>

    <?php
}
