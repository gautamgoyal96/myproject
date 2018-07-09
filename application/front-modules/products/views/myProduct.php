<style>
.main {
    display: block;
    height: initial !important;
    max-height: initial;
}
</style>
<?php $page = $this->uri->segment(3); ?>
<div class="adjust_cntainer">
    <div class="extra-margin"></div>			
	<!-- Map Section Begins -->
	<section id="map" class="bg-offwhite pad-top-120 map-block">
		<div class="container">
			<div class="row">
				<header class="col-lg-12 col-md-12 col-sm-12 col-x-12 pad-bottom-120 wow fadeInUp animated" data-wow-delay="0.5s">
                <!-- <div class="addBtn">
                    <a href="<?php echo base_url();?>products/addProduct" class="cs-btn">Add Product</a>
                </div>	 -->						
					<h2 class="secTitle"> MY Products </h2>
					<p class="secCaption"> It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout</p>
				</header>
			</div>
		</div>
		<div id="gmap-menu"></div>
	</section>				
	<section class="srch_res_sec">
    <div class="container">
        <div class="rm-category__spacing-blk">
            <div class="">
                <div class="row">
                    <!-- stsrt product list -->
                    <div class="col-md-8 col-lg-10 col-sm-8 col-xs-12 col-lg-offset-1 wow fadeInRight animated" data-wow-delay="0.5s">
                        <div id="ajaxdata"></div>
                    </div>
                </div>
                <!-- end product list -->
            </div>
        </div>
        </div>
    </div>
</section>
</div>
<script>
    ajax_fun('<?php echo base_url()."products/allMyProductListing/".$page; ?>');
    function ajax_fun(url)
    { 
        $.ajax({
            url: url,
            type: "POST",  
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
