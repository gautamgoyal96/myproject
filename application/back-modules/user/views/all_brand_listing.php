<style type="text/css">
  .cs-no-mr li {
  margin: 0 !important;
}
</style>
<?php //echo'<pre>'; print_r($users);echo'</pre>';?>
<table id="exampleFooAddRemove" class="table table-bordered table-hover toggle-circle"
    data-page-size="7">
    <thead>
        <tr>
            <th data-sort-initial="true" data-toggle="true">S.No</th>
            <th data-hide="phone, tablet">Brand Name</th>
            <th data-hide="phone, tablet">Status</th>
            <th data-sort-ignore="true" class="min-width">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $pag=$sn-1; $sn = $sn;
        if(!empty($brand)){
            foreach($brand as $get){?>
        <tr>
            <td><?php echo $sn;?></td>
            <td><?php echo !empty($get->brandName) ? (ucwords($get->brandName)) : 'NA';?></td>
            
            <td><?php echo $get->status ==1 ? '<span class="label label-success">Active</span>':'<span class="label label-danger">Inactive</span>'; ?></td>
            <td class="action">
                <?php if($get->status == 1) : ?>
                    <a href="<?php echo base_url()."user/activeBrand/" . $get->id.'/'.$pag; ?>"  class="btn btn-sm btn-icon btn-warning btn-outline btn-round" title="Inactive"><i class="icon md-close" aria-hidden="true"></i> </a>
                    <?php  else : ?>
                    <a href="<?php echo base_url()."user/activeBrand/" . $get->id.'/'.$pag; ?>" class="btn btn-sm btn-icon btn-success btn-outline btn-round"  title="Active"><i class="icon md-check"></i> </a>
                <?php endif; ?>
                <?php if($get->brandName != 'Other'){?>
                    <a data-href="<?php echo base_url().'user/deleteBrand/'.$get->id.'/'.$pag;?>" class="btn btn-sm btn-icon btn-danger btn-outline btn-round delete" data-toggle="tooltip" title="Delete"><i class="icon md-tag-close" aria-hidden="true"></i></a>
                    <a href="<?php echo base_url()."user/updateBrand/" . $get->id; ?>"  class="btn btn-sm btn-icon btn-info btn-outline btn-round" title="Update"><i class="icon md-edit" aria-hidden="true"></i> </a>
                <?php } ?>
            </td>            
        </tr>
        <?php $sn++; } } if(empty($brand)):?>
        <tr class="even pointer">
            <td class=" " colspan="9">No Record Found</td>
        </tr>
        <?php endif; ?>   
    </tbody>    
</table>
<div class="">
    <?php echo $links; ?> 
 </div>

  <script>
    $(".delete" ).click(function() {
        $('#deleteConfirm').modal('show');
        $("#deleteUrl").attr('href',$(this).data('href'));
    });
   </script>
