<?php 

	$page = $this->uri->segment(3);
	$ownerDiv = 'none';
	$userDiv = 'show';
	if($this->session->userdata('front_login') == true){ 

		if($this->session->userdata('userType') == 1){ 
			$ownerDiv = 'show';
			$userDiv = 'none';
		}else{
		 	$ownerDiv = 'none';
			$userDiv = 'show';
		}
	}
		$userType = $this->session->userdata('userType');
		$userTypeCheckStatus = "0";

	if(!empty($this->session->userdata('id')) && $this->session->userdata('id')==$details->ownerId){
		if($this->session->userdata('userType')!=1){

	      $userTypeCheckStatus = "1";

		}
	}
?>

<?php if(!empty($userDetail)){
	 $url = base_url().FRONT_THEME."images/defaultUser.jpg";
   if(!filter_var($userDetail['profileImage'], FILTER_VALIDATE_URL) === false) {

        $url = $userDetail['profileImage'];

   }else if(!empty($userDetail['profileImage'])){ 

      $url = base_url().'uploads/profile/'.$userDetail['profileImage'];

  }
?>


    <script type="text/javascript">                
       var email = "<?php echo  $this->session->userdata('email');?>";
       var password = "123456";
       var name = "<?php echo !empty($userDetail['firstName']) && !empty($userDetail['lastName']) ? (ucwords($userDetail['firstName']).' '.ucwords($userDetail['lastName'])) : 'NA';?>";
       var image = "<?php echo $url;?>";
        var time = $.now();
        var firebaseId =  "<?php echo  $userDetail['firebaseId'];?>";
    </script>
  <script src="https://www.gstatic.com/firebasejs/3.3.0/firebase.js"></script>
  <script src="https://cdn.firebase.com/libs/firechat/3.0.1/firechat.min.js"></script>
  <script src="<?php echo base_url().FRONT_THEME;?>js/firebase_custome.js"></script>
    <script src="<?php echo base_url().FRONT_THEME;?>js/firebasechat.js"></script>
<?php
 }?>
	<script type="text/javascript">
		var productId = "<?php echo $details->id;?>";
		var ownerId = "<?php echo $details->ownerId;?>";
		var price = "<?php echo $details->totalPrice;?>";
		var userType = "<?php echo $userType;?>";
		var userTypeCheckStatus = "<?php echo $userTypeCheckStatus?>";
	</script>
 <div class="adjust_cntainer"> 
	<div class="extra-margin"></div>	
	<!-- single -->
	<div class="single pad-top-120">
		<div class="container">
			<div class="col-md-4 single-left">
				<div class="flexslider">
					<ul class="slides">
					    <?php if(!empty($images)) { 
							foreach ($images as $get) {                          
					    ?>
						<li data-thumb="<?php echo $get->productImage;?>">
							<div class="thumb-image"> <img src="<?php echo $get->productImage;?>" data-imagezoom="true" class="img-responsive" alt=""> </div>
						</li>
						<?php } } else{ ?>
						<li data-thumb="<?php echo base_url().FRONT_THEME;?>images/defaultProduct.jpg">
							<div class="thumb-image"> <img src="<?php echo base_url().FRONT_THEME;?>images/defaultProduct.jpg" data-imagezoom="true" class="img-responsive" alt=""> </div>
						</li>
						<?php } ?>						
					</ul>
				</div>
			</div>
			<div class="col-md-8 single-right">
				<div class="detailsHead">
					<h3><?php echo !empty($details->title) ? $details->title  : 'NA'; ?></h3>
					<span class="prc_rght"> <span class="prce"> $ <?php echo  $details->price; ?></span> 
															<span><?php echo " - " .$details->myPerProduct ; ?></span>

	               
					</span>

				</div>
				<div class="description">
<!--
					<h5>Description</h5>
-->
					<p> <?php echo !empty($details->description) ? $details->description  : 'NA'; ?> </p>
				</div>
				<div class="color-quality">					
					<div class="color-quality-right">
						<h2 class="otDetails"> Other Details :</h2>
						<div class="otherDetails">
					<?php if ($details->condition == 'new') { ?>
						<h5>Condition :<span> New </span></h5>
						<?php } else{ 
							$pAge = $details->productAge;  ?>
						<h5>Condition :<span> Used <?php echo '('.$pAge.')' ?></span></h5>
						<?php } ?>
						<h5>Category :<span> <?php echo ucfirst($details->categoryData->categoryName); ?></span></h5>

							<div>

							<div class="blockBtn">
							<h5 class="ShBtn" id="viewPrice">View Price</h5>
							<div id="showHrTbl" class="csHide priceTable">
							    <table class="table">
							        <thead>
							            <tr>
							                <th>Duration</th>
							                <th>Price</th>
							            </tr>
							        </thead>
							        <tbody>
						            	<?php $totalPrice = explode(",",$details->totalPrice);
											$productForRental = explode(",",$details->productForRental);
											foreach ($productForRental as $key => $value) { ?>
											<tr>
												<td>
													<?php 
													switch ($value) {
													    case 1:
													        echo "8 Hour";
													        break;
													    case 2:
													        echo "12 Hour";
													        break; 
													    case 3:
													        echo "24 Hour";
													        break;
													    case 4:
													        echo "1 Week";
													        break; 
													    case 5:
													        echo "1 Month";
													        break;
													}
												 	?>
												</td>
												<td><?php echo "$ ".$totalPrice[$key];?></td>
											</tr>
										<?php }	?>
							        </tbody>
							    </table>
							</div>
							
							</div>
							<div class="blockBtn1">
							<?php if($this->session->userdata('userType') == 1 || empty($this->session->userdata('userType'))){?>
								<h5 class="ShBtn view-availability requestDate1">View Availability</h5>								
							    <div id="datePickerRequest" class="csHide"></div>
							<?php }?>
							</div>
							<?php if(count($details->requestData)==1){

							$rowData = $details->requestData;
							if($rowData->modifyAvailType == 3 || $rowData->modifyAvailType == 2){
								 $modifyBookAllDate = $rowData->modifyBookStartDate.' To '.$rowData->modifyBookEndDate;
							}else{
								 $modifyBookAllDate = $rowData->modifyBookStartDate;
							}
						?>

						<a href="#" role="button" class="btn btn-default cs-btn" data-toggle="modal" data-target="#updatmodify"  data-requestid="<?php echo $rowData->rId; ?>" data-bookstartdate="<?php echo $rowData->modifyBookStartDate; ?>" data-bookenddate="<?php echo $rowData->modifyBookEndDate; ?>" data-availtype="<?php echo $rowData->modifyAvailType; ?>" data-productrorrental="<?php echo $rowData->modifyProductForRental; ?>" data-price="<?php echo $rowData->modifyPrice; ?>" data-bookalldate="<?php echo $modifyBookAllDate; ?>" id="view-modification">View Modification</a>

					<?php }?>
								
							</div>
						<h5>Product Availability Address :
							<span><?php echo !empty($details->address) ? $details->address : 'NA';?></span>
						</h5>
						<?php if(!empty($details->userMYRequestStatus)){?>
					<h5>Product Status : <span><?php echo ucfirst($details->userMYRequestStatus);?></span>
						</h5>
						<?php }?>
						</div>
					</div>
						<?php

						 if((!empty($this->session->userdata('userType')) && $this->session->userdata('userType') == 2 && $details->requestStatus != 1)){?>
						<div class="chooseTime">
						<div class="rental_Dur">
						<h5>Rental Duration</h5>
						<select id="selected_time">
								<option value="">Rental Duration</option>
								<?php 
									$totalPrice = explode(",",$details->totalPrice);
									$productForRental = explode(",",$details->productForRental);
									foreach ($productForRental as $key => $value) { ?>
										<option value="<?php echo $value;?>">
											<?php
												switch ($value) {
												   case 1:
												        echo "8 Hour";
												        break;
												    case 2:
												        echo "12 Hour";
												        break; 
												    case 3:
												        echo "24 Hour";
												        break;
												    case 4:
												        echo "1 Week";
												        break; 
												    case 5:
												        echo "1 Month";
												        break;
												}
											?>
										</option>
								<?php }	?>
							</select>
							&nbsp;<span id="rerror"></span>
							</div>							
							<div class="CsCal">
							<h5>Select Rental Date</h5>
							<input id="requestDate1" type="text" placeholder="Select Date" class="hasDatepicker requestDate1 view-availability">
							<input id="requestDate" type="hidden">
							<div id="datePickerRequest"></div>
							<span id="serror"></span>
							<input type="hidden" id="orig-dates" value="">
							<input type="hidden" id="availType" value="">
							<input type="hidden" id="requestEndDate" value="">
							<input type="hidden" id="errorValue" value="0">

							</div>
				        </div>
					<div class="clearfix"> </div>
					<?php }?>
					<?php if($this->session->userdata('userType') == 2 && !empty($details->userMYRequestData)){

						if($details->userMYRequestData->requestStatus==COMPLETE && $details->userMYRequestData->finishStatus=='pending'){
						?>
					<h5>Waiting for owner response</h5>
					<?php }else if($details->userMYRequestData->requestStatus==COMPLETE && $details->userMYRequestData->finishStatus=='sendInvoice' && $details->userMYRequestData->payStatus=='pending'){?>

					<button class="btn cs-btn send-invoice" data-toggle="modal" data-target="#FinishRental" data-bookstartdate="<?php echo $details->userMYRequestData->bookStartDate; ?>" data-bookenddate="<?php echo  $details->userMYRequestData->bookEndDate; ?>" data-price="<?php echo  $details->userMYRequestData->price; ?>" data-extrapay="<?php echo  $details->userMYRequestData->extraPay; ?>" value="<?php echo  $details->userMYRequestData->id; ?>" data-myproductforrental="<?php echo $details->userMYRequestData->myProductForRental; ?>">View Invoice</button>


					<?php }}?>
				</div>				
				<div class="simpleCart_shelfItem">	
					<?php if($this->session->userdata('front_login') == true){ 
							if($details->requestStatus != 1 && $this->session->userdata('userType') == 2){ 
					?>	
						<button class="w3ls-cart has-spinner request-send" data-type="2"  value="2">Request To Book</button>
						<?php if($details->instantBooking==1){?>
						<button class="w3ls-cart has-spinner request-send" data-type="1" value="1">Book Now</button>

							<?php }} 
						} else{ ?>
						<?php if($details->instantBooking==1){?>
							<button class='logbkNow w3ls-cart' type="submit" >Book Now</button> 
							<?php }?>
							<button class='logbkNow w3ls-cart' type="submit">Request To Book</button>
						<?php } ?>

						<?php if($this->session->userdata('front_login') == true && $this->session->userdata('userType') == 2 && $details->userMYRequestStatus==ACCEPT){?>

				         <button class="btn cs-btn finishStatus" data-toggle="modal" data-target="#FinishRental1" data-requestid="<?php echo $details->userMYRequestData->id;?>" data-finishstatus="pending" value="<?php echo $details->userMYRequestData->id;?>">Finish Rental</button>

				        <?php }?>
				
						<!-- end new logic -->
				</div>
				
			</div>
			<div class="clearfix"> </div>
		</div>
	</div> 	
	
<!-- review & rating sec -->
<div class="rev_rating">
	<div class="container">
	<div class="panel panel-default">
	    <div class="panel-heading reviewTitle">
	      <h4 class="panel-title ">
	        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" class="no_cls_arw">
	        	<?php if($this->session->userdata('front_login') == true){ 

					if($this->session->userdata('userType') == 1){ ?>
	        			Request &amp; Rating
	        	<?php }else{ ?>
	        		Owner's Review &amp; Rating
	        	<?php } }else{ ?>
	        		Owner's Review &amp; Rating
	        	<?php } ?>

	        	<span><i class="fa fa-angle-double-down"></i></span></a>
	      </h4>
	    </div>
    	<div aria-expanded="true" class="panel-collapse collapse" id="collapse1">
      		<div class="panel-body" style="display:<?php echo $userDiv;?>">
				<div class="tab-2 resp-tab-content additional_info_grid" aria-labelledby="tab_item-1">
				  <div class="row">
				  	<div class="col-md-4 col-sm-4">
				  		<div class="productOwner">
				  			<div class="bgHead">
				  				<h2>Owner Details</h2>
				  			</div>
				  			<div class="ownerIneer">
					  			<div class="OwnerImg">					  				
					  				<?php if(!filter_var($ownerDetail['profileImage'], FILTER_VALIDATE_URL) === false) { ?>
										<img src="<?php echo $ownerDetail['profileImage'];?>"/>										
									<?php }else if(!empty($ownerDetail['profileImage'])){ ?>										
										<img src="<?php echo base_url().'uploads/profile/'.$ownerDetail['profileImage'];?>"/>
									<?php } else{  ?>										                                                     
										<img src= "<?php echo base_url().FRONT_THEME;?>images/team3.png">										
									<?php } ?>
					  			</div>
					  			<div class="ownerInfo">
					  				<h3><a href="#"><?php echo !empty($ownerDetail['firstName']) && !empty($ownerDetail['lastName']) ? (ucwords($ownerDetail['firstName']).' '.ucwords($ownerDetail['lastName'])) : 'NA';?></a></h3>
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
					  				<div class="btnProfile">
					  					<a href="<?php echo base_url().'user/profile/'.$ownerDetail['id'];?>" class="csBtnIcon"><i class="fa fa-eye"></i> View Profile</a>
					  					<?php if($this->session->userdata('front_login') == true){ ?>
										<a href="<?php echo base_url().'chat/index/'.$ownerDetail['id']."/".$details->id;?>" class="csBtnIcon"><i class="fa  fa-commenting"></i> Chat</a>
										<?php }else{?>
										<a href="JavaScript:void(0);" class="chatFirst w3ls-cart csBtnIcon"><i class="fa  fa-commenting"></i> Chat</a>
										<?php }?>

					  				</div>
					  				<ul class="list-unstyled">
					  					<li><i class="fa fa-envelope"></i><?php echo !empty($ownerDetail['email']) ? $ownerDetail['email']: 'NA';?></li>
					  					<li><i class="fa fa-phone"></i><?php echo !empty($ownerDetail['countryCode']) && !empty($ownerDetail['contactNo']) ? (($ownerDetail['countryCode']).'-'.($ownerDetail['contactNo'])) : 'NA';?></li>
					  					<li><i class="fa fa-map-marker"></i><?php echo !empty($ownerDetail['address']) ? $ownerDetail['address']: 'NA';?></li>
					  					<li><i class="fa fa-info"></i><?php echo !empty($ownerDetail['about']) ? $ownerDetail['about']: 'NA';?></li>
					  				</ul>
					  			</div>
				  			</div>
				  		</div>
				  	</div>
				    <div class="col-sm-8 col-md-8">
				    	<div class="revSection">
				    	<div class="bgHead">
				    <h2><?php if(!empty($countReviews)) {

				    		echo '('.$countReviews.')';

				    	} else{ 

				    		echo "No";
				    		}?> Reviews</h2>
<!-- 				    		<a href="#" role="button" class="btn btn-default" data-target="#myModal3"  data-toggle="modal">Give Review</a>
 -->			    		<!-- myModal3 -->
				    	</div>
				    	<div class="reviewList">
               			<?php if(!empty($reviews)) {

    	               		foreach ($reviews as $res) {
    	               			# code...				    	           		
	    	            ?>
						<div class=" media additional_info_sub_grids">
							<div class="media-left">
								<div class="additional_info_sub_grid_left">
									<?php $url= base_url().FRONT_THEME.'images/defaultUser.jpg'; 
									if(!empty($res->profileImage)){
										if(!filter_var($res->profileImage, FILTER_VALIDATE_URL) === false){
											$url = $res->profileImage;
										}else{
											$url= base_url()."/uploads/profile/".$res->profileImage;
										}
									} ?>
								<a href="<?php echo base_url('user/profile')."/".$res->uId."/".$res->productId;?>">	<img src="<?php echo $url;?>" alt="<?php echo !empty($res->firstName) && !empty($res->lastName) ? (ucwords($res->firstName).' '.ucwords($res->lastName)) : 'NA';?> " class="img-responsive"></a>
								</div>
							</div>
							<div class="media-body">
							<div class="additional_info_sub_grid_right">
								<div class="additional_info_sub_grid_rightl">
									<a href="<?php echo base_url('user/profile')."/".$res->uId."/".$res->productId;?>"><?php echo !empty($res->firstName) && !empty($res->lastName) ? (ucwords($res->firstName).' '.ucwords($res->lastName)) : 'NA';?>
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
									<p><?php echo (!empty($res->comment)) ? $res->comment : 'NA';  ?></p>
								</div>
								<div class="clearfix"> </div>
							</div>
							</div>
						</div>
						<?php } } ?>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Start Owner Section -->

	<div class="DetailsInner" id="ownerDiv" style="display:<?php echo $ownerDiv;?>">
		<div class="product-tabs-wrapper">
		    <ul class="product-content-tabs nav nav-tabs" role="tablist">
			    <li class="nav-item active">
			    	<a class="active" href="#tab_description" role="tab" data-toggle="tab">Current Renters</a>
			    </li>
			    <li class="nav-item">
			    	<a class="" href="#tab_additional_information" role="tab" data-toggle="tab">Request</a>
			    </li>
			    <li class="nav-item">
			    	<a class="" href="#tab_reviews" role="tab" data-toggle="tab">Reviews</a>
			    </li>
			    <li class="nav-item">
			    	<a class="" href="#tab_custom" role="tab" data-toggle="tab">Previous Renters</a>
			    </li>
		    </ul>
		    <div class="product-content-Tabs_wraper tab-content">

			    <div id="tab_description" role="tabpanel" class="tab-pane fade in active">
				    <!-- Accordian Title -->
				    <h6 class="product-collapse-title" data-toggle="collapse" data-target="#tab_description-coll">Description</h6>
				    <!-- End Accordian Title -->
				    <!-- Accordian Content -->
				    <div id="tab_description-coll" class="shop_description product-collapse collapse">
						<?php if(!empty($currentRenters)){ 
						
							foreach($currentRenters as $row){?>
						<div class=" media additional_info_sub_grids">
							<div class="media-left">
								<div class="additional_info_sub_grid_left">			
									<img src="<?php echo $row->profileImage;?>" alt=" " class="img-responsive">
								</div>
							</div>
							<div class="media-body">
								<div class="additional_info_sub_grid_right">
									<div class="additional_info_sub_grid_rightl">
										<a href="<?php echo base_url('user/profile')."/".$row->uId."/".$row->productId;?>"><?php echo ucwords($row->fullName);?></a>
										<p>Date Rented: 
											<span>
												<?php 
														if($row->availType == 3 || $row->availType == 2){

															echo $bookAllDate = $row->bookStartDate.' To '.$row->bookEndDate;
														}else{
															echo $bookAllDate = $row->bookStartDate;
														}
															
													?>
											</span>
										</p>
										<p>Rental Duration : <?php echo $row->myProductForRental;?></p>
										<p>Product Status : <?php echo ucfirst($row->requestStatus);?></p>
										<p>Price : $ <?php echo ($row->price);?></p>
										<p><?php echo $row->crd;?></p>
										<?php if($row->requestType==BookNow && $row->modifyRequestStatus!=ACCEPT){?>
										<div class="RenterAction">
								         
											<?php 

											if($row->requestStatus==COMPLETE && $row->finishStatus=="pending"){?>

													<button class="btn cs-btn has-spinner fenish-request-update" value="accept" data-requestid="<?php echo $row->rId; ?>">Accept</button>
													<button class="btn cs-btn has-spinner fenish-request-update" value="reject" data-requestid="<?php echo $row->rId; ?>">Reject</button>

											<?php }else if($row->requestStatus==ACCEPT){ ?>
											 	<button class="btn cs-btn has-spinner request-update" value="reject" data-requestid="<?php echo $row->rId; ?>">Reject</button>
											<a href="#" role="button" class="btn btn-default cs-btn request-modifiy" data-toggle="modal" data-target="#modify" data-requestid="<?php echo $row->rId; ?>" data-bookstartdate="<?php echo $row->bookStartDate; ?>" data-bookenddate="<?php echo $row->bookEndDate; ?>" data-availtype="<?php echo $row->availType; ?>" data-productrorrental="<?php echo $row->productForRental; ?>" data-price="<?php echo $row->price; ?>" data-bookalldate="<?php echo $bookAllDate; ?>" id="rq-modifiy">Modify</a>
											<button class="btn cs-btn finishStatus" data-toggle="modal" data-target="#FinishRental1" data-requestid="<?php echo $row->rId; ?>"  data-finishStatus="accept" value="<?php echo $row->rId; ?>">Finish Rental</button>

											

											<?php }elseif($row->requestStatus==COMPLETE && $row->finishStatus=="accept" || $row->finishStatus=="sendInvoice"){ ?>
											
												<button class="btn cs-btn send-invoice" data-toggle="modal" data-target="#FinishRental" data-bookstartdate="<?php echo $row->bookStartDate; ?>" data-bookenddate="<?php echo $row->bookEndDate; ?>" data-price="<?php echo $row->price; ?>" data-myproductforrental="<?php echo $row->myProductForRental; ?>" data-extrapay="<?php echo $row->extraPay; ?>" value="<?php echo $row->rId; ?>">Send Invoice</button>
											<?php }?>

											<a href="<?php echo base_url().'chat/index/'.$row->userId."/".$row->productId;?>" class="btn cs-btn "><i class="fa  fa-commenting"></i> Chat</a>
											</div>
										<?php }else{?>
																				<div class="RenterAction">
											<?php 

											if($row->requestStatus==COMPLETE && $row->finishStatus=="pending"){?>

													<button class="btn cs-btn has-spinner fenish-request-update" value="accept" data-requestid="<?php echo $row->rId; ?>">Accept</button>
													<button class="btn cs-btn has-spinner fenish-request-update" value="reject" data-requestid="<?php echo $row->rId; ?>">Reject</button>

											<?php }else if($row->requestStatus==ACCEPT){ ?>

											<button class="btn cs-btn finishStatus" data-toggle="modal" data-target="#FinishRental1" data-requestid="<?php echo $row->rId; ?>"  data-finishstatus="accept" value="<?php echo $row->rId; ?>">Finish Rental</button>

											

											<?php }elseif($row->requestStatus==COMPLETE && $row->finishStatus=="accept" || $row->finishStatus=="sendInvoice"){ ?>
											
												<button class="btn cs-btn send-invoice" data-toggle="modal" data-target="#FinishRental" data-bookstartdate="<?php echo $row->bookStartDate; ?>" data-bookenddate="<?php echo $row->bookEndDate; ?>" data-price="<?php echo $row->price; ?>" data-extrapay="<?php echo $row->extraPay; ?>"  data-myproductforrental="<?php echo $row->myProductForRental; ?>"  value="<?php echo $row->rId; ?>">Send Invoice</button>
											<?php }?>
											
											<a href="<?php echo base_url().'chat/index/'.$row->userId."/".$row->productId;?>" class="btn cs-btn "><i class="fa  fa-commenting"></i> Chat</a>
										</div>
										<?php }?>
									</div>
								</div>
							</div>
						</div>
						<?php } }else{ echo "No Record Found";?>
						<?php } ?>
				    </div>
				    <!-- End Accordian Content -->
			    </div>

			    <div id="tab_additional_information" role="tabpanel" class="tab-pane fade">
				    <!-- Accordian Title -->
				    <h6 class="product-collapse-title" data-toggle="collapse" data-target="#tab_additional_information-coll">Request</h6>
				    	<!-- End Accordian Title -->

					    <!-- Accordian Content -->
					    <div id="tab_additional_information-coll" class="product-collapse collapse">
					    	
			               <?php if(!empty($allRequest)){ foreach($allRequest as $rowData){?>
							<div class="media additional_info_sub_grids">

							    <div class="media-left">
							      <div class="additional_info_sub_grid_left">
										<img src="<?php echo $rowData->profileImage;?>" alt=" " class="img-responsive">
									</div>
							    </div>
							    <div class="media-body">
							      <div class="additional_info_sub_grid_right">
							        <div class="additional_info_sub_grid_rightl">
							          <a href="<?php echo base_url('user/profile')."/".$rowData->uId."/".$rowData->productId;?>"><?php echo ucwords($rowData->fullName);?></a>
							          <p><i class="fa fa-calendar"></i> 
							          			<?php 

													if($rowData->availType == 3 || $rowData->availType == 2){
															echo $bookAllDate = $rowData->bookStartDate.' To '.$rowData->bookEndDate;
														}else{
															echo  $bookAllDate = $rowData->bookStartDate;
														}
														if($rowData->modifyAvailType == 3 || $rowData->modifyAvailType == 2){
															echo $modifyBookAllDate = $rowData->modifyBookStartDate.' To '.$rowData->modifyBookEndDate;
														}else{
															echo  $modifyBookAllDate = $rowData->modifyBookStartDate;
														}
														?></p>


								       <p>Rental Duration : <?php echo $rowData->myProductForRental;?></p>
										<p>Product Status : <?php echo ucfirst($rowData->requestStatus);?></p>
							          <p><?php echo $rowData->crd;?></p>
							          <?php if($rowData->requestStatus==PENDING){?>

								          	<div class="RenterAction">
									          	<button class="btn cs-btn has-spinner request-update" value="accept" data-requestid="<?php echo $rowData->rId; ?>">Accept</button>
									          	<button class="btn cs-btn has-spinner request-update" value="reject" data-requestid="<?php echo $rowData->rId; ?>">Reject</button>
												<a href="#" role="button" class="btn btn-default cs-btn request-modifiy" data-toggle="modal" data-target="#modify" data-requestid="<?php echo $rowData->rId; ?>" data-bookstartdate="<?php echo $rowData->bookStartDate; ?>" data-bookenddate="<?php echo $rowData->bookEndDate; ?>" data-availtype="<?php echo $rowData->availType; ?>" data-productrorrental="<?php echo $rowData->productForRental; ?>" data-price="<?php echo $rowData->price; ?>" data-bookalldate="<?php echo $bookAllDate; ?>" id="rq-modifiy">Modify</a>
												<a href="<?php echo base_url().'chat/index/'.$rowData->userId."/".$rowData->productId;?>" class="btn cs-btn "><i class="fa  fa-commenting"></i> Chat</a>
											</div>

										<?php }else{?>
										<p>Waiting For User Response</p>

										<div class="RenterAction">
										<a href="#" role="button" class="btn btn-default cs-btn request-modifiy" data-toggle="modal" data-target="#updatmodify"  data-requestid="<?php echo $rowData->rId; ?>" data-bookstartdate="<?php echo $rowData->modifyBookStartDate; ?>" data-bookenddate="<?php echo $rowData->modifyBookEndDate; ?>" data-availtype="<?php echo $rowData->modifyAvailType; ?>" data-productrorrental="<?php echo $rowData->modifyProductForRental; ?>" data-price="<?php echo $rowData->modifyPrice; ?>" data-bookalldate="<?php echo $modifyBookAllDate; ?>" id="view-modification">View Modification</a>
										<a href="<?php echo base_url().'chat/index/'.$rowData->userId."/".$rowData->productId;?>" class="btn cs-btn "><i class="fa  fa-commenting"></i> Chat</a>
											</div>

										<?php }?>
							        </div>
							      </div>
							    </div>
							</div>
							<?php } }else{ echo "No Record Found";?>
							<?php } ?>   

						

					    </div>
					    <!-- End Accordian Content -->
			    </div>

			    <div id="tab_reviews" role="tabpanel" class="tab-pane fade">
			    <!-- Accordian Title -->
			    <h6 class="product-collapse-title" data-toggle="collapse" data-target="#tab_reviews-coll">Reviews</h6>
			    <!-- End Accordian Title -->
			    <!-- Accordian Content -->
			    <div id="tab_reviews-coll" class=" product-collapse collapse">
			    	<?php if(!empty($reviews)) {
			    		
	               		foreach ($reviews as $res) { 	           		
    	            ?>
			    	<div class=" media additional_info_sub_grids">
						<div class="media-left">
							<div class="additional_info_sub_grid_left">
								<?php $url= base_url().FRONT_THEME.'images/defaultUser.jpg'; 

								if(!empty($res->profileImage)){
								if(!filter_var($res->profileImage, FILTER_VALIDATE_URL) === false){
								$url = $res->profileImage;
								}else{
								$url= base_url()."/uploads/profile/".$res->profileImage;
								}
								} ?>
								<img src="<?php echo $url;?>" alt=" " class="img-responsive">
							</div>
						</div>
						<div class="media-body">
							<div class="additional_info_sub_grid_right">
								<div class="additional_info_sub_grid_rightl">
									<a href="<?php echo base_url('user/profile')."/".$res->uId."/".$res->productId;?>"><?php echo !empty($res->firstName) && !empty($res->lastName) ? (ucwords($res->firstName).' '.ucwords($res->lastName)) : 'NA';?>
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
									<p><?php echo (!empty($res->comment)) ? $res->comment : 'NA';  ?></p>
								</div>
								<div class="clearfix"> </div>
							</div>
						</div>
					</div>
					<?php } }else { echo "No Record Found";} ?>
			    </div>
			    <!-- End Accordian Content -->
			    </div>

			    <div id="tab_custom" role="tabpanel" class="tab-pane fade">
			    <!-- Accordian Title -->
			    <h6 class="product-collapse-title" data-toggle="collapse" data-target="#tab_custom-coll">Previous Renters</h6>
			    <!-- End Accordian Title -->
			    <!-- Accordian Content -->
			    
			    <div id="tab_custom-coll" class="shop_description product-collapse collapse">
			    	<?php if(!empty($prevRequest)){ foreach($prevRequest as $row){?>
			    	<div class="media additional_info_sub_grids">
	                    <div class="media-left">
	                      	<div class="additional_info_sub_grid_left">
								<img src="<?php echo $row->profileImage;?>" alt=" " class="img-responsive">
							</div>
	                    </div>
	                    <div class="media-body">
	                      <div class="additional_info_sub_grid_right">
	                        <div class="additional_info_sub_grid_rightl">
	                          <a href="<?php echo base_url('user/profile')."/".$row->userId."/".$row->productId;?>"><?php echo ucwords($row->fullName);?></a>
                          			<p>Date Rented: <span>
	                          	<?php 

      								if($row->availType == 3 || $row->availType == 2){
													echo $bookAllDate = $row->bookStartDate.' To '.$row->bookEndDate;
												}else{
													echo  $bookAllDate = $row->bookStartDate;
												}
									
								?></span></p>
								
								<p>Rental Duration : <?php echo $row->myProductForRental;?></p>
								<p>Product Status : complete</p>
								<p>Price :<?php echo '$ '.$row->price;?></p>

	                         
	                          <div class="amountPaid">
                          		<p>Amount Paid :  $ <span><?php echo ($row->price)+($row->extraPay);?></span></p>
                      			</div>
	                        </div>
	                      </div>
	                    </div>
	                </div>
	                 <?php } }else { echo "No Record Found";} ?>
			    </div>
			   
			    <!-- End Accordian Content -->
			    </div>
			</div>
		</div>
	</div>
		<!-- End Owner Section -->
</div>
</div>
</div>
</div>
	
	
	<!-- Related Products -->
	<?php if(!empty($related)) { ?>
	<section id="deals" class="bg-white pad-top-120 pad-bottom-120 deal-block">
				<div class="container">
					<div class="row">
						<header class="col-lg-12 col-md-12 col-sm-12 col-x-12 wow fadeInUp animated" data-wow-delay="0.5s">						
							<h2 class="secTitle"> Related Products </h2>
						</header>
						<article class="col-lg-offset-1 col-md-offset-1 col-lg-10 col-md-10 col-sm-12 col-xs-12 deal-slider wow fadeInUp animated" data-wow-delay="0.5s">
								<div id="owl-deal" class="pad-top-120">
							<?php 	foreach ($related as $r) { ?> 

											<div class="item col-md-4 col-xs-12">
												<div class="dealInfo_Img">
								   			    	<a href="<?php echo base_url().'products/viewProduct/'.$r->id;?>">
								  					<img src="<?php echo $r->productImage;?>" alt="Image">
								  					</a>
													<?php if($r->isRented=="1"){?>
													<span class="onRent"><img src="<?php echo base_url().FRONT_THEME;?>images/rented.png"></span>
													<?php }if($r->condition=="new"){?>
													<span class="onNew"><img src="<?php echo base_url().FRONT_THEME;?>images/ico_new_item.png"></span>
													<?php }else{?>
							                          <span class="onNew"><img src="<?php echo base_url().FRONT_THEME;?>images/used.png"></span>
							                        <?php }?>
								  				</div>
												<div class="dealInfo newCsPr">
													<div class="NewL">
														<h5> <?php echo $r->title; ?> </h5>
													</div>
													<div class="NewR">
													    <p><span><?php echo  '$ '.$r->price; ?> </span> - <?php echo $r->myPerProduct;?></p>

													</div>
														<a href="<?php echo base_url().'products/viewProduct/'.$r->id;?>" class="cs-btn">view detail</a>
												</div>
											</div>
											  		
							<?php }  ?>	 
							</div>
						</article>
					</div>
				</div>
			</section>
			<?php }?>
</div> 


	<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="myModalLabel">Give Your Review</h4>
        </div>
        <div class="modal-body">
          	<div class="review_grids">
				<form action="#" method="post">
					<div class="productImg1">
						<img src="<?php echo $images[0]->productImage;?>">
					</div>
					<div class="ratingStar">
						<p class="rt_str">
						  <?php
						  for($i=1;$i<=5;$i++)
						  {
						  	?>
						  	<span id="rate_<?php echo $i;?>" onclick="rate('<?php echo $i;?>')" class="fa fa-star-o"></span> 
						  	<?php
						  }
						  ?>
						  	<input type="hidden" id="rate_value" name="rate_value" value="" />
						 
						</p>
						<div id="rate_error"></div>
					</div><!-- data-emojiable="true" -->
					<div class="csEmojiInput">
					<textarea class="form-control" name="Review" id="review" placeholder="Add Your Review" data-emojiable="true" ></textarea>
				</div>
					<div id="review_error"></div>
					<button type="button" class="btn btn-primary cs-btn has-spinner review-submit" value="1">Submit</button>
				</form>
			</div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

    <!-- check login -->
  <div class="modal fade bookModal" id="loginchatFirst" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="myModalLabel">Login First</h4>
        </div>
        <div class="modal-body">
          	<div class="review_grids">					
				<div class="ratingStar">						
					<p class="rt_str">						 
					  	Please login first for chat.
					</p>
				</div>					
				<a href="<?php echo base_url();?>signup/login" class="btn btn-primary cs-btn">OK</a>
			</div>
        </div>
      </div>
    </div>
  </div>

  <!-- check login -->
  <div class="modal fade bookModal" id="loginFirst" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="myModalLabel">Login First</h4>
        </div>
        <div class="modal-body">
          	<div class="review_grids">					
				<div class="ratingStar">						
					<p class="rt_str">						 
					  	Please login first for booking product.
					</p>
				</div>					
				<a href="<?php echo base_url();?>signup/login" class="btn btn-primary cs-btn">OK</a>
			</div>
        </div>
      </div>
    </div>
  </div>
  <!-- end check login -->

    <!-- modification -->
  <div class="modal fade bookModal modifyModal" id="modify" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="myModalLabel">Modify Booking</h4>
        </div>
        <div class="modal-body">
          	<div class="review_grids">					
				<div class="productAdInner">
		          <form method="" action="">
		            <div class="form-group">
		              <div>

		              	<input class="form-control" placeholder="Price" type="number" id="price" onkeypress="return isNumberKey(event);">
		              	<span id="price-error"></span>
		              </div>
		              <div id="PriceTime" class="inputSelect">
		          		<span>
		                  <input id="time2" name="priceHours" class="selected_time" value="1" type="radio">
		                  <label for="time2">8 Hours</label>
		                </span>
		               <span>
		                  <input id="time3" name="priceHours" class="selected_time" value="2" type="radio">
		                  <label for="time3">12 Hours</label>
		                </span>
		                <span>
		                  <input id="time4" name="priceHours" class="selected_time" value="3" type="radio">
		                  <label for="time4">24 Hours</label>
		                </span>
		                <span>
		                  <input id="time5" name="priceHours" class="selected_time" value="4" type="radio">
		                  <label for="time5">1 Week</label>
		                </span>
		                <span>
		                  <input id="time6" name="priceHours" class="selected_time" value="5" type="radio">
		                  <label for="time6">1 Month</label>
		                </span>
		              </div>
		            </div>
		            <input type="hidden" id="requestid">
		            <input type="hidden" id="selected_time" value="1"  name="">
		            <input type="hidden" id="orig-dates" value="">
					<input type="hidden" id="availType" value="">
					<input type="hidden" id="requestEndDate" value="">
					<input type="hidden" id="errorValue" value="0">
					<input id="requestDate" type="hidden">
					<input type="hidden" id="calType" name="">
		            <div class="form-group">
		              <input class="form-control hasDatepicker requestDate1 view-modify-availability" id="requestDate1" placeholder="Availability Calender" type="text" readonly="">
		              <div id="modify-datePickerRequest" class="csHide"></div>
		              <span id="serror"></span>
		            </div>
		            <a href="javascript:void(0)"" class="btn btn-primary cs-btn has-spinner" id="request-modifiy-update">Submit</a>
		          </form>
		        </div>
			</div>
        </div>
      </div>
    </div>
  </div>
  <!-- modification login -->
  <!-- request book -->
  <div class="modal fade bookModal" id="updatmodify" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="myModalLabel">View Modification</h4>
        </div>
        <div class="modal-body">
          	<div class="review_grids modifycs">
				<form action="#" method="post">			
					<div class="ratingStar">
					<input type="hidden" id="mrequestid" name="">		 
						<p class="rt_str csTag">Date Rented: <span id="modify-date"></span></p>
						<p class="rt_str csTag">Rental Duration : <span id="modify-slot"></span></p>
						<p class="rt_str csTag">Price : <span id="modify-price"></span></p>
					</div>					
					<?php if($this->session->userdata('userType')==2){?>				
						<button class="btn cs-btn has-spinner modify-update" value="accept" type="button">Confirm</button>
						<button class="btn cs-btn has-spinner modify-update" value="reject" type="button">Reject</button>
					<?php }?>	
				</form>
			</div>
        </div>
      </div>
    </div>
  </div>
  <!-- end request book -->


  <!-- email Verfication check -->
  <div class="modal fade bookModal" id="userTypeCheckStatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
<!--           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
 -->          <h4 class="modal-title" id="myModalLabel">Alert</h4>
        </div>
        <div class="modal-body">
            <div class="review_grids emilver">
          <div class="ratingStar">
<!--             <p class="rt_str">Email varification Needed</p>   
 -->            <p class="rt_str csTag"><span>First you need to switch your profile as a owner to view product detail</span></p>
          </div>          
          <a href="<?php echo base_url('user/myProfile');?>" class="btn btn-primary cs-btn">Ok</a>
      </div>
        </div>
      </div>
    </div>
  </div>
  <!-- email Verfication check -->

  <!-- Finish Rental -->
  <div class="modal fade bookModal" id="FinishRental1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="FinishRenta1lLabel">Finish Rental</h4>
        </div>
        <div class="modal-body">
          	<div class="review_grids finishRent1">
          		<div class="ratingStar">						
					<p class="rt_str">						 
					  	Are you sure want to finish this service.
					</p>
				</div>
			</div>
			<div class="text-center">
			<input type="hidden" id="finishStatus" name="">
			<button type="button" class="btn btn-primary cs-btn has-spinner finishRental"  value="">Finish</button>
			</div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade bookModal" id="FinishRental" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="FinishRentalLabel">Invoice</h4>
        </div>
        <div class="modal-body">
          	<div class="review_grids finishRent">
          		<div class="rentalData">
          			<div class="rentalImg">
          				<img class="Rpr" src="<?php echo $images[0]->productImage;?>">
          				<h3><?php echo !empty($details->title) ? $details->title  : 'NA'; ?></h3>
          				<img class="ZigzagImg" src="<?php echo base_url().FRONT_THEME;?>images/scallops.png">
          			</div>
          			<div class="RentalDuration">
          				<ul class="list-unstyled">
          					<li><span>Rented From</span> <div id="rFrom">15-4-2017</div</li>
          					<li><span>Rented To</span> <div id="rTo">15-4-2017</div></li>
          					<li><span>Service For</span> <div id="sFor"></div></li>
          					<li><span>Price</span> <div id="fprice"> $200</div></li>
          					<input type="hidden" id="f-price-hidden">
          					<?php if($this->session->userdata('userType') == 1){?>
          					  <li><span>Extra Charges</span> $<input type="text" onkeypress="return isNumberKey(event);" id="extra-payment" <?php if($this->session->userdata('userType') == 2){ echo "readonly";}?>>

      						<p>Admin Fee <?php echo $adminFees;?> %</p>
      						<?php }else{?>
      						<li id="extra-data"><span>Extra Charges</span> <div id="extra-payment"> $200</div></li>

      						<?php }?>
          					</li>
          					<li><span>Total Price</span> <div id="totalPrice"></div></li>
          				</ul>
          			</div>
          		</div>
			</div>
			<?php if($this->session->userdata('userType') == 2){?>
			<div class="text-center">
			<button type="button" class="btn btn-primary cs-btn has-spinner paynow payRequestID">Pay Now</button> 
			</div>
			<?php }else{?>
			<div class="text-center">
			<button type="button" class="btn btn-primary cs-btn has-spinner sendInvoice payRequestID">Send Invoice</button> 
			</div>
			<?php }?>
        </div>
      </div>
    </div>
  </div>
  <!-- end request book -->

<script type="text/javascript">

function rate(no)
{
	for(var i=1;i<=5;i++)
	{
		if(i<=no)
		{
			$("#rate_"+i).attr('class','fa fa-star');
		}
		else
		{
			$("#rate_"+i).attr('class','fa fa-star-o');
		}
	}
	$("#rate_value").val(no);
}
</script>

<script>
var path = base_url+"../../<?php echo FRONT_THEME.'js/lib/img/';?>";
      $(function() {
        // Initializes and creates emoji set from sprite sheet
        window.emojiPicker = new EmojiPicker({
          emojiable_selector: '[data-emojiable=true]',
          assetsPath: path,
          popupButtonClasses: 'fa fa-smile-o'
        });
        // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
        // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
        // It can be called as many times as necessary; previously converted input fields will not be converted again
        window.emojiPicker.discover();
      });
    </script>
    <script>
      // Google Analytics
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-49610253-3', 'auto');
      ga('send', 'pageview');
    </script>