<div class="page animsition" style="animation-duration: 800ms; opacity: 1;">
    <div class="page-header">
      <h1 class="page-title">Update Profile</h1>
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
                  <input type="text" value="<?php echo $get->email ; ?>" name="email" class="form-control">
                  <label class="floating-label">Email</label>
                </div>
               <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url();?>dashboard/changePassword/<?php echo $this->session->userdata('id');?>">Change Password</a>
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
