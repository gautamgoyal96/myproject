<?php $page = $this->uri->segment(3); ?>

<div class="adjust_cntainer">
<div class="extra-margin"></div>
			
			<!-- Map Section Begins -->
			<!-- <section id="map" class="bg-offwhite pad-top-120 map-block">
				
				<div id="gmap-menu"></div>
			</section>	 -->	

<!-- category page starts -->
			<section class="srch_res_sec pro_categ_wrapr">
				<div class="container">
					<div class="rm-category__spacing-blk">
						<div class="container">
							<div class="row">

								<div class="col-md-4 col-lg-2 col-sm-4 col-xs-12 wow fadeInLeft animated" data-wow-delay="0.5s">

									<div class="nav nav-tabs filter_options">
										<p class="active"><a href="javascript:void(0)"  onclick=" ajax_fun('<?php echo base_url()."products/allProductListing/".$page; ?>');"><span class="fa fa-chevron-right"></span> All</a></p>
										<?php if(!empty($category)){ foreach ($category as $value) { ?>

											<p><a href="javascript:void(0)"  onclick=" ajax_fun('<?php echo base_url()."products/allProductListing/".$page; ?>','<?php echo $value->id; ?>');" data-id="<?php echo $value->id; ?>"><span class="fa fa-chevron-right"></span> <?php echo ucwords($value->categoryName);?></a></p>

										<?php } }?>
									</div>
<!-- 									<p class="c_ol_cate"><a href="#">See All Categories</a></p>
 -->			
								</div>

								<div class="col-md-8 col-lg-10 col-sm-8 col-xs-12 wow fadeInRight animated" data-wow-delay="0.5s">
									<div class="rm-category__animate">
										<div class="row">
											<div class="tab-content">
											<div class="tab-pane active" id="ajaxdata">	
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
			<!-- category page ends -->
			
</div>

<script type="text/javascript">
	
	    ajax_fun('<?php echo base_url()."products/allProductListing/".$page; ?>');
    function ajax_fun(url,categoryId)
    { 
        $.ajax({
            url: url,
            type: "POST",
            data:{categoryId:categoryId},          
            cache: false,
            beforeSend: function() {
                $("#ajaxdata").html("<img id='zlodaer' src='https://www.walshcreative.com/wp-content/plugins/smart-scroll-posts/images/smart_scroll-ajax_loader.gif' alt='' style='display: block;margin: 0 auto;'>");
            },      
            success: function(data){
                $("#ajaxdata").html(data);
            }
        }); 
           
    } 
</script>