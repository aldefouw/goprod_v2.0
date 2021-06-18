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
                                Please note that future problems related to the omission of this recommendation may result in additional support costs for your project.
                            <?php } ?>
                        </p>
                    </td>
                </tr>
                <tr><td>
                        <div>
                            <label class="checkbox-inline" for="checkboxes-0">I understand.</label>
                            <input type="checkbox" name="checkboxes" id="checkboxes-0" value="1">
                            <br />
                            <button id="gp_skip_button" name="gp_skip_button" class="btn btn-warning btn-md" disabled="disabled">Skip this recommendation</button>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </fieldset>
</form>
<script type="text/javascript">

    //When the textbox changes, check that a justification and "I understand" has been checked
    $("textarea#textarea").on("change paste keyup", function() {
        //Enable the button for submission if this stuff is checked
        if($('#checkboxes-0').is(':checked') && $(this).val().length) {
            $('button#gp_skip_button').prop('disabled', false)
        } else {
            $('button#gp_skip_button').prop('disabled', true)
        }
    })

    //When the checkbox status changes, check that a justification and "I understand" has been checked
    $('#checkboxes-0').on("change", function() {
        if($("textarea#textarea").val().length > 0 && $(this).is(':checked')){
            $('button#gp_skip_button').prop('disabled', false)
        } else {
            $('button#gp_skip_button').prop('disabled', true)
        }
    })

    //Submit the justification to prevent the rule from showing up in the future
    function SkipSubmitFunction(form)
    {

        let getrulename = "<?php echo $_GET['rule']; ?>";
        let geturl_ajax = "<?php echo $module->getUrl('update_rule_options.php'); ?>";

        $.ajax({
            type: 'get',
            url: geturl_ajax,
            data: {
                rule: '<?php echo $_GET['rule']; ?>',
                text: $(form).find('textarea').val()
            },
           success: function(data) {

                //Let's close the modal
                $("#close_modal").trigger('click');

                //We're going to fade out the rule from view
                $('#'+getrulename).fadeOut();

                //If we can see the number of problems in session storage
                if(sessionStorage.getItem("number_of_problems")){
                    //We just removed one of the "problems" by liccking "Not a Problem"
                    let num_probs = sessionStorage.getItem("number_of_problems") - 1

                    //We need to set the new number of problems on the session level
                    sessionStorage.setItem('number_of_problems', num_probs)

                    //If the number of problems is equal to 0, then let's make the "Go to Production" button appear
                    if(num_probs === 0){

                        //Let's make the "Go to Production" button appear
                        $('#go_prod_accept_all1').fadeIn().prop('hidden', '')

                        //Make the table disappear
                        $('#go_prod_table').hide();

                        //Let's make the "All Set" area appear
                        $('#allset1').fadeIn();
                    }
                }

           }
        });

        return false;
    }
</script>