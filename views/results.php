<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/14/17
 * Time: 12:23 PM
 */

namespace Stanford\GoProd;


/** @var \Stanford\GoProd\GoProd $module */


?>


<div class="card text-center" style=" width: 100% ">
   <!-- Default panel contents -->
    <div class="card-header">

        <div class="btn-group  btn-pref " role="group"  id="gp-btn-group d-flex" aria-label="Issues Menu">

            <button type="button" class="btn btn-primary gp-btn-bar-color gp-btn-bar "  href="#tab_issues"  >
                <span>
                    <i class="fas fa-wrench"></i>
                </span>
                <div><?php echo lang('ISSUES')?></div>
            </button>
            <button type="button" class="btn btn-outline-primary gp-btn-bar" href="#tab_skip"  >
                <span>
                    <i class="fas fa-share"></i>
                </span>
                <div><?php  echo lang('SKIP_RULE')?></div>
            </button>

        </div>

    </div>
    <div class="card-body">
           <div class="gtp-card fade show active" id="tab_issues"   role="tabpanel" aria-labelledby="pills-home-tab">
                <table id="issues-table" class="table responsive display table-result" width="100%" cellspacing="0"></table>
          </div>

          <div class="gtp-card" id="tab_skip"  style="display: none;" role="tabpanel" aria-labelledby="pills-profile-tab">
                <?php
                include_once  $module->getModulePath().'classes/ReadWriteLogging.php';
                $res= new namespace\ReadWriteLogging($_GET['pid']);
                include_once 'skip_form.php';
                ?>
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
    var getrulename="<?php echo $_GET['rule']; ?>";
    var result = sessionStorage.getItem(getrulename);

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

        var gp_btn_bar =$(".gp-btn-bar");
        gp_btn_bar.click(function () {
            gp_btn_bar.removeClass("btn-primary gp-btn-bar-color").addClass("btn-outline-primary");
            $(this).removeClass("btn-outline-primary").addClass("btn-primary gp-btn-bar-color");
            var href = $(this).attr('href');
            $(".gtp-card").removeClass("gtp-card fade show active").addClass("gtp-card").hide();
            $(href).addClass("fade show active").show();
        });
    } );
</script>
