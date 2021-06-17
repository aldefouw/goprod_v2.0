/**
 * Created by alvaro1 on 4/12/17.
 */


function GetPath(rulename,project_id){
    url= geturl_ajax+"&rule="+rulename;
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

    //for each rule
    $.each( rules, function( i, val ) {
        var urlcall=GetPath(val,project_id);

        $.get( urlcall, function(data) {
            //if(data !== "false") {
            var json_parsed = JSON.parse(data);
            if(json_parsed !== false){
                count_problems_found++;
                try{
                    //save Array of problems  in session variable
                    sessionStorage.setItem(val, JSON.stringify(json_parsed[val]["Results"]));

                }catch(err){
                    console.log("problem with the rule:");
                    console.log(val);
                }

                //printing the data Html in the index page
                data = json_parsed[val]["Html"];

                //print main results
                var $new =$(data);
                $("#go_prod_tbody").append($new);
                $("#go_prod_tbody").show('slow');
                $new.slideDown('slow');
            }


            //progress bar start
            count_rules++;

            // time out in case a big datadictionary add a "please wait" message
            var timer = window.setTimeout(function(){
                $('#gp-extra-time').show();
            }, 10000);


            // progress bar
            $('.progress .progress-bar').css("width",
                function() {
                    var newprogress=(count_rules/total_rules) * 100;
                    newprogress= parseInt(newprogress, 10);
                    $('#loader-count').text("  "+count_rules+"/"+total_rules+ " ("+newprogress+"%)" );
                    //$('#loader-count').text(" "+newprogress+"%" );
                    if(count_rules===total_rules){
                        if(count_problems_found===0){
                            //AllSet();
                            $('#go_prod_table').hide();
                            $('#allset1').fadeIn();
                        }
                        Addstyles();
                    }
                    if (newprogress===100){
                        $('#gp-loader').hide();//hide loader when finish
                        $('.gp-actions-load').hide();
                        if(timer) {
                            clearTimeout(timer);
                            $('#gp-extra-time').text("");
                        }
                        $('.gp-actions-link').fadeIn(1500);
                        $('#gp-run').show();

                    }

                    // em@partners.org: Showing Move to Prod button when there are no errors found
                    if (count_problems_found===0 & newprogress===100){
                        $('#go_prod_accept_all1').prop('hidden', '')
                    }

                    return $(this).attr('aria-valuenow', newprogress+"%").css('width',newprogress+"%");




                }
            ); //progress bar end





        });
    });

}

function Addstyles(){
    //Gray Background
    $('.gp-tr').css("border-radius","5px");
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

    $('#go_prod_go_btn').prop("disabled",false);
    $('#gp-loader').hide();
}


$( document ).ready(function() {

    $("#go_prod_go_btn").click(function(){
        $('#allset1').hide();
        $('#loader-count').text("");
        $('#gp-loader').show();
        $('#gp-starting').show();
        $('#gp-run').hide();
        $(this).prop("disabled",true);//disable run button while run
        var call=GetPath("GetListOfActiveRules",project_id);

        $.ajax({url: call, success: function(result){
                // console.log(result);
                $("#go_prod_tbody").empty();
                result = $.parseJSON(result);

                loadResults(result,project_id);
            }});//cierra ajax call
    });//cierra on click


    var ResultsModal =$("#ResultsModal");
        ResultsModal.on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var url = button.data('link'); // Extract info from data-* attributes
            $("#remote-html").load(url);
            //$('.lds-ripple').hide();



        });




    console.log( "ready COL!" );
});

