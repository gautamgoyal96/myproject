<style type="text/css">
  input[type="number"] { -moz-appearance: textfield !important; }
input[type=number]::-webkit-inner-spin-button,input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none;-moz-appearance: none;appearance: none;margin: 0;}
</style>
<div class="page animsition" style="animation-duration: 800ms; opacity: 1;">
    <div class="page-header">
      <h1 class="page-title">Update Admin Fee</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard">Home</a></li>
      </ol>
    </div>
    <div class="page-content container-fluid">
      <div class="row">
        <div class="col-sm-6 col-sm-offset-3">  
        <?php if(!empty($error_msg)){?>
            <div class="alert dark alert-icon alert-danger alert-dismissible">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button><?php echo $error_msg; ?> 
            </div>
        <?php } ?>  
          <!-- Panel Floating Lables -->
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">Update</h3>
            </div>
            <div class="panel-body container-fluid">
              <form method="post" autocomplete="off">
                <div class="form-group form-material floating">
                  <input type="number" value="<?php echo $get->percentage ; ?>" name="percentage" class="form-control">
                  <label class="floating-label">Admin Fee</label>
                </div>
          
                <div class="form-group form-material floating ">
                <button name="Add" class="btn btn-primary btn-outline  waves-effect waves-light" type="submit">Update</button>
                  <a class="btn btn-primary btn-outline waves-effect waves-light" href="<?php echo base_url();?>dashboard">Go Back</a>
                </div>
              </form>
            </div>
          </div>
          <!-- End Panel Floating Lables -->
        </div>
      </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        window.setTimeout(function() {
            $(".alert-danger").fadeTo(1500, 0).slideUp(500, function(){
                $(this).remove(); 
            });
        }, 5000);
    });
</script>    
