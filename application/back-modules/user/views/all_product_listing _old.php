<!-- Panel -->
    <div class="panel-body">
        <div class="nav-tabs-horizontal">
            <ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist"></ul>
                <div class="tab-content">
                    <div class="tab-pane animation-fade active" id="all_contacts" role="tabpanel">
                        <ul class="list-group">
                            <?php $pag=$sn-1; if(count($product) && !empty($product)): foreach($product as $val):?>
                            <li class="list-group-item">
                                <div class="media">
                                    <div class="media-left">
<!--
                                        <div class="serialno"><?php //echo $i; ?></div>
-->
                                    </div>
                                    <div class="media-left">
                                        <div class="avatar avatar-off">
                                            <?php  if(!filter_var($val->productImage, FILTER_VALIDATE_URL) === false) { ?>
                                                <td>
                                                    <img alt="..." src="<?php echo $val->productImage;?>"/>
                                                </td>
                                            <?php   }else if(empty($val->productImage)){ ?>
                                                <td class="cell-300">
                                                    <img alt="..." src= "<?php echo base_url().ADMIN_THEME;?>assets/images/pro.png">
                                                </td>
                                            <?php } else{  ?>
                                                <td class="cell-300">
                                                    <img alt="..." src="<?php echo base_url().'../uploads/productImage/thumb/'.$val->productImage;?>"/>
                                                </td>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div class="col-md-2" >
                                            <h4 class="media-heading">
                                               <?php echo ucwords($val->title);?>
                                               <!-- <small>Passenger Detail</small> -->
                                            </h4>
                                            <p><i class="icon icon-color fa-road" aria-hidden="true"></i><?php echo empty($val->condition) ? 'NA' : $val->condition; ?></p>

                                            <p><i class="icon icon-color wb-mobile" aria-hidden="true"></i><?php echo empty($val->brandName) ? 'NA' : $val->brandName; ?></p>

                                            <!-- <p><i class="icon icon-color wb-time" aria-hidden="true"></i> <?php echo empty($val->rideStartDate) ? 'NA' : DATE("d M,Y",strtotime($val->rideStartDate)); ?>  <?php echo empty($val->rideStartTime) ? 'NA' : DATE("H:i",strtotime($val->rideStartTime)); ?></p> -->
                                        </div>
                                        <div class="col-md-3" >
                                            <p><i class="icon icon-color wb-map" aria-hidden="true"><span class="cs-span"> Category -</span></i><?php echo empty($val->categoryName) ? 'NA' : $val->categoryName; ?> </p>

                                            <p><i class="icon icon-color wb-home" aria-hidden="true"><span class="cs-span"> Brand -</span></i><?php echo empty($val->brandName) ? 'NA' : $val->brandName; ?> </p>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <!-- <p><i class="icon icon-color fa-car" aria-hidden="true"><span class="cs-span">  Ride Status -</span></i>
                                                <?php if($val->rideStatus == 1) { ?>
                                                    <span  class="label label-outline label-info"> New</span>
                                                <?php } elseif($val->rideStatus == 2){ ?>
                                                    <span class="label label-outline label-success"> Confirm</span>
                                                <?php } elseif($val->rideStatus == 3) { ?>
                                                    <span class="label label-outline label-success"> Start</span>
                                                <?php } elseif($val->rideStatus == 4) { ?>
                                                    <span class="label label-outline label-warning"> End</span>
                                                <?php } elseif($val->rideStatus == 5) { ?>
                                                    <span class="label label-outline label-danger"> Cancel</span>
                                                <?php } elseif($val->rideStatus == 6) { ?>
                                                    <span class="label label-outline label-success"> On The Way</span>
                                                <?php } ?>
                                            </p> -->
                                            <!-- <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal">Map</button> -->
                                        </div>

                                        <div class="media-right">
                                            <div class="media-right">

                                                <?php if($val->pStatus == 1){ ?>
                                                    <a href="<?php echo base_url()."user/activeProduct/" . $val->pId.'/'.$pag; ?>"  class="btn btn-icon btn-primary btn-round waves-effect waves-round waves-light" data-toggle="tooltip" title="Inactive">
                                                    <i style="margin:0px;" class="icon md-close" aria-hidden="true"></i>
                                                    </a>    
                                                <?php } else{ ?>
                                                    <a href="<?php echo base_url()."user/activeProduct/" . $val->pId.'/'.$pag; ?>"  class="btn btn-icon btn-warning btn-round waves-effect waves-round waves-light" data-toggle="tooltip" title="Active"><i style="margin:0px;" class="icon md-check" aria-hidden="true"></i>
                                                    </a>    
                                                <?php } ?>
                                               
                                                <button type="button" data-href="<?php echo base_url().'user/deleteProduct/'.$val->pId.'/'.$pag;?>" class="btn btn-icon btn-danger btn-round waves-effect waves-round waves-light delete" data-toggle="tooltip" title="Delete"><i style="margin:0px;" class="icon md-delete" aria-hidden="true"></i> </button>
                    
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                          <?php //$i++;
                           endforeach;?>
                            <?php else:?>
                            <tr class="even pointer">
                                <td class=" " colspan="7">No Record Found.</td>
                            </tr>
                            <?php endif;?>
                        </ul>
                        <?php echo $links;?>
                        <nav>
                          <ul data-plugin="paginator" data-total="50" data-skin="pagination-no-border"></ul>
                        </nav>
                </div>
            </div>
        </div>
    </div>
<!-- End Panel-->
