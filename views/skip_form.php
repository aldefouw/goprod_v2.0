<form id="<?php echo $_GET['rule']; ?>" class="form-horizontal" onsubmit="return SkipSubmitFunction(this)">
    <fieldset>
        <!-- Textarea -->
        <div class="form-group" style="padding: 5%">
            <table>
                <tr>
                    <td>
                        <label for="textarea">
                            If the issues found are not a problem for your project, please explain why in the text box below.
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <textarea class="form-control" id="textarea" name="textarea" placeholder="provide a reason.."></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p id="testp">
                            <?php
                            if(strlen($module->getSystemSetting('not_a_problem_text'))){
                                echo $module->getSystemSetting('not_a_problem_text');
                            } else { ?>
                                Please note that future problems related to with the omission of this recommendation may result in additional support costs for your project.
                            <?php } ?>
                        </p>
                    </td>
                </tr>
                <tr><td>
                        <div>
                            <label class="checkbox-inline" for="checkboxes-0">
                                <input type="checkbox" name="checkboxes" id="checkboxes-0" value="1">
                                I understand.
                            </label>

                            <br />
                            <button id="gp_skip_button" name="gp_skip_button" class="btn btn-warning   btn-md">Skip this recommendation</button>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </fieldset>
</form>
<script type="text/javascript">
    function SkipSubmitFunction(form)
    {
        let geturl_ajax="<?php echo $module->getUrl('update_rule_options.php'); ?>";

        $.ajax({
            type: 'get',
            url: geturl_ajax,
            data: {
                rule:  '<?php echo $_GET['rule']; ?>',
                text: $(form).find('textarea').val()
            },
           success: function(data) {
               console.log(data)
           }
        });

        return false;
    }
</script>