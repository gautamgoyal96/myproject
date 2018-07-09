
// <!-add Profile valdation custome start Gk-->  

//////////////////////////  Profile Edit /////////////////////////////////////////

$(document).ready(function() {
    var text_max1 = 200;
    $('#count2').html(text_max1 + ' characters');

    $('#about').keyup(function() {
        var text_length1 = $('#about').val().length;
        var text_remaining1 = text_max1 - text_length1;

        $('#count2').html(text_remaining1 + ' characters left');
    });
});

$("#firstName").keypress(function(e){var code=e.keyCode||e.which;if((code<65||code>90)&&(code<97||code>122)&&code!=32&&code!=46&&code!=9&&code!=8)
{jQuery("#firstName").parent("div").addClass("has-error");$('#firstName-err').html("<p class='err_msg'> Only alphabates are allowed</p>");return false;}else{jQuery("#firstName").parent("div").removeClass("has-error");$('#firstName-err').html("");return true;}})
$("#lastName").keypress(function(e){var code=e.keyCode||e.which;if((code<65||code>90)&&(code<97||code>122)&&code!=32&&code!=46&&code!=9&&code!=8)
{jQuery("#lastName").parent("div").addClass("has-error");$('#lastName-err').html("<p class='err_msg'> Only alphabates are allowed</p>");return false;}else{jQuery("#lastName").parent("div").removeClass("has-error");$('#lastName-err').html("");return true;}});


$('.has-spinner').click(function () {
   
    var flag=0;
    var firstName = $.trim(jQuery("#firstName").val());
    var lastName = $.trim(jQuery("#lastName").val());
    var zip_cde = $.trim(jQuery("#zip_cde").val());
                               

    if(firstName=='' || firstName==''){
        flag=1;
        jQuery("#firstName").parent("div").addClass("has-error");
        $('#firstName-err').html("<p class='err_msg'> First name is required field</p>");
    }else{
        jQuery("#firstName").parent("div").removeClass("has-error");
        $('#firstName-err').html(""); 
    }   

    if(lastName=='' || lastName==''){
        flag=1;
        jQuery("#lastName").parent("div").addClass("has-error");
        $('#lastName-err').html("<p class='err_msg'> Last name is required field</p>");
    }else{
        jQuery("#lastName").parent("div").removeClass("has-error");
        $('#lastName-err').html(""); 
    }
      
    if(zip_cde=='' || zip_cde==''){
        flag=1;
        jQuery("#zip_cde").parent("div").addClass("has-error");
        $('#zip_cde-err').html("<p class='err_msg'> Address is required field</p>");
    }else{
        jQuery("#zip_cde").parent("div").removeClass("has-error");
        $('#zip_cde-err').html(""); 
    }
           
    if(flag){
        return false ;
    }else{

        return true;
    }        
});

$('.change-password').click(function () {
   
    var flag=0;
    var old_password = $.trim(jQuery("#old-password").val());
    var new_password = $.trim(jQuery("#new-password").val());
    var confirm_password = $.trim(jQuery("#confirm-password").val());

    if(old_password=='' || old_password==''){
        flag=1;
        jQuery("#old-password").parent("div").addClass("has-error");

        $('#old-password-err').html("<p class='err_msg'> Old password is required field</p>");
    }else if(old_password != oPassword){
        flag=1;
        jQuery("#old-password").parent("div").addClass("has-error");
        $('#old-password-err').html("<p class='err_msg'> Old Password does not match</p>");
    }else{
        jQuery("#old-password").parent("div").removeClass("has-error");
        $('#old-password-err').html(""); 
    }   

    if(new_password=='' || new_password==''){
        flag=1;
        jQuery("#new-password").parent("div").addClass("has-error");
        $('#new-password-err').html("<p class='err_msg'> New password is required field</p>");
    }else if(new_password.length<6){
        flag=1;
        jQuery("#new-password").parent("div").addClass("has-error");
        $('#new-password-err').html("<p class='err_msg'> Please enter atleast 6 characters</p>");
    }else if(new_password.length>20){
        flag=1;
        jQuery("#new-password").parent("div").addClass("has-error");
        $('#new-password-err').html("<p class='err_msg'> Please enter maximum 20 characters</p>");
    }else{
        jQuery("#new-password").parent("div").removeClass("has-error");
        $('#new-password-err').html(""); 
    }
      
    if(confirm_password=='' || confirm_password==''){

        flag=1;
        jQuery("#confirm-password").parent("div").addClass("has-error");
        $('#confirm-password-err').html("<p class='err_msg'> Confirm password is required field</p>");
        
    }else if(confirm_password != new_password){
        flag=1;
        jQuery("#confirm-password").parent("div").addClass("has-error");
        $('#confirm-password-err').html("<p class='err_msg'>New Password and Confirm Password don't match</p>");
    }else{
        jQuery("#confirm-password").parent("div").removeClass("has-error");
        $('#confirm-password-err').html(""); 
    }
           
    if(flag){
        return false ;
    }else{

        return true;
    }        
});


// <!-edit profile custome end Gk-->
