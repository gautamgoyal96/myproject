<ul class="blocks blocks-100 blocks-xlg-4 blocks-md-3 blocks-sm-2" data-plugin="masonry">
    <?php $pag=$sn-1; $sn = $sn;
        if(!empty($product)){
        foreach($product as $get){?>
    <li class="masonry-item">
        <div class="widget widget-article widget-shadow">
            <div class="widget-header cover">
<!--
                <?php if(!empty($get->productImage)){ ?>
                    <img class="cover-image" src="<?php echo base_url().'../uploads/productImage/'.$get->productImage;?>"
                alt="...">
                <?php } else{ ?>
                    <img class="cover-image" src="<?php echo base_url().ADMIN_THEME;?>assets/images/pro.png"
                alt="...">
                <?php } ?>
-->
				<div class="product_img">
				<div class="product_img_in">
					<img class="cover-image" src="<?php echo $get->productImage;?>">
				</div>
				</div>
            </div>
            <div  class="widget-body">
                <h3 class="widget-title"><?php echo !empty($get->title) ?  substr( ucwords($get->title), 0, 20 )  : 'NA';?></h3>
                <p class="widget-metas type-link">
                    Condition
                    <a href="javascript:void(0)"><?php echo !empty($get->condition) ? ucwords($get->condition) : 'NA';?></a>
                    <a href="javascript:void(0)"><?php echo !empty($get->price) ? '$ '.$get->price : 'NA';?></a>
                    <!--  <a href="javascript:void(0)">
                    <span>3</span> Comments</a> -->
                </p>
                <!-- <p>Dolemus late utriusque fore eveniet provincia spernat dissentiet.
                Fit intemperantes.</p> -->
                <div class="widget-body-footer">
                    <div class="widget-actions pull-right">
                        <?php if($get->pStatus == 0) : ?>
                        <a href="<?php echo base_url()."user/activeProduct/" . $get->pId.'/'.$userId; ?>"  class="btn btn-icon btn-warning btn-outline " title="Inactive"><i class="icon md-close" aria-hidden="true"></i> </a>
                        <?php  else : ?>
                        <a href="<?php echo base_url()."user/activeProduct/" . $get->pId.'/'.$userId; ?>" class="btn btn-icon btn-success btn-outline "  title="Active"><i class="icon md-check"></i> </a>
                        <?php endif; ?>
                        <a data-href="<?php echo base_url().'user/deleteProduct/'.$get->pId.'/'.$userId;?>" class="btn btn-icon btn-danger btn-outline delete"
                        data-toggle="tooltip" title="Delete"><i class="icon md-tag-close" aria-hidden="true"></i></a>
                    </div>
                    <a href="<?php echo base_url().'user/productDetail/'.$get->pId.'/'.$userId;?>" class="btn btn-info">Read more</a>
                </div>
            </div>
        </div>
    </li>
    <?php $sn++; } } if(empty($product)):?>
    <tr class="even pointer">
    <td class=" " colspan="9">No Record Found</td>
    </tr>
    <?php endif; ?>   
</ul>
<div class="">
    <?php echo $links; ?> 
</div>
<script>
    $(".delete" ).click(function() {
        $('#deleteConfirm').modal('show');
        $("#deleteUrl").attr('href',$(this).data('href'));
    });
</script>
