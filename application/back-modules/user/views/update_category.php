<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
<div class="page animsition" style="animation-duration: 800ms; opacity: 1;">
    <div class="page-header col-sm-8">
        <h1 class="page-title">Update Category</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>dashboard">Home</a></li>
            <li><a href="<?php echo base_url();?>user/allCategory">All Category</a></li>
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
                           <!--  <div class="form-group form-material csMultiSelect">
                                <select id="brand" name="brandId[]" multiple >
                                    <?php foreach($brandName as $name): ?>
                                    <option value="<?php echo $name->id; ?>" <?php if(!empty($proBrand) && in_array($name->id,$proBrand)){ echo "selected='selected' ";}?>><?php echo $name->brandName; ?></option>
                                    <?php endforeach;?>
                                </select>
                            </div> -->
                            <div class="form-group form-material">
                                <label for="inputText" class="control-label">Category Name</label>
                                <input type="text" placeholder="Category name" name="categoryName" id="" class="form-control" value="<?php echo !empty($category->categoryName) ? $category->categoryName : ''; ?>">
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
<script type="text/javascript">
    $(document).ready(function() {
       /* $("option").each(function(){           
            if ($(this).is(':checked')) {
                alert('yes');
                $(this).addClass("hide");
            }
        });*/

        $('#brand').multiselect({
            nonSelectedText: 'Select Brand',
            includeSelectAllOption: true
           //enableFiltering:true  
        });
    });

 
</script>
