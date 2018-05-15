<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 5/3/18
 * Time: 3:45 PM
 */
?>

<form class="form-horizontal">
    <fieldset>



        <!-- Textarea -->
        <div class="form-group" style="padding: 5%">
            <table   >
                <tr>

                    <td>
                        <label for="textarea">
                            Use this option if you consider this is not an issue or if the remain issues are not a problem for your REDCap Database.
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                            <textarea class="form-control" id="textarea" name="textarea">default text</textarea>
                        </td>
                </tr>
                <tr>
                    <td>
                        <p>
                            Please note that future problems with omitting this recommendation may result in additional support costs for your project.
                        </p>
                    </td>
                </tr>
                <tr><td>
                        <div  >
                            <label class="checkbox-inline" for="checkboxes-0">
                                <input type="checkbox" name="checkboxes" id="checkboxes-0" value="1">
                                1
                            </label>
                            <button id="singlebutton" name="singlebutton" class="btn btn-default btn-sm">Send</button>
                        </div>
                    </td>
                </tr>
            </table>



        </div>






    </fieldset>
</form>

