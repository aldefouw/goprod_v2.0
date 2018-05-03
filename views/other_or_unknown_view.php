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
?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css">
<div class="panel panel-default" style=" width: 100% ">


   <!-- Default panel contents -->
    <div class="panel-heading"><h5> <strong><?php echo lang('OTHER_OR_UNKNOWN_TITLE')?>  </strong></h5></div>
    <div class="panel-body">

        <ul id="myTab" class="nav nav-tabs nav-justified ">
            <li id="focus-tab"><a href="#home" data-target="#home" data-toggle="tab">Issues</a></li>
            <li ><a href="#profile" data-target="#profile" data-toggle="tab">Is this not a problem? </a></li>
        </ul>

        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="home">
                <div style="padding: 0">
                    <table id="issues-table" class="table stripe responsive display table-result" width="100%" cellspacing="0"></table>
                </div>
            </div>
            <div class="tab-pane fade" id="profile">
                <table>
                    <tr>
                        <td><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                                It has survived not only five centuries, but also the leap into electronic typesetting,
                                remaining essentially unchanged. It was popularised in the 1960s with the release of
                                Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                                software like Aldus PageMaker including versions of Lorem Ipsum.</p></td>
                        <td>
                            <button type="button" class="btn btn-default review_btn" data-dismiss="modal"><?php echo lang('CLOSE')?></button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default review_btn" data-dismiss="modal"><?php echo lang('CLOSE')?></button>
    </div>

</div>




<script>

    $('#focus-tab').tab('show');
    var columns = [
        { "title":<?php echo json_encode(lang('RESULTS_TABLE_HEADER1'));?> },
        { "title":<?php echo json_encode(lang('RESULTS_TABLE_HEADER1'));?>},
        { "title":<?php echo json_encode(lang('RESULTS_TABLE_HEADER1'));?>},
        { "title":<?php echo json_encode(lang('RESULTS_TABLE_HEADER2'));?>},
        { "title":<?php echo json_encode(lang('RESULTS_TABLE_HEADER3'));?>}
    ];
    //var columns = [
    //    { "title":"asdf" },
    //    { "title": "asdf"},
    //    { "title":"asdf"},
    //    { "title":"asdf"},
    //    { "title":<?php //echo json_encode(lang('RESULTS_TABLE_HEADER3'));?>//}
    //];

    var result = sessionStorage.getItem("OtherOrUnknown");
    dataSet =jQuery.parseJSON(result);

    // console.log("session storage");
    // for (i = 0; i < sessionStorage.length; i++) {
    //     console.log(sessionStorage.key(i) + "=[" + sessionStorage.getItem(sessionStorage.key(i)) + "]");
    // }


    $(document).ready(function() {



        var table =  $('#issues-table').DataTable({

             "paging":         false,
            "searching": false,
            //"lengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
            // "scrollY":        "500px",
            // "scrollCollapse": true,
            // "paging":         false,

            data: dataSet,
            columns: columns,

            "columnDefs": [
                { "visible": false, "targets": 0 },
                {"className": "dt-left", "targets": 2},
                {"className": "dt-left", "targets": 3},
                {"className": "dt-center", "targets": 4},
                { "width": "25px", "targets": 4}

            ],
            "order": [[ 0, 'asc' ]],
            "displayLength": 15,
            "drawCallback": function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;

                api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="group"><td colspan="4"><h5>Instrument: <strong><u>'+group+'</u></strong></h5></td></tr>'

                        );

                        last = group;
                    }
                } );
            }
        } );


        // Order by the grouping
        $('#issues-table tbody').on( 'click', 'tr.group', function () {
            var currentOrder = table.order()[0];
            if ( currentOrder[0] === 0 && currentOrder[1] === 'asc' ) {
                table.order( [ 0, 'desc' ] ).draw();
            }
            else {
                table.order( [ 0, 'asc' ] ).draw();
            }
        }



        );
    } );

</script>

