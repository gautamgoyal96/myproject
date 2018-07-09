        <script src="<?php echo base_url().FRONT_THEME;?>js/element.js" type = "text/javascript" defer="defer"></script>
                                              
<?php if(!empty($brands)){ ?>
  <div class="panel-heading" id="brandData">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" class="no_cls_arw">Brand Name</a>
                                            </h4>
                                            <div id="collapse1" class="panel-collapse collapse" aria-expanded="true">
                                                <div class="panel-body">
<?php foreach ($brands as $value) { ?>
<div class="control-group islamic2 rmbr_me">
    <label class="control control--checkbox">   
        <input type="checkbox" class="getbrand" name="brand" value="<?php echo $value['brandId'];?>"<?php if(!empty($prvBrand) && in_array($value['id'],$prvBrand)){ echo 'checked ="checked"';}?>><?php echo ucwords($value['brandName']);?><div class="control__indicator"></div>
    </label>
</div>
<?php } ?>
</div>
                                            </div>
                                        </div>

<?php }else{

    $this->session->unset_userdata('brandsId');
    
    } ?>

<script type="text/javascript">
$(document).ready(function(){ 
	$(".getbrand").click(function (){            
        var checkedBrand = $('.getbrand:checkbox:checked').map(function() {
            return this.value;
        }).get();
        
        var checkedCat = $('.getcat:checkbox:checked').map(function() {
            return this.value;
        }).get();
        
        var radioValue = $("input[name='condition']:checked").val();
        
        $.ajax({
            url: '<?php echo base_url()."products/allProductListing/"; ?>',
            type: "POST",             
            cache: false,
            data:{checkedBrand:checkedBrand,checkedCat:checkedCat,radioValue:radioValue},
            beforeSend: function() {
                $("#ajaxdata").html("<img id='zlodaer' src='https://www.walshcreative.com/wp-content/plugins/smart-scroll-posts/images/smart_scroll-ajax_loader.gif' alt='' style='display: block;margin: 0 auto;'>");
            }, 
            success: function(res){
                $("#ajaxdata").html(res);
            }
        });           
    });
});
</script>

  
