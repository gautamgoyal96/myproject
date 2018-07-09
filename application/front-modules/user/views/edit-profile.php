  <?php
        $url = base_url().FRONT_THEME."images/defaultUser.jpg";
   if(!filter_var($ownerDetail['profileImage'], FILTER_VALIDATE_URL) === false) {

        $url = $ownerDetail['profileImage'];

   }else if(!empty($ownerDetail['profileImage'])){ 

      $url = base_url().'uploads/profile/'.$ownerDetail['profileImage'];

  }?>

<script type="text/javascript">                
    var oPassword =  "<?php echo  $this->encrypt->decode($ownerDetail['password']);?>";
 </script>

<!-- main middle content starts -->
<div class="mainProfile adjust_cntainer">
<div class="extra-margin"></div>
<div class="topCover">
    <img src="<?php echo base_url().FRONT_THEME;?>images/topcover.png">

</div>
<section class="myProfile">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-4">
                <div class="prleftPart">
                    <div class="prImg">
                        <div class="myPic">
                            <img src= "<?php echo $url;?>">
                        </div>
                    </div>
                    <div class="prdata text-center">
                        <h2><?php echo !empty($ownerDetail['firstName']) && !empty($ownerDetail['lastName']) ? (ucwords($ownerDetail['firstName']).' '.ucwords($ownerDetail['lastName'])) : 'NA';?></h2>
                        <div class="OwnerReview">
                            <p class="rt_str">
                                <?php $count = round($ownerDetail['stars']);
                                for($i=1;$i<=$count;$i++){ ?>
                                <span class="fa fa-star"></span> 
                              <?php } $minCount = 5-$count; 
                                for($j=1;$j<=$minCount;$j++){ 
                              ?>
                                <span class="fa fa-star-o"></span>
                              <?php }?>     
                            </p>
                        </div>
                      
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-8">
                <div class="prrightPart EditPrSec">
                    <div class="prTab">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#EditDetails">Edit Profile</a></li>
                            <li><a data-toggle="tab" href="#ChngPwd">Change Password</a></li>
                        </ul>
                    </div>
                    <div class="profileInfo">
                        <div class="tab-content">
                            <div id="EditDetails" class="tab-pane fade in active">
                                <div class="lsRight">                  
                                    <div class="wizard">
                                        <form class="lsform" role="form" method="post" action="<?php echo base_url('user/updateProfile');?>" enctype="multipart/form-data">    
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <div class="log_div">
                                                        <img src="<?php echo $url;?>" id="pImg">
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
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control user" placeholder="First Name" value="<?php echo $ownerDetail['firstName'];?>" name="firstName" id="firstName">
                                                        <div id="firstName-err"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control user" placeholder="Last Name" value="<?php echo $ownerDetail['lastName'];?>" name="lastName" id="lastName">
                                                        <div id="lastName-err"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <input type="email" class="form-control email" placeholder="Email Id" value="<?php echo $ownerDetail['email'];?>" readonly="true">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control phone" placeholder="Phone Number" value="<?php echo $ownerDetail['contactNo'];?>" readonly="true">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control addr" placeholder="Address" value="<?php echo $ownerDetail['address'];?>" placeholder="Address" id="zip_cde" name="address">
                                                        <div id="zip_cde-err"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <textarea class="form-control info" placeholder="About Us" id="about" name="about" maxlength="200"><?php echo $ownerDetail['about'];?></textarea> 
                                                        <div id="count2"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="stepNextBtn">
                                                <a href="<?php echo base_url('user/myProfile');?>" class="btn btn-primary prev-step">Cancel</a>
                                                <button type="submit" class="pull-right btn btn-primary has-spinner">Update</button>
                                            </div>
                                            <div class="clearfix"></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="ChngPwd" class="tab-pane fade">
                                <div class="lsRight">                  
                                    <div class="wizard">
                                        <form class="lsform" role="form"  action="<?php echo base_url('user/passwordChange');?>" method="post">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <input type="password" class="form-control pwd" placeholder="Old Password" id="old-password">
                                                        <div id="old-password-err"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <input type="password" class="form-control pwd" placeholder="New Password"  id="new-password">
                                                        <div id="new-password-err"></div>
                                                    </div>
                                                </div>
                                           </div>

                                           <div class="row">
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <input type="password" class="form-control pwd" placeholder="Confirm Password" name="password"  id="confirm-password">
                                                         <div id="confirm-password-err"></div>
                                                    </div>
                                                </div>
                                           </div>
                                        
                                            <div class="stepNextBtn">
                                                <button type="submit" class=" btn btn-primary change-password">Update</button>
                                                <a href="<?php echo base_url('user/myProfile');?>" class="btn btn-primary prev-step">Cancel</a>
                                            </div>
                                            <div class="clearfix"></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

<!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#ReVarifyPhone">Open Modal</button>
 --><!-- Modal -->
<div id="ReVarifyPhone" class="modal bookModal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Enter OTP</h4>
      </div>
      <div class="modal-body text-center">
        <div class="verificationData">
            <p>Please enter the verification code you received</p>
            <div class="codeBox">
                <input class="form-control" type="text" name="">
                <input class="form-control" type="text" name="">
                <input class="form-control" type="text" name="">
                <input class="form-control" type="text" name="">
            </div>
            <div class="codeText">
                <p>Didn't receive code?</p>
                <a class="cdResend" href="#">Resend Code</a>
            </div>
        </div>
        <a class="btn btn-primary cs-btn" href="#">Submit</a>
      </div>
    </div>
  </div>
</div>
