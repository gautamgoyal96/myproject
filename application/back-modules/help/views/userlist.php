 <!-- Page -->
<?php $page = $this->uri->segment(3);?>
<div class="page animsition">
    <div class="page-header">
        <h1 class="page-title">Help and suport</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>dashboard">Home</a></li>
            <!--   <li><a href="<?php echo base_url();?>user/addUser">Add Employee</a></li> -->        
        </ol>
      
    </div>
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-sm-12">
              
                <!-- Panel Floating Labels -->
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title"></h3>
                    </div>
                    <div class="panel-body container-fluid">
                       
                        <div id="ajaxdata" class="table-responsive"> </div>
                    </div>
                </div>
                <!-- End Panel Floating Labels -->
            </div>
        </div>
    </div>
</div>
<!-- End Page --> 
<script type="text/javascript">
	
	
   ajax_fun('<?php echo base_url()."help/getUserList" ?>');
    function ajax_fun(url){
   
      $.ajax({
           url: url,
           type: "POST",
           data:{page: url},            
           cache: false,
           beforeSend: function() {
                    $("#ajaxdata").html('<center><i class="fa fa-spinner fa-spin" style="font-size:14;color:#C0262C"></i> </center>');
                  },                      
           success: function(data){
               $("#ajaxdata").html(data);
           }
       });
   }
</script>