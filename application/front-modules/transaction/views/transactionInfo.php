 	<script type="text/javascript">
		var userTypeCheckStatus = "0";
		var productId = "<?php echo $transactionInfo->productId;?>";
		var ownerId = "<?php echo $transactionInfo->ownerId;?>";
		var link = "<?php echo base_url('products/viewProduct/')."/".$transactionInfo->productId;?>";
		var title = "<?php echo $details->title;?>";
		var productImage = "<?php echo $images[0]->productImage;?>";
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
					<div class="shearPart">
					<div class="row ">
						<div class="col-md-7">
							<h3><?php echo !empty($details->title) ? $details->title  : 'NA'; ?></h3>
						</div>
						<?php if($this->session->userdata('userType') != 1 && $transactionInfo->payStatus!="pending"){?>
						<div class="col-md-5">
							<div class="socialic text-right">
								<a href="javascript: void(0)" class="fa fa-facebook" id="fb-publish"></a>
								<a href="http://twitter.com/share?url=<?php echo base_url('products/viewProduct/')."/".$transactionInfo->productId;?>&text=<?php echo $details->title;?>" class="fa fa-twitter twitter popup"></a>
								<a href="https://plus.google.com/share?url=<?php echo base_url('products/viewProduct/')."/".$transactionInfo->productId;?>&text=<?php echo $details->title;?>&description=<?php echo $details->description;?>" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="fa fa-google"></a>
								<a href="https://www.linkedin.com/shareArticle?url=<?php echo base_url('products/viewProduct/')."/".$transactionInfo->productId;?>&title=<?php echo $details->title;?>&text=<?php echo $details->description;?>&submitted-image-url=<?php echo $images[0]->productImage;?>" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="fa fa-linkedin"></a>
								<a  href="http://pinterest.com/pin/create/button/?url=<?php echo base_url('products/viewProduct/')."/".$transactionInfo->productId;?>&media=<?php echo $images[0]->productImage;?>&description=<?php echo $details->description;?>&title=<?php echo $details->title;?>" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="fa fa-pinterest"></a>
							</div>
						</div>
						<?php }?>
					</div>
					</div>
					<span class="prc_rght"> <span class="prce"> $ <?php echo  $details->price; ?></span> 
					<span><?php echo " - " .$details->myPerProduct ; ?></span>	           
					</span>
				</div>
				<div class="description">
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="color-quality">					
					<div class="tranDetTable color-quality-right">
						<h2 class="otDetails"> Product Rental Details :</h2>
						<div class="otherDetails">
							<table>
								<tbody>
									<?php if(!empty($transactionInfo->transactionId)){?>
									<tr>
										<td>Transaction Id</td>
										<td>#<?php echo $transactionInfo->transactionId;?></td>
									</tr>
									<?php }?>
									<tr>
										<td>Condition</td>
										<td>	<?php if ($details->condition == 'new') { ?> New <?php } else{
							$pAge = $details->productAge;  ?> Used <?php echo '('.$pAge.')' ?><?php } ?></td>
									</tr>
									<tr>
										<td>Start of Rental</td>
										<td><?php echo $transactionInfo->bookStartDate;?></td>
									</tr>
									<tr>
										<td>End of Rental</td>
										<td><?php echo $transactionInfo->bookEndDate;?></td>
									</tr>
									<tr>
											<td>Total Time</td>
											<td><?php echo $transactionInfo->myProductForRental;?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>						
				</div>
					</div>
					<div class="col-md-6">
						<div class="color-quality">					
							<div class="tranDetTable color-quality-right">
								<h2 class="otDetails"> Payment Details :</h2>
								<div class="otherDetails">
								<table>
									<tbody>
										<?php if(!empty($transactionInfo->extraPay)){?>
										<tr>
											<td>Extra Payment</td>
											<td>$<?php echo $transactionInfo->extraPay;?></td>
										</tr>
										<?php }?>
										<tr>
											<td>Total Amount</td>
											<td>$<?php echo $t = $transactionInfo->price + $transactionInfo->extraPay;?></td>
										</tr>
										<?php if($this->session->userdata('userType') == 1){?>
										<tr>
											<td>Admin Fee</td>
											<?php $adminFee =  $t/$transactionInfo->adminFess;?>
											<td><span class="cred">$<?php echo $adminFee;?> (<?php echo $transactionInfo->adminFess;?>%)</span></td>
										</tr>
										<tr>
											<td>Subtotal Amount</td>
											<td>$<?php echo $t-$adminFee;?></td>
										</tr>
										<?php }?>
									</tbody>
								</table>
								</div>
							</div>					
						</div>
					</div>
				</div>
				<?php if($this->session->userdata('userType')!=1){?>
				<div class="simpleCart_shelfItem pay_button">	
					<?php if($transactionInfo->reviewStatus=="pending" && $transactionInfo->payStatus!="pending"){?>
					<a class="logbkNow w3ls-cart"  href="#" data-target="#myModal3"  data-toggle="modal">Review</a>

					<?php }?>
					<?php if($transactionInfo->payStatus=="pending"){?>
					<a class="logbkNow w3ls-cart" href="<?php echo base_url('payment')."/index/".$transactionInfo->id;?>">Payment</a>
 					<?php }?>
				</div>
				<?php }?>				
			</div>
			<div class="clearfix"> </div>
		</div>
	</div> 	
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
					<button type="button" class="btn btn-primary cs-btn has-spinner review-submit" value="<?php echo $transactionInfo->id;?>">Submit</button>
				</form>
			</div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- end Review book -->
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