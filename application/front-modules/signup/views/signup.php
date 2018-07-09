
<div class="adjust_cntainer">
    <div class="extra-margin"></div>
</div>
<!-- <section class="LoginSignup">
    <div class="container">
        <div class="csHead">
            <h2>Create Account</h2>      
        </div>
    </div>
</section> -->
<section class="LSfrom">
    <div class="container">
        <div class="lsInner">
            <div class="row">
                <div class="col-md-10 col-sm-12 col-md-offset-1">
                    <div class="lsRight">                    
                        <div class="wizard">
                            <div class="lsformHead">
                                <h3>Create Your Account</h3>
                                <p>This information will let us know more about you.</p>
                            </div>
                            <div class="wizard-inner">                
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" id="mobile-step">
                                        <a href="javascript:void(0)" title="Step 1">
                                            Mobile Number
                                        </a>
                                    </li>
                                    <li role="presentation" id="otp-step">
                                        <a href="javascript:void(0)" title="Step 2">
                                            OTP
                                        </a>
                                    </li>
                                    <li role="presentation" id="personalInfo-step">
                                        <a href="javascript:void(0)" title="Step 3">
                                           Basic Info
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content lsform">
                                <div class="tab-pane active" role="tabpanel">
                                    <div style="display:none;" class="alert alert-danger hideDiv" role="alert" id="err-invalid">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <strong>Oh snap!</strong> <span id="error-invalid"></span>
                                    </div>
                                    <div style="display:none;" class="alert alert-success hideDiv" role="alert" id="err-sucess">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <strong>Sucess!</strong> <span id="error-sucess"></span>
                                    </div>
                                    <span id="first">
                                       <form class="lsform" action="JavaScript:void(0);" id="step1Form" autocomplete="off">
                                        <div class="step1 steps">
                                            <h5>Enter your Mobile Number</h5>

                                            <div class="form-group">
                                                <input type="hidden" name="fName" id="fName" >
                                                <input type="hidden" name="lName" id="lName" >
                                                <input type="hidden" name="email" id="email" >
                                                <input type="hidden" name="socialId" id="socialId" >
                                                <input type="hidden" name="image" id="image" >
                                                <input type="hidden" name="socialType" id="socialType" >
                                                <input type="text" class="form-control phone" placeholder="Phone Number" type="number" id="phone" name="phone" min="1" onkeypress="return isNumberKey(event);">
                                                <div  id="phone-err" ></div>
                                            </div>
                                            <div class="stepNextBtn">
                                                <button type="submit" id="changeText" class="pull-right btn btn-primary next-step has-spinner">Submit</button>
                                            </div>
                                        </div>
                                        </form>
                                    </span>
                                    <span style="display:none;" id="third">
                                        <form autocomplete="off" action="JavaScript:Void(0)" method="post" name="sampleform" onsubmit="contactVerification();" autocomplete="off">
                                            <div class="step2 steps">
                                                <h5>Enter your OTP</h5>
                                                <input type="hidden" name="otpOld" id="otpOld"> 
                                                <input type="hidden" name="userId1" id="userId1" >
                                                <input type="hidden" name="fName1" id="fName1" >
                                                <input type="hidden" name="lName1" id="lName1" >
                                                <input type="hidden" name="email1" id="email1" >
                                                <input type="hidden" name="socialId1" id="socialId1" >
                                                <input type="hidden" name="image1" id="image1" >
                                                <input type="hidden" name="socialType1" id="socialType1" >
                                                <input type="hidden" name="phone" id="phone1" >
                                                <div class="form-group OTP">
                                                    <input type="text" class="form-control" id="code1"  maxlength="1" size='1' onKeyup="autotab(this, document.sampleform.code2);" oninput="return isNumberKey1(event);" autofocus>

                                                    <input type="text" class="form-control" id="code2"  maxlength="1" size='1' onKeyup="autotab(this, document.sampleform.code3)" oninput="return isNumberKey1(event);">

                                                    <input type="text" class="form-control" id="code3" maxlength="1" size='1' onKeyup="autotab(this, document.sampleform.code4)" oninput="return isNumberKey1(event);">

                                                    <input type="text" class="form-control" id="code4" maxlength="1" size='1' onKeyup="autotab(this, document.sampleform.sendbtn)" oninput="return isNumberKey1(event);">
                                                </div>
                                                <div id="otp-err"> </div>
                                                <div class="stepNextBtn">
                                                    <button type="button" class="btn btn-primary prev-step" onclick="Previous1();" >Previous</button>
                                                    <button type="submit" class="pull-right btn btn-primary next-step">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </span>
                                    <span style="display:none;" id="second">
                                        <form autocomplete="off" action="<?php echo site_url('signup/signupSecondStep');?>" method="post" enctype="multipart/form-data" onsubmit="return validationRegister();">
                                            <div class="step3 steps">                            
                                                <div class="row">
                                                    <div class="col-md-12 text-center">
                                                        <div class="log_div">
                                                            <img src="<?php echo base_url().FRONT_THEME;?>images/prof_img.png" id="pImg">
                                                            <div class="text-center upload_pic_in_album"> 
                                                                <input accept="image/*" class="inputfile hideDiv" id="file-1" name="profileImage" onchange="document.getElementById('pImg').src = window.URL.createObjectURL(this.files[0])" style="display: none;" type="file">
                                                                <label for="file-1" class="upload_pic">
                                                                <span class="fa fa-camera"></span></label>
                                                            </div>
                                                            <div id="profileImage-err"> </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <input type="hidden" name="userId" id="userId2" name="userId2" >
                                                            <input type="hidden" name="image2" id="image2">
                                                            <input type="hidden" name="socialId2" id="socialId2">
                                                            <input type="hidden" name="socialType2" id="socialType2">
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control user" placeholder="First Name" id="fName2" name="fName" >
                                                            <div id="fname-err"> </div>    
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control user" placeholder="Last Name" id="lName2" name="lName" >
                                                            <div id="lname-err"> </div>    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <input type="email" class="form-control email" placeholder="Email Id" id="email2" name="email" oninput="return checkEmail(this.value);" >
                                                            <div id="email-err"> </div>    
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <input type="email" class="form-control email" placeholder="Confirm Email Id" id="email_cnfrm" >
                                                            <div id="con_email-err"> </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" id="SPAssword">
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <input type="password" class="form-control pwd" placeholder="Password" id="passwrd2" name="password" autocomplete="off">
                                                            <div id="passwrd-err"> </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <input type="password" class="form-control pwd" placeholder="Confirm Password" id="con_password" autocomplete="off">
                                                            <div id="con_password-err"> </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control phone" placeholder="Phone Number" id="phone2" name="phone2" readonly>
                                                           <div id="otp-err"> </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control addr" placeholder="Address" id="zip_cde" name="zipCode" >
                                                            <div id="zip_cde-err"> </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="stepNextBtn">
                                                    <!-- <button type="button" class="btn btn-primary prev-step">Previous</button> -->
                                                    <button type="submit" class="pull-right btn btn-primary next-step">Sign Up</button>
                                                </div>
                                            </div>
                                        </form>
                                    </span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">

    var fName = localStorage.getItem("fName");
    var lName = localStorage.getItem("lName");
    var email = localStorage.getItem("email");
    var socialId = localStorage.getItem("socialId");
    var image = localStorage.getItem("image");
    var socialType = localStorage.getItem("socialType");
    $("#fName").val(fName);
    $("#lName").val(lName);
    $("#email").val(email);
    $("#socialId").val(socialId);
    $("#image").val(image);
    $("#socialType").val(socialType);

    localStorage.removeItem("fName");       
    localStorage.removeItem("lName");       
    localStorage.removeItem("email");       
    localStorage.removeItem("socialId");       
    localStorage.removeItem("image");       
    localStorage.removeItem("socialType"); 
</script>
