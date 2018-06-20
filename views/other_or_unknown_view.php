<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/14/17
 * Time: 12:23 PM
 */
// Call the REDCap Connect file in the main "redcap" directory
//require_once "../../../redcap_connect.php";
//require  '../classes/messages.php';
//print_r( $_SESSION["OtherOrUnknownErrors"]);

// echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
//echo  $_SESSION["t"];
//echo '<pre>' . print_r($_SESSION["OtherOrUnknownErrors"], TRUE) . '</pre>';
namespace Stanford\GoProd;


/** @var \Stanford\GoProd\GoProd $module */


?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css">
<div class="panel panel-default" style=" width: 100% ">
   <!-- Default panel contents -->
    <div class="panel-heading"><h5> <strong><?php echo lang('OTHER_OR_UNKNOWN_TITLE')?>  </strong></h5></div>
    <div class="panel-body">
        <ul id="myTab" class="nav nav-tabs nav-justified ">
            <li id="focus-tab"><a href="#home" data-target="#home" data-toggle="tab"><?php echo lang('ISSUES')?></a></li>
            <li ><a href="#profile" data-target="#profile" data-toggle="tab"><?php echo lang('SKIP_RULE')?> <span class="glyphicon glyphicon-fast-forward orange_color" aria-hidden="true"></span> </a></li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="home">
                <br>
                    <table id="issues-table" class="table stripe responsive display table-result" width="100%" cellspacing="0"></table>
            </div>
            <div class="tab-pane fade" id="profile">
                  <?php

                  include_once  $module->getModulePath().'classes/ReadWriteLogging.php';
                  $res= new namespace\ReadWriteLogging(14);
                  include_once 'skip_form.php';
                  ?>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" id="close_modal" class="btn btn-default review_btn" data-dismiss="modal"><?php echo lang('CLOSE')?></button>
    </div>
</div>

<script>
    $('#focus-tab').tab('show');
    var columns = [
        { "title":<?php echo json_encode(lang('RESULTS_TABLE_HEADER1'));?>},
        { "title":<?php echo json_encode(lang('RESULTS_TABLE_HEADER2'));?>},
        { "title":<?php echo json_encode(lang('RESULTS_TABLE_HEADER3'));?>}
    ];

    var result = sessionStorage.getItem("OtherOrUnknown");
    dataSet =jQuery.parseJSON(result);
    $(document).ready(function() {
        $('#issues-table').DataTable( {
            data: dataSet,
            "paging":   false,
            "ordering": false,
            "info":     false,
            "searching": false,
            columnDefs: [
                { "title": "Unique Instrument Name",   "targets": 0},
                { "title": "Instrument Label",  "targets": 1 },
                { "title": "Designate Instruments for My Events",  "targets": 2 },
                {"className": "dt-center", "targets": 1},
                {"className": "dt-left", "targets": 0},
                {"className": "dt-center", "targets": 2},
                { "width": "25px", "targets": 2}
            ],
            columns: columns
        } );
    } );
</script>
