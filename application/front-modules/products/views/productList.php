<div class="rm-category__animate">
    <div class="row">
        <?php
 
         if(!empty($productData)){ foreach ($productData as $get) { ?>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 rm-category__cardblock">
                <div class="rm-category__card">
                    <div class="category-image__block">
                        <a href="<?php echo base_url();?>products/viewProduct/<?php echo $get['productId']; ?>">                                                
                            <img class="img-responsive" src="<?php echo $get['productImage'];?>" alt="...">
                        </a>
                        <?php if($get['isRented']=="1"){?>
                        <span class="onRent"><img src="<?php echo base_url().FRONT_THEME;?>images/rented.png"></span>
                        <?php }if($get['condition']=="new"){?>
                        <span class="onNew"><img src="<?php echo base_url().FRONT_THEME;?>images/ico_new_item.png"></span>
                        <?php }else{?>
                          <span class="onNew"><img src="<?php echo base_url().FRONT_THEME;?>images/used.png"></span>
                        <?php }?>
                    </div>
                    <div class="ForEdit">
                    <a href="<?php echo base_url();?>products/viewProduct/<?php echo $get['productId']; ?>">
                        <div class="rm-category__desc newCsPr">
                            <div class="NewL">
                                <h2> <?php echo !empty($get['title']) ? (ucwords($get['title'])) : 'NA';?> </h2>
                            </div>
                            <div class="NewR">
                                <p><span><?php echo  $get['price']; ?> </span> - <?php echo $get['myPerProduct'];?></p>
                              
                            </div>
                        </div>
                        <div class="rm-category__view"> <span>View Product</span></div>
                    </a>
         
                    </div>
                </div>
            </div>
        <?php } } else{ echo "<div class='notFound'><h3>No Record found</h3></div>"?>			
		<?php } ?>
    </div>
</div>
<div class="">
    <?php echo $links; ?> 
</div>
