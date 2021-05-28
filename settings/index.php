<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 5/1/17
 * Time: 3:46 PM
 */

namespace Stanford\GoProd;

//This is the ACTUAL configuration
$file = $GLOBALS['modulePath'].'/settings/config.json';

//This is the source we're copying from if the ACTUAL configuration doesn't exist yet
$source = $GLOBALS['modulePath'].'/base_config/config.json';

//If the ACTUAL configuration doesn't exist, copy it form the base configuration
if(!file_exists($file)) copy($source, $file);

//Decode the file into JSON format from the ACTUAL configuration
$json = json_decode(file_get_contents($file),TRUE);
?>
<link rel="stylesheet" href="<?php echo $module->getUrl('styles/settings.css');?>">

<div class="container">
    <h1><?php echo lang('SETTINGS_TITLE');?> </h1>
    <p><?php echo lang('SETTINGS_MAIN_TEXT');?> </p>
    <table id="settings" class="display cell-border" cellspacing="0" cellpadding="0" style="width: 100%;" width="100%">
        <thead>
        <tr>
            <th> <?php echo lang('SETTINGS_RULE');?> </th>

            <th><?php echo lang('SETTINGS_ALERT_LEVEL');?></th>
            <th></th>
            <th></th>
            <th><?php echo lang('SETTINGS_ACTIVE');?></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="dt-body-left"><?php echo lang('OTHER_OR_UNKNOWN_TITLE');?></td>
            <td class="dt-body-center">
                <select size="1" id="other-unknown-alert-level" name="other_or_unknown[type]"  title="other-unknown-alert-level">
                    <option value="<?php echo lang('INFO');?>" <?php  if (strtolower($json['other_or_unknown']['type']) == strtolower(lang('INFO'))) echo "selected=\"selected\""; ?> >
                        <?php echo lang('INFO');?>
                    </option>
                    <option value=" <?php echo lang('WARNING');?>" <?php  if (strtolower($json['other_or_unknown']['type']) == strtolower(lang('WARNING'))) echo "selected=\"selected\""; ?>>
                        <?php echo lang('WARNING');?>
                    </option>
                    <option value="<?php echo lang('DANGER');?>" <?php  if (strtolower($json['other_or_unknown']['type']) == strtolower(lang('DANGER'))) echo "selected=\"selected\""; ?>>
                        <?php echo lang('DANGER');?>
                    </option>
                </select>
            </td>
            <td><?php echo lang('RECOMMENDED_VALUES');?>
                <textarea name="other_or_unknown[recommended_values]" style="min-width: 300px; min-height: 200px;"><?php echo $json['other_or_unknown']['recommended_values']; ?></textarea>
            </td>
            <td>
                <?php echo lang('RECOMMENDED_KEYWORDS');?>
                <textarea name="other_or_unknown[keywords]" style="min-width: 300px; min-height: 200px;"><?php echo $json['other_or_unknown']['keywords']; ?></textarea>
            </td>
            <td class="dt-body-center">
                <label class="switch">
                    <input type="checkbox" name="other_or_unknown[active]" value="" <?php  if ($json['other_or_unknown']['active']) echo "checked"; ?>>
                    <div class="slider round"></div>
                </label>
            </td>
        </tr>

        <tr>
            <td class="dt-body-left"><?php echo lang('YES_NO_TITLE');?></td>
            <td class="dt-body-center">
                <select size="1" id="other-yes-no-alert-level" name="yes_no[type]"  title="other-yes-no-alert-level">
                    <option value="<?php echo lang('INFO');?>" <?php  if (strtolower($json['yes_no']['type'])== strtolower(lang('INFO'))) echo "selected=\"selected\""; ?> >
                        <?php echo lang('INFO');?>
                    </option>
                    <option value=" <?php echo lang('WARNING');?>" <?php  if (strtolower($json['yes_no']['type'])==strtolower(lang('WARNING'))) echo "selected=\"selected\""; ?>>
                        <?php echo lang('WARNING');?>
                    </option>
                    <option value="<?php echo lang('DANGER');?>" <?php  if (strtolower($json['yes_no']['type'])==strtolower(lang('DANGER'))) echo "selected=\"selected\""; ?>>
                        <?php echo lang('DANGER');?>
                    </option>
                </select>
            </td>
            <td>
                <?php echo lang('KEYWORDS_YES');?>
                <textarea name="yes_no[keywords_yes]" style="min-width: 300px; min-height: 200px;"><?php echo $json['yes_no']['keywords_yes']; ?></textarea>
            </td>
            <td>
                <?php echo lang('KEYWORDS_NO');?>
                <textarea name="yes_no[keywords_no]" style="min-width: 300px; min-height: 200px;"><?php echo $json['yes_no']['keywords_no']; ?></textarea>
            </td>
            <td class="dt-body-center">
                <label class="switch">
                    <input type="checkbox" name="yes_no[active]"" value="" <?php  if ($json['yes_no']['active']) echo "checked"; ?>>
                    <div class="slider round"></div>
                </label>
            </td>
        </tr>

        <tr>
            <td class="dt-body-left"><?php echo lang('TEST_RECORDS_TITLE');?></td>
            <td class="dt-body-center">
                <select size="1" id="test-records-alert-level" name="test_records[type]"  title="test-records-alert-level">
                    <option value="<?php echo lang('INFO');?>" <?php  if (strtolower($json['test_records']['type'])== strtolower(lang('INFO'))) echo "selected=\"selected\""; ?> >
                        <?php echo lang('INFO');?>
                    </option>
                    <option value=" <?php echo lang('WARNING');?>" <?php  if (strtolower($json['test_records']['type'])==strtolower(lang('WARNING'))) echo "selected=\"selected\""; ?>>
                        <?php echo lang('WARNING');?>
                    </option>
                    <option value="<?php echo lang('DANGER');?>" <?php  if (strtolower($json['test_records']['type'])==strtolower(lang('DANGER'))) echo "selected=\"selected\""; ?>>
                        <?php echo lang('DANGER');?>
                    </option>
                </select>
            </td>
            <td>
                <?php echo lang('NUMBER_RECORDS');?>
                <textarea name="test_records[no_records]" style="min-width: 300px; min-height: 200px;"><?php echo $json['test_records']['no_records']; ?></textarea>
            </td>
            <td>
                <?php echo lang('NUMBER_EXPORTS');?>
                <textarea name="test_records[no_exports]" style="min-width: 300px; min-height: 200px;"><?php echo $json['test_records']['no_exports']; ?></textarea>
            </td>
            <td class="dt-body-center">
                <label class="switch">
                    <input type="checkbox" name="test_records[active]" value="" <?php  if ($json['test_records']['active']) echo "checked"; ?>>
                    <div class="slider round"></div>
                </label>
            </td>
        </tr>

        <tr>
            <td class="dt-body-left"><?php echo lang('POSITIVE_NEGATIVE_TITLE');?></td>
            <td class="dt-body-center">
                <select size="1" id="positive-negative-alert-level" name="positive_negative[type]"  title="positive-negative-alert-level">
                    <option value="<?php echo lang('INFO');?>" <?php  if (strtolower($json['positive_negative']['type'])== strtolower(lang('INFO'))) echo "selected=\"selected\""; ?> >
                        <?php echo lang('INFO');?>
                    </option>
                    <option value=" <?php echo lang('WARNING');?>" <?php  if (strtolower($json['positive_negative']['type'])==strtolower(lang('WARNING'))) echo "selected=\"selected\""; ?>>
                        <?php echo lang('WARNING');?>
                    </option>
                    <option value="<?php echo lang('DANGER');?>" <?php  if (strtolower($json['positive_negative']['type'])==strtolower(lang('DANGER'))) echo "selected=\"selected\""; ?>>
                        <?php echo lang('DANGER');?>
                    </option>
                </select>
            </td>
            <td>
                <?php echo lang('KEYWORDS_POSITIVE');?>
                <textarea name="positive_negative[keywords_positive]" style="min-width: 300px; min-height: 200px;"><?php echo $json['positive_negative']['keywords_positive']; ?></textarea>
            </td>
            <td>
                <?php echo lang('KEYWORDS_NEGATIVE');?>
                <textarea name="positive_negative[keywords_negative]" style="min-width: 300px; min-height: 200px;"><?php echo $json['positive_negative']['keywords_negative']; ?></textarea>
            </td>
            <td class="dt-body-center">
                <label class="switch">
                    <input type="checkbox" name="positive_negative[active]" value="" <?php  if ($json['positive_negative']['active']) echo "checked"; ?>>
                    <div class="slider round"></div>
                </label>
            </td>
        </tr>

        <tr>
            <td class="dt-body-left"><?php echo lang('BRANCHING_LOGIC_TITLE');?></td>
            <td class="dt-body-center">
                <select size="1" id="branching-logic-alert-level" name="branching_logic[type]"  title="branching-logic-alert-level">
                    <option value="<?php echo lang('INFO');?>" <?php  if (strtolower($json['branching_logic']['type'])== strtolower(lang('INFO'))) echo "selected=\"selected\""; ?> >
                        <?php echo lang('INFO');?>
                    </option>
                    <option value=" <?php echo lang('WARNING');?>" <?php  if (strtolower($json['branching_logic']['type'])==strtolower(lang('WARNING'))) echo "selected=\"selected\""; ?>>
                        <?php echo lang('WARNING');?>
                    </option>
                    <option value="<?php echo lang('DANGER');?>" <?php  if (strtolower($json['branching_logic']['type'])==strtolower(lang('DANGER'))) echo "selected=\"selected\""; ?>>
                        <?php echo lang('DANGER');?>
                    </option>
                </select>
            </td>
            <td>
                <?php echo lang('BRANCHING_LOGIC_BODY');?>
            </td>

            <td>

            </td>
            <td class="dt-body-center">
                <label class="switch">
                    <input type="checkbox" name="branching_logic[active]" value="" <?php  if ($json['branching_logic']['active']) echo "checked"; ?>>
                    <div class="slider round"></div>
                </label>
            </td>
        </tr>

        <tr>
            <td class="dt-body-left"><?php echo lang('PI_TITLE');?></td>
            <td class="dt-body-center">
                <select size="1" id="missing-pi-alert-level" name="missing_pi[type]"  title="missing-pi-alert-level">
                    <option value="<?php echo lang('INFO');?>" <?php  if (strtolower($json['missing_pi']['type'])== strtolower(lang('INFO'))) echo "selected=\"selected\""; ?> >
                        <?php echo lang('INFO');?>
                    </option>
                    <option value=" <?php echo lang('WARNING');?>" <?php  if (strtolower($json['missing_pi']['type'])==strtolower(lang('WARNING'))) echo "selected=\"selected\""; ?>>
                        <?php echo lang('WARNING');?>
                    </option>
                    <option value="<?php echo lang('DANGER');?>" <?php  if (strtolower($json['missing_pi']['type'])==strtolower(lang('DANGER'))) echo "selected=\"selected\""; ?>>
                        <?php echo lang('DANGER');?>
                    </option>
                </select>
            </td>
            <td>
                <?php echo lang('PI_BODY');?>
            </td>
            <td>

            </td>
            <td class="dt-body-center">
                <label class="switch">
                    <input type="checkbox" name="missing_pi[active]" value="" <?php  if ($json['missing_pi']['active']) echo "checked"; ?>>
                    <div class="slider round"></div>
                </label>
            </td>
        </tr>

        <tr>
            <td class="dt-body-left"><?php echo lang('IRB_TITLE');?></td>
            <td class="dt-body-center">
                <select size="1" id="missing-irb-alert-level" name="missing_irb[type]"  title="missing-irb-alert-level">
                    <option value="<?php echo lang('INFO');?>" <?php  if (strtolower($json['missing_irb']['type'])== strtolower(lang('INFO'))) echo "selected=\"selected\""; ?> >
                        <?php echo lang('INFO');?>
                    </option>
                    <option value=" <?php echo lang('WARNING');?>" <?php  if (strtolower($json['missing_irb']['type'])==strtolower(lang('WARNING'))) echo "selected=\"selected\""; ?>>
                        <?php echo lang('WARNING');?>
                    </option>
                    <option value="<?php echo lang('DANGER');?>" <?php  if (strtolower($json['missing_irb']['type'])==strtolower(lang('DANGER'))) echo "selected=\"selected\""; ?>>
                        <?php echo lang('DANGER');?>
                    </option>
                </select>
            </td>
            <td>
                <?php echo lang('IRB_BODY');?>
            </td>
            <td>

            </td>
            <td class="dt-body-center">
                <label class="switch">
                    <input type="checkbox" name="missing_irb[active]" value="" <?php  if ($json['missing_irb']['active']) echo "checked"; ?>>
                    <div class="slider round"></div>
                </label>
            </td>
        </tr>

        <tr>
            <td class="dt-body-left"><?php echo lang('JUST_FOR_FUN_TITLE');?></td>
            <td class="dt-body-center">
                <select size="1" id="just-for-fun-alert-level" name="just_for_fun[type]"  title="just-for-fun-alert-level">
                    <option value="<?php echo lang('INFO');?>" <?php  if (strtolower($json['just_for_fun']['type'])== strtolower(lang('INFO'))) echo "selected=\"selected\""; ?> >
                        <?php echo lang('INFO');?>
                    </option>
                    <option value=" <?php echo lang('WARNING');?>" <?php  if (strtolower($json['just_for_fun']['type'])==strtolower(lang('WARNING'))) echo "selected=\"selected\""; ?>>
                        <?php echo lang('WARNING');?>
                    </option>
                    <option value="<?php echo lang('DANGER');?>" <?php  if (strtolower($json['just_for_fun']['type'])==strtolower(lang('DANGER'))) echo "selected=\"selected\""; ?>>
                        <?php echo lang('DANGER');?>
                    </option>
                </select>
            </td>
            <td>
                <?php echo lang('JUST_FOR_FUN_BODY');?>
            </td>
            <td>

            </td>
            <td class="dt-body-center">
                <label class="switch">
                    <input type="checkbox" name="just_for_fun[active]" value="" <?php  if ($json['just_for_fun']['active']) echo "checked"; ?>>
                    <div class="slider round"></div>
                </label>
            </td>
        </tr>


        <tr>
            <td> </td>
            <td> </td>
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
                url: <?php echo APP_PATH_WEBROOT; ?> + "ExternalModules/?prefix=goprod&page=settings/save",
                success: function (result){
                    alert("You have successfully saved this configuration.")

                    console.log(result)

                    //location.reload();

                }, error: function(XMLHttpRequest, textStatus, errorThrown) {

                    alert('An error occurred when attempting to save your setup to the tsconfig.json file.');

                    console.log(XMLHttpRequest);
                    console.log(textStatus);
                    console.log(errorThrown);
                }

            });

            // console.log(data=>other-unknown-keywords);
            console.log(dataset);
            return false;
        } );
    } );
</script>