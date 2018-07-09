<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
      Update Profile
        <small></small>
    </h1>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-8">
            <?php if(!empty($error_msg)){?>
                <div class="alert alert-danger">
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button><?php echo $error_msg; ?> 
                </div>
            <?php } ?>
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Update Profile</h3>
                </div><!-- /.box-header -->    
                <!-- form start -->
                <form role="form" action="" method="post">
                    <div class="box-body">
						<?php  foreach($get as $get):
						?>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="text" name="email" autofocus="autofocus" class="form-control" id="exampleInputEmail1"  value="<?php echo $get->email ; ?>">
                        </div>
                        <?php endforeach; ?>
                        <div class="form-group">
                            <label for="exampleInputEmail1">New Password</label>
                            <input type="password" name="password" autofocus="autofocus" class="form-control" id="exampleInputEmail1" placeholder="Password">
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleInputEmail1">Confirm Password</label>
                            <input type="password" name="c_password" autofocus="autofocus" class="form-control" id="exampleInputEmail1" placeholder="Confirm Password">
                        </div>
                       
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        &nbsp;
                        <a href="<?php echo base_url().'index.php/dashboard/'?>"><button type="button" class="btn btn-info">Go Back</button></a>
                    </div>
                </form>
            </div><!-- /.box -->
        </div><!--/.col (left) -->
    </div>   <!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
