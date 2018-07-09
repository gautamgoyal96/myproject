<div class="page animsition" style="animation-duration: 800ms; opacity: 1;">
    <div class="page-header col-sm-8">
        <h1 class="page-title">Update Brand</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>dashboard">Home</a></li>
            <li><a href="<?php echo base_url();?>user/allCategory">All Brand</a></li>
        </ol>
    </div>
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <?php if(!empty($error)){?>
                    <div class="alert dark alert-icon alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?php echo $error; ?>
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
                <?php } ?>  
            <!-- Panel Static Labels -->
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title"></h3>
                    </div>
                    <div class="panel-body container-fluid">
                        <form autocomplete="off" method="post" enctype="multipart/form-data">
                            <div class="form-group form-material" id="engInput">
                                <label for="inputText" class="control-label">Brand Name</label>
                                <input type="text" placeholder="Brand name" name="brandName" id="" class="form-control" value="<?php echo $brand->brandName; ?>">
                            </div>                           
                            <div class="form-group form-material">
                                <div class="">
                                    <button type="submit" name="submit" class="btn btn-primary waves-effect waves-light">Update</button>
                                    <button class="btn btn-warning waves-effect waves-light" type="reset">Reset</button>
                                </div>
                            </div>                
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Panel Static Labels -->
        </div>
    </div>
</div>
