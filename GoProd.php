<?php
namespace Stanford\GoProd;
 use ExternalModules\AbstractExternalModule;
include_once "classes/messages.php";

class GoProd extends AbstractExternalModule
{
    function hook_every_page_top($project_id)
	{
        if(PAGE == 'ProjectSetup/index.php' and isset($project_id)){
            ?>
                <script>
                    $(document).ready(function() {
                        //find and hide the current go to prod button
                        var MoveProd=  $( "button[onclick='btnMoveToProd()']" );
                        MoveProd.hide();
                        link =  <?php  echo json_encode('/go_prod/index.php?pid='.$_GET['pid'].'&to_prod_plugin=2')?>;
                        //add the new go to pro button
                        gopro_button= '<button id="go_prod_plugin" class="btn btn-defaultrc btn-xs fs13">'+ '<?php echo lang('GO_PROD');?>' +'</button>';
                        MoveProd.after(gopro_button);
                        document.getElementById("go_prod_plugin").onclick = function () {
                            production =  <?php  echo json_encode($this->getUrl("index.php"))?>;
                            location.href = production;
                        };
                        ready_to_prod = <?php echo json_encode($_GET["to_prod_plugin"])?>;
                        if (ready_to_prod === '1'){
                            MoveProd.click();
                            $( 'div[aria-describedby="certify_prod"]' ).hide();
                            setTimeout(function(){
                                $('.ui-dialog-buttonpane button').click();
                            },500);
                        }

                        if (ready_to_prod === '3'){
                            //in case of IRB ,  PI  or purpose errors found
                             displayEditProjPopup();
                        }
                    });
                </script>
            <?php
        }
	}
}
