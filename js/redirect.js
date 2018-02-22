if(typeof ExternalModulesOptional === 'undefined') {
    var ExternalModulesOptional = {};
}

$(document).ready(function() {
    var btn = $('tr[data-module="goprod"] button.external-modules-configure-button');
    console.log(btn);
    btn.hide();
    gopro_button= '<button id="go_prod_settings" style="color:#5492a3">Configure</button>';
    btn.after(gopro_button);

    document.getElementById("go_prod_settings").onclick = function () {
       //production =  "../../modules/goprod_v2.0/system_level_homepage.php";

        production =  "http://localhost/redcap/external_modules/?id=5&page=gopro_config";
        var loc = window.location.pathname;
        var dir = loc.substring(0, loc.lastIndexOf('/'));
        var dir1 = loc.substring(0, dir.lastIndexOf('/'));
        console.log(loc);
        console.log(dir);
        console.log(dir1);

        console.log(production);
        //location.href = production;
    };



});

// <tr data-module="goprodv" data-version="2.0">
//     <td><div class="external-modules-title">Go Prod - 2.0                            <span class="label label-warning">Enabled for All Projects</span>                        </div><div class="external-modules-description">We constructed a plugin that enforces best practices and modifies the 'Move to Production' workflow. Initial results suggest a dramatic reduction in common design mistakes while also significantly reducing the REDCap administrator support burden.</div><div class="external-modules-byline">
// by <a href="mailto:alvaro1@stanford.edu?subject=Go%20Prod%20-%202.0">Alvaro Andres Alvarez Peralta</a> <span class="author-institution">(Stanford University)</span></div></td>
// <td class="external-modules-action-buttons">
//     <button class="external-modules-configure-button">Configure</button>
//     <button class="external-modules-disable-button">Disable</button>
//     <button class="external-modules-usage-button" style="min-width: 90px">View Usage</button>
// </td>
// </tr>
// <button class="external-modules-configure-button">Configure</button>
//
ExternalModulesOptional.redirect = function(e) {

    /*$("#go_prod_settings").click(function(){
        production =  "www.google.com";
        console.log(production);
        location.href = production;


    });*/
    console.log("here");
    // window.location = "http://www.yoururl.com";

};