<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/14/17
 * Time: 12:23 PM
 */
// Call the REDCap Connect file in the main "redcap" directory
namespace Stanford\GoProd;

?>




<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><div class="projhdr"> <?php echo lang('MAX_NUMBER_OF_RECORDS_TITLE')?> </div>
    </div>
    <div class="panel-body">
    </div>
    <div style="padding: 1px">
        <table id="number_of_fields_by_form" class=" display " width="100%" cellspacing="0"></table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('CLOSE')?></button>
    </div>
</div>

<script>

    var result = sessionStorage.getItem("NumberOfFieldsByForm");
    dataSet =jQuery.parseJSON(result);



//console.log(dataSet);
    $(document).ready(function() {
        $('#number_of_fields_by_form').DataTable( {
            data: dataSet,
            "paging":   false,
            "ordering": false,
            "info":     false,
            "searching": false,
            columnDefs: [
                { "title": "Instrument Name",   "targets": 0},
                { "title": "Number of Fields",  "targets": 1 },
                {"className": "dt-center", "targets": 1},
                {"className": "dt-left", "targets": 0},
                { "width": "25px", "targets": 1}
            ],
            columns: [

                { "data": "name" },
                { "data": "count" }


            ]

        } );
    } );




</script>

