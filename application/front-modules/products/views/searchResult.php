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
				<header class="col-lg-12 col-md-12 col-sm-12 col-x-12 pad-bottom-120">						
					<h2 class="secTitle"> SEARCH RESULT </h2>
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
                    <div class="col-md-4 col-lg-3 col-sm-4 col-xs-12">
                        <div class="rm-side-panel__filters">
                            <h3>Filter by</h3>
                            <div class="rm-side-panel__listing-filters">                                
                                <div class="panel-group filtr_accrdn_lft_sdbr" id="accordion">
                                    <div class="panel panel-default">

                                        <div class="priceRang searchFilt">
                                            <p><label for="amount">Search Product</label></p>             
                                            <div class="pSlider">
                                              <input type="text" name="price" class="searchic" placeholder="Search.." id="title" oninput="ajax_fun('<?php echo base_url()."products/allProductListing/".$page; ?>');">
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse3" class="no_cls_arw" aria-expanded="false">Category Name</a>
                                                </h4>
                                            </div>
                                            <div id="collapse3" class="panel-collapse collapse" aria-expanded="true">
                                                <div class="panel-body">
                                                    <?php if(!empty($category)){ foreach ($category as $value) { ?>
                                                    <div class="control-group islamic2 rmbr_me">
                                                        <label class="control control--checkbox">   
                                                            <input class="getcat" type="checkbox" name="rem" value="<?php echo $value->id; ?>" <?php if($value->id == $this->input->post('categoryId')){?> checked="checked" <?php }?>><?php echo ucwords($value->categoryName);?><div class="control__indicator"></div>
                                                        </label>
                                                    </div>
                                                    <?php } }?>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="brandData"></div> 

                                        <div class="priceRang">
                                            <p><label for="amount">Price</label></p>             
                                            <div class="pSlider">
                                              <div id="slider-range"></div>
                                              <input type="text" name="price" value="" class="prcRange" id="amount" readonly>
                                            </div>
                                        </div>
                                        
                                        <div class="priceRang">
                                            <p><label for="amount">Distance</label></p>             
                                            <div class="pSlider">
                                              <div id="distance-range"></div>
                                              <input type="text" name="distance" class="productDist" id="distance" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" class="no_cls_arw" aria-expanded="false">Condition</a>
                                            </h4>
                                        </div>
                                        <div id="collapse2" class="panel-collapse collapse" aria-expanded="true">
                                            <div class="panel-body condiVal">
												<div class="control-group islamic2 rmbr_me">
                                					<label class="control control--checkbox">	
                                    					<input type="radio" name="condition" id="" value="all"> All Type<div class="control__indicator"></div>
                                					</label>
                                				</div>
                                                <div class="control-group islamic2 rmbr_me">
                                					<label class="control control--checkbox">	
                                    					<input type="radio" name="condition" id="" value="new">New<div class="control__indicator"></div>
                                					</label>
                                				</div>
                                                <div class="control-group islamic2 rmbr_me">
                                					<label class="control control--checkbox">	
                                    					<input type="radio" name="condition" id="" value="used"> Used<div class="control__indicator"></div>
                                					</label>
                                				</div>                                				
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading text-center">
                                            <button class="cs-btn" onclick="clearData();">Reset All</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- stsrt product list -->
                    <div class="col-md-8 col-lg-9 col-sm-8 col-xs-12">
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
    allFilter();
    function ajax_fun(url)
    { 
        var title = $("#title").val();
         var address = "<?php echo $this->input->post('address');?>";
        var categoryId = "";
        var radioValue = $("input[name='condition']:checked").val();

        
        var checkedCat = $('.getcat:checkbox:checked').map(function() {
            return this.value;
        }).get();
       
        var checkedBrand = $('.getbrand:checkbox:checked').map(function() {
            return this.value;
        }).get();
        
        var prc =$(".prcRange").val();

        var textPrc  = prc.replace("$", "");
        var tPrc  = textPrc.replace("$", "");
        var ttPrc  = tPrc.replace("+", "");
        var arrPrc = ttPrc.split('-');

        if(typeof arrPrc[0] != 'undefined' && arrPrc[0] != ''){
            var prcMin = arrPrc[0];
        }else{
            var prcMin = 0;
        }

        if(typeof arrPrc[1] != 'undefined' && arrPrc[1] != ''){
            var prcMax = arrPrc[1];
        }else{
            var prcMax = 100;
        }

        var dist =$(".productDist").val();                   
      
        var textDist  = dist.replace("miles", "");
        var tDist  = textDist.replace("miles", "");
        var arr = tDist.split('-');

        if(typeof arr[0] != 'undefined' && arr[0] != ''){
            var distMin = arr[0];
        }else{
            var distMin = 0;
        }

        if(typeof arr[1] != 'undefined' && arr[1] != ''){
            var distMax = arr[1];
        }else{
            var distMax = 20;
        }
        
        $.ajax({
            url: url,
            type: "POST",
            data:{address:address,categoryId:categoryId,radioValue:radioValue,checkedCat:checkedCat,checkedBrand:checkedBrand,prcMin:prcMin,prcMax:prcMax,distMin:distMin,distMax:distMax,title:title},
            cache: false,
            beforeSend: function() {
                $("#ajaxdata").html("<img id='zlodaer' src='https://www.walshcreative.com/wp-content/plugins/smart-scroll-posts/images/smart_scroll-ajax_loader.gif' alt='' style='display: block;margin: 0 auto;'>");
            },      
            success: function(data){
                $("#ajaxdata").html(data);
                $(window).scrollTop(0);

            }
        });      
    } 

    function getPrc(prcMin, prcMax){
        allFilter();     
    }

    function getDist(distMin, distMax){
        allFilter(); 
    }

    function allFilter(){

        var title = $("#title").val();
        var address = "<?php echo $this->input->post('address');?>";
        var categoryId = "<?php echo $this->input->post('categoryId');?>";
        
        var radioValue = $("input[name='condition']:checked").val();
	
        var checkedCat = $('.getcat:checkbox:checked').map(function() {
            return this.value;
        }).get();
       
        var checkedBrand = $('.getbrand:checkbox:checked').map(function() {
            return this.value;
        }).get();
		
        var prc =$(".prcRange").val();

        var textPrc  = prc.replace("$", "");
        var tPrc  = textPrc.replace("$", "");
        var ttPrc  = tPrc.replace("+", "");
        var arrPrc = ttPrc.split('-');

        if(typeof arrPrc[0] != 'undefined' && arrPrc[0] != ''){
            var prcMin = arrPrc[0];
        }else{
            var prcMin = 0;
        }

        if(typeof arrPrc[1] != 'undefined' && arrPrc[1] != ''){
            var prcMax = arrPrc[1];
        }else{
            var prcMax = 100;
        }

        var dist =$(".productDist").val();                   
      
        var textDist  = dist.replace("miles", "");
        var tDist  = textDist.replace("miles", "");
        var arr = tDist.split('-');

        if(typeof arr[0] != 'undefined' && arr[0] != ''){
            var distMin = arr[0];
        }else{
            var distMin = 0;
        }

        if(typeof arr[1] != 'undefined' && arr[1] != ''){
            var distMax = arr[1];
        }else{
            var distMax = 20;
        }

        $.ajax({
            url: '<?php echo base_url()."products/allProductListing/".$page; ?>',
            type: "POST",             
            cache: false,
            data:{address:address,categoryId:categoryId,radioValue:radioValue,checkedCat:checkedCat,checkedBrand:checkedBrand,prcMin:prcMin,prcMax:prcMax,distMin:distMin,distMax:distMax,title:title},
            beforeSend: function() {
                $("#ajaxdata").html("<img id='zlodaer' src='https://www.walshcreative.com/wp-content/plugins/smart-scroll-posts/images/smart_scroll-ajax_loader.gif' alt='' style='display: block;margin: 0 auto;'>");
            }, 
            success: function(res){
                $("#ajaxdata").html(res);
                $(window).scrollTop(0);

            }
        });           
    }
    
    function clearData(){
        $('input[name="condition"]').attr('checked', false);
        $('.getcat').prop('checked', false);
        $('.collapse').removeClass('in');
        $('.getbrand').prop('checked', false);
        $(".productDist").val('');  
        $(".prcRange").val('');
        window.location.reload();
        ajax_fun('<?php echo base_url()."products/allProductListing";?>');
    }

    $(document).ready(function(){

        $(".getcat,.getbrand,.condiVal").change(function (){ 

            var address = "<?php echo $this->input->post('address');?>";
            var categoryId = "";
            var title = $("#title").val();

            var radioValue = $("input[name='condition']:checked").val();

            var checkedCat = $('.getcat:checkbox:checked').map(function(){
                return this.value;
            }).get();

            var checkedBrand = $('.getbrand:checkbox:checked').map(function(){
                return this.value;
            }).get();
            
            var dist =$(".productDist").val();                   
      
			var textDist  = dist.replace("miles", "");
			var tDist  = textDist.replace("miles", "");
			var arr = tDist.split('-');

			if(typeof arr[0] != 'undefined' && arr[0] != ''){
				var distMin = arr[0];
			}else{
				var distMin = 0;
			}

			if(typeof arr[1] != 'undefined' && arr[1] != ''){
				var distMax = arr[1];
			}else{
				var distMax = 20;
			}

            $.ajax({
                url: '<?php echo base_url()."products/allProductListing/".$page; ?>',
                type: "POST",             
                cache: false,
                data:{address:address,categoryId:categoryId,radioValue:radioValue,checkedCat:checkedCat,checkedBrand:checkedBrand,distMin:distMin,distMax:distMax,title:title},
                beforeSend: function() {
					$("#ajaxdata").html("<img id='zlodaer' src='https://www.walshcreative.com/wp-content/plugins/smart-scroll-posts/images/smart_scroll-ajax_loader.gif' alt='' style='display: block;margin: 0 auto;'>");
				}, 
                success: function(res){
                    $("#ajaxdata").html(res);
                    $(window).scrollTop(0);

                }
            });
        });        

        $(".getcat").click(function () { 
            var checkedVals = $('.getcat:checkbox:checked').map(function() {
                return this.value;
            }).get();            

            $.ajax({
                url: '<?php echo base_url();?>products/getCategoryBrands',
                type: "POST",             
                cache: false,
                data:{checkedVals:checkedVals},
                success: function(ress){
                    $("#brandData").html(ress);
                    $(window).scrollTop(0);

                }
            });              
        });       
    }); 
</script>
