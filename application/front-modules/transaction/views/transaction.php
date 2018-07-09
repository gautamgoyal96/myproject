  

    <!-- main middle content starts -->
<div class="adjust_cntainer">
<div class="extra-margin"></div>
  <section class="transactionList pad-sec-60">
    <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-x-12 wow fadeInUp    animated" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInUp;">            
              <h2 class="secTitle"> Transactions </h2>
      </div>
      <div class="col-md-offset-2 col-md-8 col-sm-10 col-sm-offset-1">
      <div class="trList">
        <div class="TRtab">
          <ul class="list-unstyled list-inline nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#CurrentTab">Completed</a></li>
            <li><a data-toggle="tab" href="#PendingTab">Pending</a></li>
          </ul>
        </div>
        <div class="tab-content">
          <div id="CurrentTab" class="tab-pane fade in active">
            <?php if(!empty($total)){ ?>
            <div class="TotalAmountRnt mrbt">
              <?php 
              if($this->session->userdata('userType')==1){

                $totalType = "Earned";

              }else{

                 $totalType = "Spent";
              }
              ?>
             <p>Total Amount <?php echo $totalType;?> <span>$<?php echo round($total,2);?></span></p>
            </div>
            <?php }?>
            <div class="row">
              <?php
                if(!empty($currentData)) {
                  
                  foreach ($currentData as $ress) {                          
                ?>
              <div class="col-md-6 col-sm-12">
                <article class="trans-item">
                  <div class="TRineer">
                    
                    <figure>
                      <a href="<?php echo base_url('products/viewProduct')."/".$ress->productId;?>"><img src="<?php echo $ress->productImage;?>" class="attachment-property-thumb-image size-property-thumb-image wp-post-image" alt="" height="163" width="244"></a>
                    </figure>
                    <div class="detail">
                      <h4><a href="<?php echo base_url('products/viewProduct')."/".$ress->productId;?>"><?php echo $ress->title;  ?></a></h4>
                      <h5 class="price"><span>$<?php echo $ress->price;?></span>  - <?php echo $ress->myProductForRental;?></h5>
                      <h5 class="RentedDt">Return Date: <span><span><?php echo $ress->bookEndDate;?></span></h5>
                      <div class="userTr">
                        <div class="userImg">
                          <?php $url= base_url().FRONT_THEME.'images/defaultUser.jpg'; 
                                                    if(!empty($ress->profileImage)){
                                                        if(!filter_var($ress->profileImage, FILTER_VALIDATE_URL) === false){
                                                            $url = $ress->profileImage;
                                                        }else{
                                                            $url= base_url()."/uploads/profile/".$ress->profileImage;
                                                        }
                                                    } 
                                                ?>
                          <a href="<?php echo base_url('user/profile')."/".$ress->uId."/".$ress->productId;?>"><img src="<?php echo $url;?>"></a>
                        </div>
                        <div class="userInfo">
                          <a href="<?php echo base_url('user/profile')."/".$ress->uId."/".$ress->productId;?>"><?php echo !empty($ress->firstName) && !empty($ress->lastName) ? (ucwords($ress->firstName).' '.ucwords($ress->lastName)) : 'NA';?></a>
                          <p class="rt_str">
                            <?php $count = round($ress->rating);
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
                  <div class="trans-meta">
                    <span><?php echo $ress->crd;?></span><a href="<?php echo base_url()."transaction/transactionInfo/".$ress->id;?>">More Details</a>
                  </div>
                </article>
              </div>
              <?php } }else{ ?>
                    <div class="col-md-12 col-sm-12">No Records Found</div>
               <?php } ?>   
            </div>
          </div>
          <div id="PendingTab" class="tab-pane fade ">
           
            <div class="row">
                <?php if(!empty($pendingData)) {
                  foreach ($pendingData as $ress) {                          
                ?>
                <div class="col-md-6 col-sm-12">
                  <article class="trans-item">
                    <div class="TRineer">
                      <figure>
                        <a href="<?php echo base_url('products/viewProduct')."/".$ress->productId;?>"><img src="<?php echo $ress->productImage;?>" class="attachment-property-thumb-image size-property-thumb-image wp-post-image" alt="" height="163" width="244"></a>
                      </figure>
                      <div class="detail">
                        <h4><a href="<?php echo base_url('products/viewProduct')."/".$ress->productId;?>"><?php echo $ress->title;  ?></a></h4>
                        <h5 class="price"><span>$<?php echo $ress->price;?></span>  - <?php echo $ress->myProductForRental;?></h5>
                        <h5 class="RentedDt">Return Date: <span><span><?php echo $ress->bookEndDate;?></span></h5>
                        <h5 class="RentedDt">Status: <span><span><?php if($ress->payStatus!="complete"){ echo "Payment Pending";}else{ if($ress->reviewStatus!="complete"){ echo "Review Pending";}}?></span></h5>
                        <div class="userTr">
                          <div class="userImg">
                          <?php $url= base_url().FRONT_THEME.'images/defaultUser.jpg'; 
                                                    if(!empty($ress->profileImage)){
                                                        if(!filter_var($ress->profileImage, FILTER_VALIDATE_URL) === false){
                                                            $url = $ress->profileImage;
                                                        }else{
                                                            $url= base_url()."/uploads/profile/".$ress->profileImage;
                                                        }
                                                    } 
                                                ?>
                          <a href="<?php echo base_url('user/profile')."/".$ress->uId."/".$ress->productId;?>"><img src="<?php echo $url;?>"></a>
                        </div>
                          <div class="userInfo">
                            <a href="<?php echo base_url('user/profile')."/".$ress->uId."/".$ress->productId;?>"><?php echo !empty($ress->firstName) && !empty($ress->lastName) ? (ucwords($ress->firstName).' '.ucwords($ress->lastName)) : 'NA';?></a>
                            <p class="rt_str">   
                              <?php $count = round($ress->rating);
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
                    <div class="trans-meta">
                      <span><?php echo $ress->crd;?></span><a href="<?php echo base_url()."transaction/transactionInfo/".$ress->id;?>">More Details</a>
                    </div>
                  </article>
                </div>
                <?php } }else{ ?>
                    <div class="col-md-12 col-sm-12">No Records Found</div>
               <?php } ?>     
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
    </div>
  </section>
</div>  