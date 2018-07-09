  <?php

        $url = base_url().FRONT_THEME."images/defaultUser.jpg";
   if(!filter_var($ownerDetail['profileImage'], FILTER_VALIDATE_URL) === false) {

        $url = $ownerDetail['profileImage'];

   }else if(!empty($ownerDetail['profileImage'])){ 

      $url = base_url().'uploads/profile/'.$ownerDetail['profileImage'];

  }?>

<?php if($this->session->userdata('front_login') == true && $this->session->userdata('id') && $this->uri->segment(2) == 'myProfile'){
?>


    <script type="text/javascript">                
       var email = "<?php echo  $this->session->userdata('email');?>";
       var password = "123456";
       var name = "<?php echo !empty($ownerDetail['firstName']) && !empty($ownerDetail['lastName']) ? (ucwords($ownerDetail['firstName']).' '.ucwords($ownerDetail['lastName'])) : 'NA';?>";
       var image = "<?php echo $url;?>";
        var time = $.now();
        var firebaseId =  "<?php echo  $ownerDetail['firebaseId'];?>";
    </script>
  <script src="https://www.gstatic.com/firebasejs/3.3.0/firebase.js"></script>
  <script src="https://cdn.firebase.com/libs/firechat/3.0.1/firechat.min.js"></script>
  <script src="<?php echo base_url().FRONT_THEME;?>js/firebase_custome.js"></script>
    <script src="<?php echo base_url().FRONT_THEME;?>js/firebasechat.js"></script>
  <script src="<?php echo base_url().FRONT_THEME;?>js/firebase-chat-history.js"></script>

<?php
 }?>
<!-- main middle content starts -->
<div class="mainProfile adjust_cntainer">
    <div class="extra-margin"></div>
    <div class="topCover">
        <!-- <img src="<?php echo base_url().FRONT_THEME;?>images/topcover.png"> -->
        <!-- <a href="#" class="cs-btn">Logout</a> -->
        <?php if($this->session->userdata('front_login') == true && $this->uri->segment(2) == 'myProfile'){ ?>
            <a href="<?php echo base_url().'user/logout';  ?>" class="cs-btn">Logout</a>
        <?php } ?>
    </div>
    <section class="myProfile">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <div class="prleftPart">
                        <div class="prImg">
                            <div class="myPic">
                                <img src= "<?php echo $url;?>">

                                 <?php if($this->session->userdata('front_login') == true && $this->session->userdata('id') && $this->uri->segment(2) == 'myProfile'){ ?>
                                <div class="editprIcon">
                                    <span><a href="<?php echo base_url('user/editProfile');?>" ><i class="fa fa-edit"></i></a></span>
                                </div>
                                <?php } ?>
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

                            <?php if($this->session->userdata('front_login') == true && $this->session->userdata('id') && $this->uri->segment(2) == 'myProfile'){
                                    if($userType == 1) {
                                ?>
                                <a href="<?php echo base_url();?>user/updateuserType" class="cs-btn">Switch to User</a>
                            <?php } else{ ?>
                                <a href="<?php echo base_url();?>user/updateuserType" class="cs-btn">Switch to Owner</a>
                            <?php } }else{
                                    if(!empty($this->uri->segment(4))){
                                        $pId=  $this->uri->segment(4);
                                        $oId = $this->uri->segment(3);
                                ?>

                                                      <a href="<?php echo base_url().'chat/index/'.$oId."/".$pId;?>" class="csBtnIcon"><i class="fa  fa-commenting"></i> Chat</a>

                            <?php }}?>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8">
                    <div class="prrightPart">
                        <div class="prTab">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#Details">Personal Details</a></li>
                                <li><a data-toggle="tab" href="#Reviews">Reviews</a></li>
                               
                                <?php if($this->session->userdata('front_login') == true && $this->session->userdata('id') && $this->uri->segment(2) == 'myProfile'){?>
                                 <?php if($ownerDetail['userType']==1){?>

                                    <li ><a data-toggle="tab" href="#Rented">Rented</a></li>

                                <?php }else{?>

                                    <li><a data-toggle="tab" href="#Rentals">Rentals</a></li>

                                <?php }?>
                                 <li ><a data-toggle="tab" href="#chatHistory">Chat History</a></li>
                                <?php }?>
                            </ul>
                        </div>
                        <div class="profileInfo">
                            <div class="tab-content">
                                <div id="Details" class="tab-pane fade in active">
                                    <div class="myInfo">
                                        <div class="infogroup">
                                            <h3>Email Id</h3>
                                            <p><?php echo !empty($ownerDetail['email']) ? $ownerDetail['email']: 'NA';?></p>
                                        </div>
                                        <div class="infogroup">
                                            <h3>Contact Number</h3>
                                            <p><?php echo !empty($ownerDetail['countryCode']) && !empty($ownerDetail['contactNo']) ? (($ownerDetail['countryCode']).'-'.($ownerDetail['contactNo'])) : 'NA';?></p>
                                        </div>
                                        <div class="infogroup">
                                            <h3>Address</h3>
                                            <p><?php echo !empty($ownerDetail['address']) ? $ownerDetail['address']: 'NA';?></p>
                                        </div>
                                        <div class="infogroup">
                                            <h3>About</h3>
                                            <p><?php echo !empty($ownerDetail['about']) ? $ownerDetail['about']: 'NA';?></p>
                                        </div>
                                        <?php if($this->session->userdata('front_login') == true && $this->session->userdata('id') && $this->uri->segment(2) == 'myProfile' && $ownerDetail['userType']==1){ ?>
                                             <div class="infogroup">
                                                <h3>Payment Info</h3>

                                                <p><a href="<?php echo base_url('payment/addBankAccount');?>" class="btn btn-primary cs-btn has-spinner">  <?php echo ($ownerDetail['bankAccountStatus']=='no') ? "Add" : "Update" ;?> bank account</a>
</p>
                                            </div>
                                        <?php }?>
                                    </div>
                                </div>
                                <div id="Reviews" class="tab-pane fade">
                                    <?php if(!empty($reviews)) {
                                        foreach ($reviews as $res) {                          
                                    ?>
                                    <div class="media additional_info_sub_grids">
                                        <div class="media-left">
                                            <div class="additional_info_sub_grid_left">
                                                <?php $url= base_url().FRONT_THEME.'images/defaultUser.jpg'; 
                                                    if(!empty($res->profileImage)){
                                                        if(!filter_var($res->profileImage, FILTER_VALIDATE_URL) === false){
                                                            $url = $res->profileImage;
                                                        }else{
                                                            $url= base_url()."/uploads/profile/".$res->profileImage;
                                                        }
                                                    } 
                                                ?>
                                                <a href="<?php echo base_url('user/profile')."/".$res->givenById."/".$res->productId;?>"><img src="<?php echo $url;?>" alt=" " class="img-responsive"></a>
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <div class="additional_info_sub_grid_right">
                                                <div class="additional_info_sub_grid_rightl">
                                                    <a href="<?php echo base_url('user/profile')."/".$res->givenById."/".$res->productId;?>"><?php echo !empty($res->firstName) && !empty($res->lastName) ? (ucwords($res->firstName).' '.ucwords($res->lastName)) : 'NA';?>
                                                        <p class="rt_str">
                                                            <?php $count = round($res->stars);
                                                                for($i=1;$i<=$count;$i++){ ?>
                                                                <span class="fa fa-star"></span> 
                                                            <?php } $minCount = 5-$count; 
                                                                for($j=1;$j<=$minCount;$j++){ 
                                                            ?>
                                                                <span class="fa fa-star-o"></span>
                                                            <?php }?>                                   
                                                        </p>
                                                    </a>
                                                  <p><a href="<?php echo base_url('products/viewProduct')."/".$res->productId;?>"><?php echo $res->title;  ?></a></p>
                                                  <p><?php echo (!empty($res->comment)) ? $res->comment : 'NA';  ?></p>
                                                </div>
                                                <div class="additional_info_sub_grid_rightr"></div>
                                                <div class="clearfix"> </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } }else{ 
                                            echo "No Records Found";
                                        } ?>
                                    </div>
                                <div id="Rented" class="tab-pane fade">
                                    <div class="rentedItem">
                                        <?php
                                        $t = 0;
                                         if(!empty($rentedData)) {
                                            foreach ($rentedData as $ress) {                          
                                        ?>
                                        <div class="media additional_info_sub_grids">
                                            <div class="media-left media-middle">
                                                 <a href="<?php echo base_url()."transaction/transactionInfo/".$ress->id."/".$ress->productId;?>">
                                                <div class="additional_info_sub_grid_left">
                                                    <img src="<?php echo $ress->productImage;?>" alt=" " class="img-responsive">
                                                </div>
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <div class="additional_info_sub_grid_right">
                                                    <div class="additional_info_sub_grid_rightl">
                                                        <a href="<?php echo base_url()."transaction/transactionInfo/".$ress->id."/".$ress->productId;?>"><?php echo (!empty($ress->title)) ? $ress->title : 'NA';  ?></a>

                                                        <p>Date Returned: <span><?php echo $ress->bookEndDate;  ?></span></p>

                                                        <div class="userRented">
                                                        
                                                        <a href="<?php echo base_url('user/profile')."/".$ress->userId."/".$ress->productId;?>">
                                                            <?php 
                                                            $url = base_url().FRONT_THEME."images/defaultUser.jpg";
                                                           if(!filter_var($ress->profileImage, FILTER_VALIDATE_URL) === false) {

                                                                $url = $ress->profileImage;

                                                           }else if(!empty($ress->profileImage)){ 

                                                              $url = base_url().'uploads/profile/'.$ress->profileImage;

                                                          }
                                                          ?>
                                                        <img src="<?php echo $url;?>">
                                                        <span>
                                                        <?php echo !empty($ress->firstName) && !empty($ress->lastName) ? (ucwords($ress->firstName).' '.ucwords($ress->lastName)) : 'NA';?>
                                                        </span>
                                                        </a>
                                                        </div>
                                                        <div class="amountPaid">
                                                            <p>Amount Paid : <span>$<?php echo $total = $ress->price+$ress->extraPay; $t = $total+$t; ?></span></p>
                                                        </div>
                                                    </div>
                                                    <div class="additional_info_sub_grid_rightr"></div>
                                                    <div class="clearfix"> </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } }else{ 
                                            echo "No Records Found";
                                        } ?>
                                    </div>
                                    <?php if(!empty($t)){
                                        $adminFees = $t/$adminFee;
                                        $total = $t-$adminFees;
                                        ?>
                                    <div class="TotalAmountRnt">
                                    	<p>Total Amount Earned <span>$<?php echo round($total,2);?></span></p>
                                    </div>
                                    <?php }?>
                                </div>
                                <!--- rented tab end-->

                                  <div id="Rentals" class="tab-pane fade">
                                    <div class="rentedItem">
                                        <?php 
                                          $t = 0;
                                        if(!empty($rentalsData)) {
                                      
                                            foreach ($rentalsData as $ress) {                          
                                        ?>

                                        <div class="media additional_info_sub_grids">

                                            <div class="media-left media-middle">
                                               <a href="<?php echo base_url()."transaction/transactionInfo/".$ress->id;?>">

                                                <div class="additional_info_sub_grid_left">
                                                    <img src="<?php echo $ress->productImage;?>" alt=" " class="img-responsive">
                                                </div>
                                               </a>
                                            </div>
                                            <div class="media-body">
                                                <div class="additional_info_sub_grid_right">

                                                    <div class="additional_info_sub_grid_rightl">
                                                        <a href="<?php echo base_url()."transaction/transactionInfo/".$ress->id."/".$ress->productId;?>"><?php echo (!empty($ress->title)) ? $ress->title : 'NA';  ?></a>
                                                        <p>Date Returned: <span><?php echo $ress->bookEndDate;  ?></span></p>

                                                        <div class="userRented">
                                                        <?php 
                                                            $url = base_url().FRONT_THEME."images/defaultUser.jpg";
                                                           if(!filter_var($ress->profileImage, FILTER_VALIDATE_URL) === false) {

                                                                $url = $ress->profileImage;

                                                           }else if(!empty($ress->profileImage)){ 

                                                              $url = base_url().'uploads/profile/'.$ress->profileImage;

                                                          }
                                                          ?>
                                                        <a href="<?php echo base_url('user/profile')."/".$ress->uId."/".$ress->productId;?>">
                                                        <img src="<?php echo $url;?>">
                                                        <span>
                                                        <?php echo !empty($ress->firstName) && !empty($ress->lastName) ? (ucwords($ress->firstName).' '.ucwords($ress->lastName)) : 'NA';?>
                                                        </a>
                                                        </span>
                                                        </div>
                                                        
                                                        <div class="amountPaid">
                                                            <p>Amount Paid : <span>$ <?php echo $total = $ress->price+$ress->extraPay; $t = $total+$t; ?></span></p>
                                                        </div>
                                                    </div>
                                                    <div class="additional_info_sub_grid_rightr"></div>
                                                    <div class="clearfix"> </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } }else{ 
                                            echo "No Records Found";
                                        } ?>
                                    </div>

                                     <?php if(!empty($t)){

                                        ?>
                                    <div class="TotalAmountRnt">
                                        <p>Total Amount Spent <span>$<?php echo $t;?></span></p>
                                    </div>
                                    <?php }?>
                                </div>
                                <!--- Rentals tab end-->
                                <!--- chat history start-->
                                 <div id="chatHistory" class="tab-pane fade">
              
                </div>
                <!--  chat history end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

