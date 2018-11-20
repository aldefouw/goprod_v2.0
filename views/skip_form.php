<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 5/3/18
 * Time: 3:45 PM
 */

//namespace Stanford\GoProd;
//include_once "classes/ReadWriteLogging.php";
?>

<form class="form-horizontal" onsubmit="return SkipSubmitFunction()">
    <fieldset>
        <!-- Textarea -->
        <div class="form-group" style="padding: 5%">
            <table>
                <tr>
                    <td>
                        <label for="textarea">
                            Use this option if you consider this is not an issue or if the remain issues are not a problem for your REDCap Database.
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                            <textarea class="form-control" id="textarea" name="textarea">provide a reason..</textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p id="testp">
                            Please notice that future problems related with the omission of this recommendation may result in additional support costs for your project.
                            <?php echo $_GET['rule'].$_GET['pid'];
//                            $res->UpdateConfig($_GET['rule'],"alvarologsss".rand(2,88));
//                            $res->SetConfig($_GET['rule'],"valor");
//                            $res->GetConfig($_GET['rule']);
//                            echo $res->PrintConfig($_GET['rule']);
                            ?>
                        </p>
                    </td>
                </tr>
                <tr><td>
                        <div>
<!--                            <label class="checkbox-inline" for="checkboxes-0">-->
<!--                                <input type="checkbox" name="checkboxes" id="checkboxes-0" value="1">-->
<!--                                I understand.-->
<!--                            </label>-->
                            <button id="gp_skip_button" name="gp_skip_button" class="btn btn-warning   btn-md">Skip this recommendation</button>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </fieldset>
</form>
<script type="text/javascript">
    function SkipSubmitFunction()
    {
        var getrulename="<?php echo '#'.$_GET['rule']; ?>";
        var geturl_ajax="<?php echo $module->getUrl('update_rule_options.php').'&rule='.$_GET['rule']; ?>";
        //console.log(geturl_ajax);
        $.get( geturl_ajax, function() {
            location.reload();
            // $("#close_modal").click();
            // $(getrulename).hide();
            // $("#go_prod_go_btn").click();
        });

         return false;
    }
</script>