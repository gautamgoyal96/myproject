<?php $page = 0;
    $userId = $this->uri->segment(3);
?>
<div class="page animsition">
    <div class="page-header">
        <h1 class="page-title">Product List</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>dashboard">Home</a></li>
        </ol> 
        <div class="modal fade" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header ">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Are you sure!!</h4>
                    </div>
                    <div class="modal-body">
                        You want to delete this product?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <a href="" id="deleteUrl" class="btn btn-danger btn-ok">Delete</a>
                    </div>
                </div>
            </div>
        </div>     
        <!-- <ul class="nav nav-tabs nav-tabs-line" role="tablist" data-plugin="nav-tabs">
            <li class="active" role="presentation">
                <a href="#exampleList" aria-controls="exampleList" aria-expanded="true" role="tab" data-toggle="tab" data-filter="*">All</a>
            </li>
            <li role="presentation">
                <a href="#exampleList" aria-expanded="false" role="tab" data-toggle="tab" data-filter="object">Object</a>
            </li>
            <li role="presentation">
                <a href="#exampleList" aria-expanded="false" role="tab" data-toggle="tab" data-filter="city">City</a>
            </li>
            <li role="presentation">
                <a href="#exampleList" aria-expanded="false" role="tab" data-toggle="tab" data-filter="animal">Animal</a>
            </li>
        </ul> -->
    </div>
    <div class="page-content">
        <?php if(!empty($error)){?>
            <div class="alert dark alert-icon alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?php echo $error; ?>
            </div>
            <?php } ?> 
        <?php if($this->session->flashdata('success') != null) : ?>
            <div class="">
                <div class="alert alert-success success" id="success-alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Alert!</h4>
                    <?php  echo $this->session->flashdata('success');?>
                </div>
            </div>
        <?php endif; ?>
        <?php if($this->session->flashdata('error') != null) : ?>
            <div class="">
                <div class="alert alert-danger success" id="error-alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Alert!</h4>
                    <?php  echo $this->session->flashdata('error');?>
                </div>
            </div>
        <?php endif; ?>
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body container-fluid">
                <div class="form-inline padding-bottom-15">
                <?php if(!empty($userId)){?>
                                <div class="media-right btn-right">
                        <a href="<?php echo base_url();?>user/allOwners" class="btn btn-primary waves-effect waves-light"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                      </div><br><br>
                      <?php }
                  if(empty($userId)){?>
                    <div class="row">
                        <div class="fltr_prod garyBg">
                           <!--  <div class="col-sm-3">
                               <select class="selector1 custom-select form-control" id='standard' name='standard'>
                                   <option value="">Select Brand</option>
                                    <?php foreach($brand as $val){?>
                                        <option value="<?php echo $val->id; ?>"><?php echo empty($val->brandName) ? 'NA' : ucwords($val->brandName); ?></option>
                                    <?php } ?>
                                </select>
                            </div> -->
                            <div class="col-sm-3">
                               <select class="selector2 custom-select form-control" id='standard' name='standard'>
                                       <option value="">Select Category</option>
                                        <?php foreach($category as $val){?>
                                            <option value="<?php echo $val->id; ?>"><?php echo empty($val->categoryName) ? 'NA' : ucwords($val->categoryName); ?></option>
                                        <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select class="selector3 form-control">
                                    <option value="">Select Status</option>
                                    <option value="Booked">Booked</option>
                                    <option value="Free">Free</option>
                                </select>
                            </div>
                             <div class="col-sm-3">
                                <select class="selector4 form-control">
                                    <option value="">Select Price</option>
                                    <option value="0-100">0 - 100</option>
                                    <option value="100-500">100 - 500</option>
                                    <option value="500-1000">500 - 1000 </option>
                                    <option value="1000-2000">1000 - 2000</option>
                                    <option value="2000-more">2000 - more</option>
                                </select>
                            </div>
                            <div class="col-sm-3 csSearch">
                                <div class="form-group">
                                    <input id="search" type="text" placeholder="Search" class="form-control" autocomplete="on" onkeyup="javascript: ajax_fun('<?php echo base_url(); ?>user/allProductListing')">
                                </div>
                            </div>

                        </div>
                    </div>&nbsp;
                    <?php }?>
                    <div class="row">
                        <div class="fltr_prod">
                           
                            <div class="dt_mnt_clndr">
                             <?php if(empty($userId)){?>
                                <div class="col-sm-5">

                                    <div class="example-wrap">
                                            <div class="form-group"> 
                                              <input class="form-control selector5" name="start" type="text" placeholder="Select from date" id="startdate">
                                            </div>
                                            <div class="form-group">
                                                <span class="input-group-addon">to</span>
                                            </div>
                                            <div class="form-group">      
                                                <input class="form-control selector6" name="end" type="text" placeholder="Select to date" id="enddate">
                                            </div>
                                    </div>
                                </div>
                         <?php }?>      
                            </div>
                        </div>
                    </div>
                    <div id="ajaxdata"> </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    
</style>
<script type="text/javascript">
    //ajax_fun('<?php echo base_url()."user/allProductListing/".$page; ?>');
    function ajax_fun(url)
    {  
        var key= $('#search').val(); 
        var bId =$(".selector1").val();
        var cId =$(".selector2").val();
        var isRented =$(".selector3").val();
        var price =$(".selector4").val();
        var start =$(".selector5").val();
        var end =$(".selector6").val();
          var userId = "<?php echo $userId;?>";

        $.ajax({
            url: url,
            type: "POST",
            data:{page: url ,'search':key,bId:bId,cId:cId,isRented:isRented,price:price,start:start,end:end,userId:userId},              
            cache: false, 
            beforeSend: function() {
                $("#ajaxdata").html("<img id='zlodaer' src='https://www.walshcreative.com/wp-content/plugins/smart-scroll-posts/images/smart_scroll-ajax_loader.gif' alt='' style='display: block;margin: 0 auto;'>");
                $(".selector1").attr('disabled', true);
                $(".selector2").attr('disabled', true);
                $(".selector3").attr('disabled', true);
                $(".selector4").attr('disabled', true);
                $(".selector5").attr('disabled', true);
                $(".selector6").attr('disabled', true);
            },                     
            success: function(data){

                $(".selector1").attr('disabled', false);
                $(".selector2").attr('disabled', false);
                $(".selector3").attr('disabled', false);
                $(".selector4").attr('disabled', false);
                $(".selector5").attr('disabled', false);
                $(".selector6").attr('disabled', false);
                $(window).scrollTop(0);
                $("#ajaxdata").html(data);
            }
        });      
    }    

    $(document).ready(function(){        

        window.setTimeout(function() {
            $(".success").fadeTo(1500, 0).slideUp(500, function(){
                $(this).remove(); 
            });
        }, 5000);

        $("#startdate").datepicker({
            format: 'd-m-yyyy',
            todayBtn: "linked",
            autoclose: true,
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#enddate').datepicker('setStartDate', minDate);
        });
        
        $("#enddate").datepicker({
            format: 'd-m-yyyy',
            todayBtn: "linked",
            autoclose: true,
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#startdate').datepicker('setEndDate', minDate);
        });

        ajax_fun('<?php echo base_url()."user/allProductListing/".$page; ?>');
        $(".selector1").change(function () {
           ajax_fun('<?php echo base_url(); ?>user/allProductListing/');
        });       
        $(".selector2").change(function () {
           ajax_fun('<?php echo base_url(); ?>user/allProductListing/');
        });
        $(".selector3").change(function () {
           ajax_fun('<?php echo base_url(); ?>user/allProductListing/');
        });
        $(".selector4").change(function () {
           ajax_fun('<?php echo base_url(); ?>user/allProductListing/');
        });
        $(".selector5").change(function () {
           ajax_fun('<?php echo base_url(); ?>user/allProductListing/');
        });
        $(".selector6").change(function () {
           ajax_fun('<?php echo base_url(); ?>user/allProductListing/');
        });
    });
</script>