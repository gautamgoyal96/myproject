<style type="text/css">
.price-ryt{
    float: right;    
}

.widget-header.overlay-hover.overlay {
    max-height: 266px;
    overflow: hidden;
}
</style>
<ul class="blocks blocks-100 blocks-xlg-4 blocks-md-3 blocks-sm-2" id="exampleList" data-filterable="true">
     <?php $pag=$sn-1; $sn = $sn;
        if(!empty($product)){
            foreach($product as $get){?>
    <li data-type="animal">
        <div class="widget widget-shadow">
            <h4 style="background-color:#8e804a;color:#ffffff;" class="widget-title">Condition (<?php echo !empty($get->condition) ? ucwords($get->condition) : 'NA';?>)
                <?php if($get->pStatus == 0) : ?>
                    <a href="<?php echo base_url()."user/activeProduct/" . $get->pId.'/'.$pag; ?>"  class="btn btn-icon btn-warning btn-outline " title="Inactive"><i class="icon md-close" aria-hidden="true"></i> </a>
                <?php  else : ?>
                    <a href="<?php echo base_url()."user/activeProduct/" . $get->pId.'/'.$pag; ?>" class="btn btn-icon btn-success btn-outline "  title="Active"><i class="icon md-check"></i> </a>
                <?php endif; ?>
                    <a data-href="<?php echo base_url().'user/deleteProduct/'.$get->pId.'/'.$pag;?>" class="btn btn-icon btn-danger btn-outline delete"
                  data-toggle="tooltip" title="Delete"><i class="icon md-tag-close" aria-hidden="true"></i></a>
              </h4>
            <figure class="widget-header overlay-hover overlay">
                <?php if(!empty($get->productImage)){ ?>
                    <img class="overlay-figure overlay-scale" src="<?php echo base_url().'../uploads/productImage/'.$get->productImage;?>"
                alt="...">
                <?php } else{ ?>
                    <img class="overlay-figure overlay-scale" src="<?php echo base_url().ADMIN_THEME;?>assets/images/pro.png"
                alt="...">
                <?php } ?>
                <!--  <figcaption class="overlay-panel overlay-background overlay-fade overlay-icon">
                    <a class="icon md-search" href="<?php echo base_url().'../uploads/productImage/'.$get->productImage;?>"></a>
                </figcaption> -->
            </figure>
            <h4 style="background-color:#8e804a;color:#ffffff;" class="widget-title"><?php echo !empty($get->title) ? (ucwords($get->title)) : 'NA';?><span class="price-ryt"><?php echo !empty($get->price) ? '$ '.$get->price : 'NA';?></span></h4>

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