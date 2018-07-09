$("#third").hide();
$("#second").hide();
$("#mobile-step").addClass('active');
$("#otp-step").addClass('disabled');
$("#personalInfo-step").addClass('disabled');

function loginValidation() {
    var flag = 0;
    var emailLogin = $.trim(jQuery("#emailLogin").val());
    var passwordLogin = $.trim(jQuery("#passwordLogin").val());
    if (emailLogin == '' || emailLogin == '') {
        flag = 1;
        jQuery("#emailLogin").parent("div").addClass("has-error");
        $('#login-email-err').html("<p class='err_msg'> Email is required field</p>");
    } else {
        jQuery("#emailLogin").parent("div").removeClass("has-error");
        $('#login-email-err').html("");
    }
    if (passwordLogin == '' || passwordLogin == '') {
        flag = 1;
        jQuery("#passwordLogin").parent("div").addClass("has-error");
        $('#login-password-err').html("<p class='err_msg'> Password is required field</p>");
    } else {
        jQuery("#passwordLogin").parent("div").removeClass("has-error");
        $('#login-password-err').html("");
    }
    if (flag) {
        return false;
    } else {
        return true;
    }
}

function userLogin() {
    var flag = 0;
    var emailLogin = $.trim(jQuery("#emailLogin").val());
    var passwordLogin = $.trim(jQuery("#passwordLogin").val());
    if (emailLogin == '' || emailLogin == '') {
        flag = 1;
        jQuery("#emailLogin").parent("div").addClass("has-error");
        $('#login-email-err').html("<p class='err_msg'> Email is required field</p>");
    } else {
        jQuery("#emailLogin").parent("div").removeClass("has-error");
        $('#login-email-err').html("");
    }
    if (passwordLogin == '' || passwordLogin == '') {
        flag = 1;
        jQuery("#passwordLogin").parent("div").addClass("has-error");
        $('#login-password-err').html("<p class='err_msg'> Password is required field</p>");
    } else {
        jQuery("#passwordLogin").parent("div").removeClass("has-error");
        $('#login-password-err').html("");
    }
    if (flag) {
        return false;
    } else {
       
        var remember = 0;
        if (document.getElementById('remember-me').checked == true) {
            var remember = 1;
        }

         var form_data = {
            'email': $("#emailLogin").val(),
            'password': $("#passwordLogin").val(),
            'remember': remember
        };
        setTimeout(function() {
            $('.alert-danger').fadeOut('fast');
            $('.alert-success').fadeOut('fast');
            $('.alert-warning').fadeOut('fast');
        }, 5000);
        url = base_url + "signup/loginSecond/";
        $.ajax({
            url: url,
            type: "POST",
            data: form_data,
            dataType: 'json',
            cache: false,
            success: function(data) {
                if (data == "0") {
                    $("#err-log").show();
                    $("#error-log").html('Email id and password invalid');
                } else if (data.type == "1") {
                    if (data.userType == 1) {
                        window.location = base_url + "user/myProfile";
                    } else {
                      window.location = base_url + "user/myProfile";
                    }
                } else if (data == "2") {
                    $("#err-warnig").show();
                    $("#error-waring").html('Your account has been inactivated by admin, please contact to activate');
                }
            }
        });
        return true;
    }
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        jQuery("#phone").parent("div").addClass("has-error");
        return false;
    }
    jQuery("#phone").parent("div").removeClass("has-error");
    return true;
}
$('#step1Form').submit(function() {
    var btn = $(this);
    var flag = 0;
    $("#phone-err").html("");
    var phone = $.trim(jQuery("#phone").val());
    if (phone == '' || phone == '') {
        flag = 1;
        jQuery("#phone").parent("div").addClass("has-error");
        jQuery("#phone").val('');
        $('#phone-err').html("<p class='err_msg'> Phone number is required field</p>");
    } else {
        var phone = $("#phone").val();
        jQuery("#phone").parent("div").removeClass("has-error");
        $('#phone-err').html("");
    }
    if (flag) {
        return false;
    } else {
        var id = $("#userId").val();
        var phone = $("#phone").val();
        var fName = $("#fName").val();
        var lName = $("#lName").val();
        var email = $("#email").val();
        var socialId = $("#socialId").val();
        var image = $("#image").val();
        var socialType = $("#socialType").val();
        var form_data = {
            'phone': $("#phone").val(),
            'userId': $("#userId").val()
        };
        setTimeout(function() {
            $('.alert-danger').fadeOut('fast');
            $('.alert-success').fadeOut('fast');
            $('.alert-warning').fadeOut('fast');
        }, 5000);
        url = base_url + "signup/phoneVerification/";
        $.ajax({
            url: url,
            type: "POST",
            data: form_data,
            dataType: 'json',
            cache: false,
            beforeSend: function() {},
            success: function(data) {
                if (data.status == "0") {
                    $("#err-invalid").show();
                    $("#error-invalid").html(data.error);
                } else if (data.status == "1") {
                    $("#err-sucess").show();
                    $("#error-sucess").html('Verification code has been sent successfully');
                    $("#fName1").val(fName);
                    $("#lName1").val(lName);
                    $("#email1").val(email);
                    $("#socialId1").val(socialId);
                    $("#image1").val(image);
                    $("#socialType1").val(socialType);
                    $("#otpOld").val(data.otp);
                    $("#phone1").val(phone);
                    $("#userId1").val(data.id);
                    $("#code1").val('');
                    $("#code2").val('');
                    $("#code3").val('');
                    $("#code4").val('');
                    $("#first").hide();
                    $("#third").show();
                    $("#mobile-step").removeClass('active');
                    $("#otp-step").removeClass('active');
                    $("#mobile-step").addClass('disabled');
                    $("#otp-step").addClass('active');
                    $("#personalInfo-step").addClass('disabled');
                } else if (data.status == "2") {
                    $("#err-invalid").show();
                    $("#error-invalid").html('Contact number already registered');
                }
            }
        });
        return true;
    }
});

function Previous1() {
    var btn = $(this);
    $(btn).buttonLoader('stop');
    $('#changeText').text('Resend');
    $("#mobile-step").addClass('active');
    $("#otp-step").removeClass('active');
    $("#mobile-step").addClass('disabled');
    $("#otp-step").addClass('disabled');
    $("#personalInfo-step").addClass('disabled');
    $("#third").hide();
    $("#first").show();
    $("#second").hide();
}

function isNumberKey1(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function autotab(original, destination) {
    if (original.getAttribute && original.value.length == original.getAttribute("maxlength"))
        destination.focus()
}

function contactVerification() {
    var flag = 0;
    $("#otp-err").html("");
    var code1 = $.trim(jQuery("#code1").val());
    var code2 = $.trim(jQuery("#code2").val());
    var code3 = $.trim(jQuery("#code3").val());
    var code4 = $.trim(jQuery("#code4").val());
    if (code1 == '' || code2 == '' || code3 == '' || code4 == '') {
        flag = 1;
        $('#otp-err').html("<p class='err_msg'> Otp field is required field</p>");
    } else {
        $('#otp-err').html("");
    }
    if (flag) {
        return false;
    } else {
        setTimeout(function() {
            $('.alert-danger').fadeOut('fast');
            $('.alert-success').fadeOut('fast');
            $('.alert-warning').fadeOut('fast');
        }, 5000);
        var otp = $("#code1").val() + $("#code2").val() + $("#code3").val() + $("#code4").val();
        var otpOld = $("#otpOld").val();
        if (otp == otpOld) {
            var id = $("#userId1").val();
            var fName = $("#fName1").val();
            if (fName != '') {
                $("#fName2").attr('readonly', 'readonly');
                $("#SPAssword").hide();
            }
            var lName = $("#lName1").val();
            if (lName != '') {
                $("#lName2").attr('readonly', 'readonly');
            }
            var email = $("#email1").val();
            if (email != '') {
                $("#email2").attr('readonly', 'readonly');
                $("#email_cnfrm").attr('readonly', 'readonly');
            }
            var socialId = $("#socialId1").val();
            var image = $("#image1").val();
            var socialType = $("#socialType1").val();
            $("#fName2").val(fName);
            $("#lName2").val(lName);
            $("#email2").val(email);
            $("#email_cnfrm").val(email);
            $("#socialId2").val(socialId);
            $("#image2").val(image);
            document.getElementById('pImg').src = "http://www.cubaselecttravel.com/Content/images/default_user.png";
            if (image != '') {
                document.getElementById('pImg').src = image;
            }
            $("#socialType2").val(socialType);
            $("#userId2").val(id);
            var phone = $("#phone1").val();
            $("#phone2").val(phone);
            $("#otp-step").removeClass('active');
            $("#personalInfo-step").removeClass('disabled');
            $("#mobile-step").addClass('disabled');
            $("#otp-step").addClass('disabled');
            $("#personalInfo-step").addClass('active');
            $("#third").hide();
            $("#second").show();
        } else {
            $("#err-invalid").show();
            $("#error-invalid").html('OPT is not match please re- generate OTP');
            $("#phone").val('');
            $("#code1").val('');
            $("#code2").val('');
            $("#code3").val('');
            $("#code4").val('');
        }
        return true;
    }
}

function checkEmail(email) {
    url = base_url + "signup/emailCheck/";
    $.ajax({
        url: url,
        type: "POST",
        data: {
            'email': email
        },
        dataType: 'json',
        cache: false,
        success: function(data) {
            if (data == 1) {
                flag = 1;
                var email3 = $("#email2").val('');
                var con_email3 = $("#email_cnfrm").val('');
                jQuery("#email2").parent("div").addClass("has-error");
                $('#email-err').html("<p class='err_msg'> Email id already register</p>");
                return false;
            } else {
                jQuery("#email2").parent("div").removeClass("has-error");
                $('#email-err').html("");
                return true;
            }
        }
    });
}
$("#fName2").keypress(function(e) {
    var code = e.keyCode || e.which;
    if ((code < 65 || code > 90) && (code < 97 || code > 122) && code != 32 && code != 46 && code != 9 && code != 8) {
        jQuery("#fName2").parent("div").addClass("has-error");
        $('#fname-err').html("<p class='err_msg'> Only alphabets are allowed</p>");
        return false;
    } else {
        jQuery("#fName2").parent("div").removeClass("has-error");
        $('#fname-err').html("");
        return true;
    }
})
$("#lName2").keypress(function(e) {
    var code = e.keyCode || e.which;
    if ((code < 65 || code > 90) && (code < 97 || code > 122) && code != 32 && code != 46 && code != 9 && code != 8) {
        jQuery("#lName2").parent("div").addClass("has-error");
        $('#lname-err').html("<p class='err_msg'> Only alphabets are allowed</p>");
        return false;
    } else {
        jQuery("#lName2").parent("div").removeClass("has-error");
        $('#lname-err').html("");
        return true;
    }
});

function validationRegister() {
    var flag = 0;
    $("#otp-step").removeClass('active');
    $("#personalInfo-step").removeClass('disabled');
    $("#mobile-step").addClass('disabled');
    $("#otp-step").addClass('disabled');
    $("#personalInfo-step").addClass('active');
    $("#otp-err").html("");
    var fname = $.trim(jQuery("#fName2").val());
    var lname = $.trim(jQuery("#lName2").val());
    var email = $.trim(jQuery("#email2").val());
    var con_email = $.trim(jQuery("#email_cnfrm").val());
    var passwrd = $.trim(jQuery("#passwrd2").val());
    var con_password = $.trim(jQuery("#con_password").val());
    var zip_cde = $.trim(jQuery("#zip_cde").val());
    var check = $.trim(jQuery("#check12").val());
    var socialId2 = $("#socialId2").val();
    var socialType2 = $("#socialType2").val();
    var email3 = $("#email2").val();
    var con_email3 = $("#email_cnfrm").val();
    var passwrd3 = $("#passwrd2").val();
    var con_password3 = $("#con_password").val();
    checkEmail(email3);
    if (fname == '' || fname == '') {
        flag = 1;
        jQuery("#fName2").parent("div").addClass("has-error");
        $('#fname-err').html("<p class='err_msg'> First name is required field</p>");
    } else if (fname.length < 3) {
        flag = 1;
        jQuery("#fName2").parent("div").addClass("has-error");
        $('#fname-err').html("<p class='err_msg'> Please enter atleast 3 characters</p>");
    } else if (fname.length > 20) {
        flag = 1;
        jQuery("#fName2").parent("div").addClass("has-error");
        $('#fname-err').html("<p class='err_msg'> Please enter maximum 20 characters</p>");
    } else {
        jQuery("#fName2").parent("div").removeClass("has-error");
        $('#fname-err').html("");
    }
    if (lname == '' || lname == '') {
        flag = 1;
        jQuery("#lName2").parent("div").addClass("has-error");
        $('#lname-err').html("<p class='err_msg'> Last name is required field</p>");
    } else if (lname.length < 3) {
        flag = 1;
        jQuery("#lName2").parent("div").addClass("has-error");
        $('#lname-err').html("<p class='err_msg'> Please enter atleast 3 characters</p>");
    } else if (lname.length > 20) {
        flag = 1;
        jQuery("#lName2").parent("div").addClass("has-error");
        $('#lname-err').html("<p class='err_msg'> Please enter maximum 20 characters</p>");
    } else {
        jQuery("#lName2").parent("div").removeClass("has-error");
        $('#lname-err').html("");
    }
    if (email == '' || email == '') {
        flag = 1;
        jQuery("#email2").parent("div").addClass("has-error");
        $('#email-err').html("<p class='err_msg'> Email is required field</p>");
    } else {
        jQuery("#email2").parent("div").removeClass("has-error");
        $('#email-err').html("");
    }
    if (con_email == '' || con_email3 == '') {
        flag = 1;
        jQuery("#email_cnfrm").parent("div").addClass("has-error");
        $('#con_email-err').html("<p class='err_msg'> Confirm email is required field</p>");
    } else if (email3 != con_email3) {
        flag = 1;
        jQuery("#email_cnfrm").parent("div").addClass("has-error");
        $('#con_email-err').html("<p class='err_msg'> Email and confirm email not match</p>");
    } else {
        jQuery("#email_cnfrm").parent("div").removeClass("has-error");
        $('#con_email-err').html("");
    }
    if (socialId2 == '' && socialType2 == '') {
        if (passwrd == '' || passwrd == '') {
            flag = 1;
            jQuery("#passwrd2").parent("div").addClass("has-error");
            $('#passwrd-err').html("<p class='err_msg'> Password is required field</p>");
        } else if (passwrd.length < 6) {
            flag = 1;
            jQuery("#passwrd2").parent("div").addClass("has-error");
            $('#passwrd-err').html("<p class='err_msg'> Please enter atleast 6 characters</p>");
        } else if (passwrd.length > 20) {
            flag = 1;
            jQuery("#passwrd2").parent("div").addClass("has-error");
            $('#passwrd-err').html("<p class='err_msg'> Please enter maximum 20 characters</p>");
        } else {
            jQuery("#passwrd2").parent("div").removeClass("has-error");
            $('#passwrd-err').html("");
        }
        if (con_password == '' || con_password == '') {
            flag = 1;
            jQuery("#con_password").parent("div").addClass("has-error");
            $('#con_password-err').html("<p class='err_msg'> Confirm password is required field</p>");
        } else if (passwrd3 != con_password3) {
            flag = 1;
            jQuery("#con_password").parent("div").addClass("has-error");
            $('#con_password-err').html("<p class='err_msg'> Password and confirm password not match</p>");
        } else {
            jQuery("#con_password").parent("div").removeClass("has-error");
            $('#con_password-err').html("");
        }
    }
    if (zip_cde == '' || zip_cde == '') {
        flag = 1;
        jQuery("#zip_cde").parent("div").addClass("has-error");
        $('#zip_cde-err').html("<p class='err_msg'> Address is required field</p>");
    } else {
        jQuery("#zip_cde").parent("div").removeClass("has-error");
        $('#zip_cde-err').html("");
    }
    if (flag) {
        return false;
    } else {
        return true;
    }
}
$("#forgotForm").submit(function(e) {
    var url = base_url + "signup/forgotPassword/";
    var email = $('#validMail').val();
    $.ajax({
        type: "POST",
        url: url,
        data: {
            email: email
        },
        success: function(data) {
            var obj = $.parseJSON(data);

            if (obj.status == 0) {
                $('#errorDiv1').css('display', 'block');
                $('#error1').html(obj.error);
                setTimeout(function() {
                    $('.alert-danger').fadeOut('slow');
                }, 4000);
            }
            if (obj.status == 1) {
                $(".close").trigger('click');
                $("#done").modal('show');
                $('#msg').text("A new password has been sent on your registered email");
            }
        }
    });
    e.preventDefault();
});

function authTokenCheck() {
    var url = base_url + "user/authTokenCheck/";
    $.ajax({
        type: "POST",
        url: url,
        success: function(data) {
            if (data == 0) {
                $('#authTokenCheckModel').modal({
                    backdrop: 'static'
                });
            }
        }
    });
}
if(t==1){

	setInterval(function() {
	    authTokenCheck();
	    checNotification();
	}, 10000);


}

function checNotification() {
    url = base_url + "user/notifcationCheck";
    $.ajax({
        url: url,
        type: "POST",
        cache: false,
        success: function(obj) {
            var data = jQuery.parseJSON(obj);
            if (data.type == 1) {
                notifyBrowser('Ava Rents', data.msg, data.url);
            }
        }
    });
}
notifyBrowserPermission();

function notifyBrowserPermission() {
    if (!Notification) {
        console.log('Desktop notifications not available in your browser..');
        return;
    }
    if (Notification.permission !== "granted") {
        Notification.requestPermission();
    }
}

function notifyBrowser(title, desc, url) {
    if (!Notification) {
        console.log('Desktop notifications not available in your browser..');
        return;
    }
    if (Notification.permission !== "granted") {
        Notification.requestPermission();
    } else {
        var notification = new Notification(title, {
            icon: 'http://avarents.com/themes/front/images/logo.png',
            body: desc,
        });
        notification.onclick = function() {
            window.open(url);
        };
        notification.onclose = function() {
            console.log('Notification closed');
        };
    }
}