/**
 * Created by alvaro1 on 4/12/17.
 */


function GetPath(rulename,project_id){
    url= geturl_ajax+"&f="+rulename;
    return url;
}

function loadResults(rules,project_id){
   count_rules=0;
   total_rules= rules.length;
   count_problems_found=0;
    $("#go_prod_tbody").hide();
    $('#go_prod_table').fadeIn();
    $('#gp-starting').hide();
    $('#loader-count').text(" 0% ");
    $.each( rules, function( i, val ) {
           // var urlcall="classes/ajax_handler.php?f="+val+"&pid="+project_id;
            var urlcall=GetPath(val,project_id);
            //console.log(urlcall);
            $.get( urlcall, function(data) {
                    if(data !== "false") {
                        count_problems_found++;
                        var json_parsed = jQuery.parseJSON(data);
                        sessionStorage.setItem(val, JSON.stringify(json_parsed[val]["Results"]));
                        //printing the data Html in the index page
                        data = json_parsed[val]["Html"];
                       ////console.log($new);
                       var $new =$(data);
                        $("#go_prod_tbody").append($new);

                        $("#go_prod_tbody").show('slow');
                        $new.slideDown('slow');
                    }
                    //progress bar start
                    count_rules++;
                //time out in case a big datadictionary
                var timer = window.setTimeout(function(){
                    $('#gp-extra-time').show();
                }, 10000);
                    $('.progress .progress-bar').css("width",
                        function() {
                            var newprogress=(count_rules/total_rules) * 100;
                            newprogress= parseInt(newprogress, 10);
                             $('#loader-count').text("  "+count_rules+"/"+total_rules+ " ("+newprogress+"%)" );
                            //$('#loader-count').text(" "+newprogress+"%" );
                            if(count_rules===total_rules){
                                if(count_problems_found===0){
                                    AllSet();
                                }
                                Addstyles();
                            }
                            if (newprogress===100){
                                    $('#gp-loader').hide();//hide loader when finish
                                    $('.gp-actions-load').hide();
                                    if(timer) {
                                        clearTimeout(timer);
                                        $('#gp-extra-time').text("");
                                        //$('#gp-extra-time').hide();
                                       //$('#gp-loader-extra-time').hide();
                                    }
                                     $('.gp-actions-link').fadeIn(1500);
                                     $('#gp-run').show();
                                 }
                            return $(this).attr('aria-valuenow', newprogress+"%").css('width',newprogress+"%");
                        }
                    ); //progress bar end
            });
    });

}

function Workflow(result,project_id ){
    var urlcall=GetPath("JustForFunErrors",project_id);
        $.get( urlcall, function(data) {
            $('#final-info').fadeIn("slow");
            //console.log(data);
            var json_parsed = jQuery.parseJSON(data);
            if(data !== "false"){
                data=json_parsed["JustForFunErrors"]["Html"];
                $('#go_prod_table').fadeIn();
                $("#go_prod_tbody").append(data);
                Addstyles();
                $('.gp-info-content').children('.gp-body-content').show();
                $('.loader').hide();
                $('.gp-actions-link').show();
                $('.gp-tr').show();
                $('#gp-run').show();
                $('#gp-starting').hide();
            }
            else{
                //checking if it's not research
                var notresearch=GetPath("ResearchErrors",project_id);
                $.get( notresearch, function(data1) {
                    if(data1 !== "false") {
                        // if it's not research remove the IRB and the PI from the list
                        var PIRemove = "PIErrors";
                        result.splice($.inArray(PIRemove, result),1);
                        var IRBRemove = "IRBErrors";
                        result.splice($.inArray(IRBRemove, result),1);
                        //loadResults(result, project_id);
                        var json_parsed = jQuery.parseJSON(data1);
                        //console.log(data1);
                        //console.log(data1["ResearchErrors"]);
                        data1 = json_parsed["ResearchErrors"]["Html"];
                        //$("#go_prod_tbody").show();
                        $("#go_prod_tbody").append(data1);
                      // $('.gp-info-content').children('.gp-body-content').show();
                       // $('.loader').hide();
                      $('.gp-tr').show();
                    }
                    //if it's research True: to run all rules including PI and IRB
                    loadResults(result, project_id);
                }
                );
            }
        });
}

function AllSet(){
    //var allset="classes/ajax_handler.php?f=AllSet&pid="+project_id;
    var allset=GetPath("AllSet",project_id);

    $.get( allset, function(data) {
        $("#go_prod_tbody").show();
        $("#go_prod_tbody").append(data);
        var find_more=$('.gp-info-content').find('.title-text-plus');
        find_more.text(" \\ (•◡•) /");
        $('.gp-info-content').children('.gp-body-content').show();
        $('.loader').hide();
        $('.gp-tr').show();
        }
    );
}

function Addstyles(){
        //Gray Background
        $('.gp-info-content').css( 'cursor', 'pointer' );
        $('.gp-tr').hover(function(){
            $(this).css("background","#d9e1f9");
        },function(){
            $(this).css("background","");
        });
        //$('.gp-info-content').children('.gp-body-content').hide();

        $('.gp-info-content').on('click', function(e) {
            e.preventDefault();
            var find_more=$(this).find('.title-text-plus');
           // var find_icon=$(this).prev('.gp-icon');
            //console.log( find_plus );
            if (find_more.text() === '(hide)'){
               // console.log(find_icon);
                //find_icon.css('background-color', 'red');
                find_more.text('(show)');}
            else{
                find_more.text('(hide)');}
                //find_icon.css('background-color', '#25C2E1');
                $(this).children('.gp-body-content').slideToggle();
        });
        /*this code remove the content from the modal when is closed */
        $("#ResultsModal").on('hidden.bs.modal', function (e) {
            e.preventDefault();
        });
        /* This code load the content of the link in the same modal */
        $(function() {
            $('[data-load-remote]').on('click',function(e) {
                e.preventDefault();
                var $this = $(this);
                var remote = $this.data('load-remote');
                if(remote) {
                    $($this.data('remote-target')).load(remote);
                    $this.data('isloaded', true)
                }
            });
        });
        $('#go_prod_go_btn').prop("disabled",false);
        $('#gp-loader').hide();
}

$( document ).ready(function() {
    $("#go_prod_go_btn").click(function(){
        $('#loader-count').text("");
        $('#gp-loader').show();
        $('#gp-starting').show();
        $('#gp-run').hide();
        $(this).prop("disabled",true);//disable run button while run
        var call=GetPath("PrintRulesNames",project_id);
       // console.log(call);
         $.ajax({url: call, success: function(result){
                 // console.log(result);
            $("#go_prod_tbody").empty();
            result = $.parseJSON(result);
            Workflow(result,project_id);
        }});//cierra ajax call
    });//cierra on click
    //Clean the Modal before refreshing
    $("#ResultsModal").on('hidden.bs.modal', function () {
        $(this).text("");
    });
    console.log( "ready CO!" );
});
