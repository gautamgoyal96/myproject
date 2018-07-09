<!-- Banner Section Begins -->
	<section class="bannerBox">
	    <div id="main-slider">
	        <div id="owl-example" class="owl-carousel bg-offwhite">
	            <div class="owl-slide slide-1">
	                <div class="owl--text">
	                    <div class="container">
	                        <div class="row">
	                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 wow fadeInUp animated" data-wow-delay="0.5s">
	                                <div class="sliderText">
	                                    <h1> "BUYING...BAD.<br>RENTING...GOOD."</h1>
	                                    <h5>"Its like borrowing from your neighbor...without the guilt."</h5>
	                                    <a href="javascript:void(0);" class="obtn"> Explore Now </a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class="owl-slide slide-2">
	                <div class="owl--text">
	                    <div class="container">
	                        <div class="row">
	                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 wow fadeInUp animated" data-wow-delay="0.5s">
	                                <div class="sliderText">
	                                    <h1> "BUYING...BAD.<br>RENTING...GOOD."</h1>
	                                    <h5>"Its like borrowing from your neighbor...without the guilt."</h5>
	                                    <a href="javascript:void(0);" class="obtn"> Explore Now </a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class="owl-slide slide-3">
	                <div class="owl--text">
	                    <div class="container">
	                        <div class="row">
	                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 wow fadeInUp animated" data-wow-delay="0.5s">
	                                <div class="sliderText">
	                                    <h1> "BUYING...BAD.<br>RENTING...GOOD."</h1>
	                                    <h5>"Its like borrowing from your neighbor...without the guilt."</h5>
	                                    <a href="javascript:void(0);" class="obtn"> Explore Now </a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</section>
	<!-- Banner Section Ends -->

	<!-- Tour Section Begins -->
	<section id="tour">
		<div class="container">
			<div class="row wow fadeInUp animated" data-wow-delay="0.5s">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
					<h3>Find & rent whatever you need for your next project.</h3>
				</div>		
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="tab-content" id="myTabContent">
					    <div class="tab-pane fade in active" role="tabpanel" id="tours" aria-labelledby="tours-tab">
					        <div class="tourForm">
					        	<form method="post" action="<?php echo base_url('products/searchProduct'); ?>">
					        		<div class="formBox">
					        			<label>Choose Category</label>
					        			<select name="categoryId">
					        			   <option value="">Select</option>
										  	<?php if(!empty($category)) {                                              
                                          		foreach ($category as $c) { ?>                                          	
                                          	 		<option value="<?php echo $c->id; ?>"><?php echo ucwords($c->categoryName); ?></option>
                                          	<?php  } }?>                                             
										</select>
					        		</div>
					        		<div class="formBox">
					        			<label>Address</label>

					        			<!-- <select id="cityChoose">
										  <option value="">Washington, Connecticut</option>
										  <option value="">Washington, Kansas</option>
										  <option value="">Washington, Missouri</option>
										  <option value="">Washington, Pennsylvania</option>
										</select> -->

										<input  id="chooseCity" type="text" autocomplete="on" name="address" value="<?php if (!empty($city_name)) { echo $city_name;}?>">

					        		</div><!-- 
					        		<div class="formBox">
					        			<label>Choose Month</label>
					        			<select>
										  <option value="Month">September</option>
										  <option value="Month">September</option>
										  <option value="Month">September</option>
										  <option value="Month">September</option>
										</select>
					        		</div> -->
					        		<div class="formBox">
					        			<button type="submit" class="cs-btn">Find Now</button>
					        		</div> 
					        		
					        	</form>
					        </div>
					    </div>
					</div>
				</div>					
			</div>
		</div>
	</section>			
	<!-- Tour Section Ends -->

	<!-- <div class="extra-margin"></div> -->

	<!-- Map Section Begins -->
<!-- 	<section id="map" class="bg-offwhite pad-top-120 map-block">
		<div class="container">
			<div class="row">
				<header class="col-lg-12 col-md-12 col-sm-12 col-x-12 pad-bottom-120 wow fadeInUp animated" data-wow-delay="0.5s">						
					<h2 class="secTitle"> Find Near You </h2>
					<p class="secCaption"> It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout</p>
				</header>
			</div>
		</div>
		<div id="gmap-menu"></div>
	</section> -->
	<!-- Map Section Ends -->

	<!-- Deals Section Begins -->
	<section id="deals" class="bg-white pad-top-120 pad-bottom-120 deal-block">
		<div class="container">
			<div class="row">
				<header class="col-lg-12 col-md-12 col-sm-12 col-x-12 wow fadeInUp animated" data-wow-delay="0.5s">						
					<h2 class="secTitle"> Choose amongst quality products </h2>
					<p class="secCaption"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text </p>
				</header>
				<article class="col-lg-12 col-md-12 col-sm-12 col-xs-12 deal-slider wow fadeInUp animated" data-wow-delay="0.5s">
					<div id="owl-deal" class="pad-top-45"> 
					   <?php if(!empty($products)) {
					
					   		foreach ($products as $p) {  ?>
					   			<div class="item col-md-4 col-xs-12">
					   			    <div class="dealInfo_Img">
					   			    	<a href="<?php echo base_url().'products/viewProduct/'.$p->id;?>">
					  					<img src="<?php echo $p->productImage;?>" alt="Image">
					  					</a>
					  					<?php if($p->isRented=="1"){?>
                       						<span class="onRent"><img src="<?php echo base_url().FRONT_THEME;?>images/rented.png"></span>

				                        <?php }if($p->condition=="new"){?>
				                        <span class="onNew"><img src="<?php echo base_url().FRONT_THEME;?>images/ico_new_item.png"></span>
				                       <?php }else{?>
				                          <span class="onNew"><img src="<?php echo base_url().FRONT_THEME;?>images/used.png"></span>
				                        <?php }?>
					  				</div>
								  	<div class="dealInfo newCsPr">
								  		<div class="NewL">
								  			<h5> <?php echo $p->title; ?> </h5>
								  		</div>
								  		<div class="NewR">
								  			<p><span><?php echo  '$ '.$p->price; ?> </span> - <?php echo $p->myPerProduct;?></p>
								  		</div>
								  		<a href="<?php echo base_url().'products/viewProduct/'.$p->id;?>" class="cs-btn">view detail</a>
								  	</div>
					  			</div>	
					   	<?php } } ?>       
					</div>
				</article>
			</div>
		</div>
	</section>
	<!-- Deals Section Ends -->

	<!-- Review Section Ends -->
	<section class="testimonial pad-sec-60 upcoming-block">
	  <div class="container">					
		<h2 class="secTitle">What our customers have to say</h2>
		  	<div id="advertisement" class="advertisement pad-top-20">
			        <div class="item">
			            <div class="avatar">
			            	<img src="<?php echo base_url().FRONT_THEME;?>images/testimonials/member1.png" alt="Image">
			            </div>

					    <div class="testimonials"><em>"</em> Vtae sodales aliq uam morbi non sem lacus port mollis. Nunc condime tum metus eud molest sed consectetuer.<em>"</em>
					    </div>

				      	<div class="clients_author">John Doe <span>Abc Company</span></div>
			        </div>

			        <div class="item">
			          <div class="avatar">
			          	<img src="<?php echo base_url().FRONT_THEME;?>images/testimonials/member3.png" alt="Image">
			          </div>

					  <div class="testimonials">
					  	<em>"</em>Vtae sodales aliq uam morbi non sem lacus port mollis. Nunc condime tum metus eud molest sed consectetuer.<em>"</em>
					  </div>
				    <div class="clients_author">Stephen Doe <span>Xperia Designs</span> </div>    
			        </div>

			        <div class="item">
			            <div class="avatar">
			            	<img src="<?php echo base_url().FRONT_THEME;?>images/testimonials/member2.png" alt="Image">
			            </div>
					    <div class="testimonials">
					    	<em>"</em> Vtae sodales aliq uam morbi non sem lacus port mollis. Nunc condime tum metus eud molest sed consectetuer.<em>"</em>
					    </div>
			    		<div class="clients_author">Saraha Smith  <span>Datsun &amp; Co</span>  </div>
			        </div>
		    </div>
	    </div>
	</section>
	<!-- Review Section Ends -->

	<!-- Contact Section Begins -->
	<section id="contact" class="bg-white pad-top-120 pad-bottom-45 contact">
		<div class="container">
			<div class="row">
				<header class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad-bottom-120 wow fadeInUp animated" data-wow-delay="0.5s">
					<h2 class="secTitle"> Get in Touch </h2>
					<p class="secCaption"> 
						A travel magazine by Travel Agency, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore 
					</p>							
				</header>
				<article class="col-lg-4 col-md-4 col-sm-4 col-xs-12 wow fadeInUp animated" data-wow-delay="0.5s">
					<div class="address">
						<label>ADDRESS</label>
						<h6> 1506 S State Rd #45, Springville, IN, 47462 </h6>
						<!-- <label>Call Us</label>
						<h6> +1 126 543210 </h6> -->
						<label>E-MAIL</label>
						<h6> <a href="javascript:void(0);"> support@avarents.com </a> </h6>
					</div>
				</article>
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 wow fadeInUp animated" data-wow-delay="0.5s">
					<div class="contactForm">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-box">
								<input type="text" value="" placeholder="Name *">
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-box">
								<input type="text" value="" placeholder="E-Mail *">
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-box">
								<input type="text" value="" placeholder="Subject *">
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-box">
								<input type="text" value="" placeholder="Phone Number *">
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-box">
								<textarea placeholder="Message *"></textarea>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="define">
								* Required
							</div>
							<div class="form-box">
								<a href="javascript:void(0);" class="cs-btn"> Submit </a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<!-- Contact Section Ends -->




