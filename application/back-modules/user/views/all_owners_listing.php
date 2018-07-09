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
            <th data-hide="phone, tablet">Profile Image</th>
            <th data-hide="phone, tablet">FullName</th>
            <th data-hide="phone, tablet">Contact Number</th>
            <th data-hide="phone, tablet">Email</th>
            <th data-hide="phone, tablet">Address</th>
            <th data-hide="phone, tablet">Status</th>
            <th data-sort-ignore="true" class="min-width">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $pag=$sn-1; $sn = $sn;
        if(!empty($owner)){
            foreach($owner as $get){?>
        <tr>
            <td>
                <?php echo $sn;  ?>
            </td>
			<?php  if(!filter_var($get->profileImage, FILTER_VALIDATE_URL) === false) { ?>
                <td>
                    <img style="height:50px;width:50px;" alt="..." src="<?php echo $get->profileImage;?>"/>
                </td>
            <?php   }else if(!empty($get->profileImage)){ ?>
                <td>
					<img style="height:50px;width:50px;" alt="..." src="<?php echo base_url().'../uploads/profile/'.$get->profileImage;?>"/>
                    
                </td>
            <?php } else{  ?>
                <td>                                                       
                    <img style="height:50px;width:50px;" alt="..." src= "<?php echo base_url().ADMIN_THEME;?>assets/images/images.png">
                </td>
            <?php } 
                $mName = (ucwords($get->firstName).' '.ucwords($get->lastName));
            ?>
            <td><?php echo !empty($get->firstName) && !empty($get->lastName) ? wordwrap($mName, 15, "<br />\n") : 'NA';?></td>
            <td><?php echo !empty($get->countryCode) && !empty($get->contactNo) ? (($get->countryCode).'-'.($get->contactNo)) : 'NA';?></td>
            <td><?php if(!empty($get->email)){ echo (wordwrap($get->email, 30, "<br />\n"));}else{ echo 'NA';}?> </td>
            <td><?php echo !empty($get->address) ? wordwrap($get->address, 40, "<br />\n") : "NA"; ?></td>
            <td><?php echo $get->status ==1 ? '<span class="label label-success">Active</span>':'<span class="label label-danger">Inactive</span>'; ?></td>
            <td class="action">
                <?php if($get->status == 1) : ?>
                <a href="<?php echo base_url()."user/activeOwners/" . $get->id.'/'.$pag; ?>"  class="btn btn-sm btn-icon btn-warning btn-outline btn-round" title="Inactive"><i class="icon md-close" aria-hidden="true"></i> </a>
                <?php  else : ?>
                <a href="<?php echo base_url()."user/activeOwners/" . $get->id.'/'.$pag; ?>" class="btn btn-sm btn-icon btn-success btn-outline btn-round"  title="Active"><i class="icon md-check"></i> </a>
                <?php endif; ?>
                  <a href="<?php echo base_url()."user/allProduct/" . $get->id; ?>" class="btn btn-sm btn-icon btn-success btn-outline btn-round"  title="View Product"><i class="icon md-eye"></i> </a>
             <!--    <a data-href="<?php echo base_url().'user/deleteOwners/'.$get->id.'/'.$pag;?>" class="btn btn-sm btn-icon btn-danger btn-outline btn-round delete"
                  data-toggle="tooltip" title="Delete"><i class="icon md-tag-close" aria-hidden="true"></i></a> -->
            </td>
        </tr>
        <?php $sn++; } } if(empty($owner)):?>
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
