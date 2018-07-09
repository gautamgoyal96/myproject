  <!-- Page -->
<?php $page = $this->uri->segment(3);?>
<div class="page animsition">
    <div class="page-header">
        <h1 class="page-title">Category List</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>dashboard">Home</a></li>
            <!--   <li><a href="<?php echo base_url();?>user/addUser">Add Employee</a></li> -->        
        </ol>
        <div class="page-header-actions">
            <a href="<?php echo base_url();?>user/addCategory"><button data-original-title="Add&nbsp;Category" data-toggle="tooltip" class="btn btn-sm btn-icon btn-primary btn-round waves-effect waves-light waves-round" type="button">
              <i aria-hidden="true" class="icon md-plus"></i>
            </button></a>
        </div>
        <div class="modal fade" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header ">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Are you sure!!</h4>
                    </div>
                    <div class="modal-body">
                        You want to delete this category.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <a href="" id="deleteUrl" class="btn btn-danger btn-ok">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <?php if($this->session->flashdata('success') != null) : ?>  <!-- for Delete -->
                    <div class="">
                        <div class="alert alert-success success" id="success-alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-check"></i> Alert!</h4>
                            <?php  echo $this->session->flashdata('success');?>
                        </div>
                    </div><!-- /.box-body -->
                <?php endif; ?>
                <?php if($this->session->flashdata('error') != null) : ?>  <!-- for Delete -->
                    <div class="">
                        <div class="alert alert-danger success" id="error-alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-check"></i> Alert!</h4>
                            <?php  echo $this->session->flashdata('error');?>
                        </div>
                    </div><!-- /.box-body -->
                <?php endif; ?>
                <!-- Panel Floating Labels -->
                <div class="panel">
                    <div class="panel-heading">   
                        <h3 class="panel-title"></h3>
                    </div>
                    <div class="panel-body container-fluid">
                        <div class="form-inline padding-bottom-15">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group"></div>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <div class="form-group">
                                        <input id="search" type="text" placeholder="Search" class="form-control"
                                        autocomplete="on" onkeyup="javascript: ajax_fun('<?php echo base_url(); ?>user/allCategoryListing')">
                                    </div>
                                </div>
                            </div>
                        </div>
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

    ajax_fun('<?php echo base_url()."index.php/user/allCategoryListing/".$page; ?>');
    function ajax_fun(url)
    {  
        var key= $('#search').val(); 
        $.ajax({
            url: url,
            type: "POST",
            data:{page: url ,'search':key},              
            cache: false,                      
            success: function(data){
                $("#ajaxdata").html(data);
            }
        });      
    }    

    $(document).ready(function(){        
        $(".delete" ).click(function() {
            $('#deleteConfirm').modal('show');
            $("#deleteUrl").attr('href',$(this).data('href'));
        });

        window.setTimeout(function() {
            $(".success").fadeTo(1500, 0).slideUp(500, function(){
                $(this).remove(); 
            });
        }, 5000);
    });
</script>
