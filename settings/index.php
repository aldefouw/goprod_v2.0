<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 5/1/17
 * Time: 3:46 PM
 */

namespace Stanford\GoProd;

// echo '<pre>' . print_r($_SESSION["NotDesignatedFormsErrors"], TRUE) . '</pre>';
//require  '../classes/messages.php';

//$file = "../settings/tsconfig.json";
$file = "tsconfig.json";
$json = json_decode(file_get_contents($file),TRUE);



?>
<link rel="stylesheet" href="<?php echo $module->getUrl('styles/settings.css');?>">


<div class="container">
    <h1><?php echo lang('SETTINGS_TITLE');?> </h1>
    <p><?php echo lang('SETTINGS_MAIN_TEXT');?> </p>
    <table id="settings" class="display cell-border" cellspacing="0" WIDTH="90%" >
        <thead>
        <tr>
            <th> <?php echo lang('SETTINGS_RULE');?> </th>

            <th><?php echo lang('SETTINGS_ALERT_LEVEL');?></th>
            <th><?php echo lang('SETTINGS_ACTIVE');?></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="dt-body-left"><?php echo lang('OTHER_OR_UNKNOWN_TITLE');?></td>
            <td class="dt-body-center">
                <select size="1" id="other-unknown-alert-level" name="other-unknown-alert-level"  title="other-unknown-alert-level">
                    <option value="<?php echo lang('INFO');?>" <?php  if (strtolower($json['other_or_unknown']['type'])== strtolower(lang('INFO'))) echo "selected=\"selected\""; ?> >
                        <?php echo lang('INFO');?>
                    </option>
                    <option value=" <?php echo lang('WARNING');?>" <?php  if (strtolower($json['other_or_unknown']['type'])==strtolower(lang('WARNING'))) echo "selected=\"selected\""; ?>>
                        <?php echo lang('WARNING');?>
                    </option>
                    <option value="<?php echo lang('DANGER');?>" <?php  if (strtolower($json['other_or_unknown']['type'])==strtolower(lang('DANGER'))) echo "selected=\"selected\""; ?>>
                        <?php echo lang('DANGER');?>
                    </option>
                </select>
            </td>
            <td class="dt-body-center">
                <label class="switch">
                    <input type="checkbox" name="other-active-selected" value="" <?php  if ($json['other_or_unknown']['active']) echo "checked"; ?>>
                    <div class="slider round"></div>
                </label>
            </td>
        </tr>
        <tr>
            <td> </td>
            <td> </td>
            <td> <div align="right"> <button type="button" class="btn btn-primary">Save</button></div></td>
        </tr>
        </tbody>
    </table>
</div>
<script>
    dataSet  = <?php echo json_encode($json)?>;
    function Update(settings_array, data) {
        console.log(settings_array);
        //return p1 * p2;              // The function returns the product of p1 and p2
    }
    // console.log(dataSet);
    $(document).ready(function() {
        // Update(dataSet);
        var table =  $('#settings').DataTable({
            'responsive': true,
            "searching": false,
            "ordering": false,
            "bInfo" : false,
            "paging": false,
            "columnDefs": [
                { "width": "45%", "targets": 0 },
                { "width": "10%", "targets": 1 },
                { "width": "10%", "targets": 2 },

                {
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   2
                }
            ],select: {
                style:    'os',
                selector: 'td:first-child'
            },
            order: [[ 1, 'asc' ]]
        });
        $('button').click( function() {
            var dataset = table.$('input, select, textarea ').serialize();//input, select, textarea, checkbox
            $.ajax({type: "POST",
                data:dataset,
                url:'save.php',
                success: function (result){
                    // $("#div1").html(result);
                    // window.location.href = "save";
                    location.reload();
                    alert(
                        "The following data would have been submitted to the server: \n\n"
                        //+ data.substr( 0, 120 )+'...'
                    );
                }, error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("some error");
                }

            });

            // console.log(data=>other-unknown-keywords);
            console.log(dataset);
            return false;
        } );
    } );
</script>