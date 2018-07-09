<!-- <pre>
<?php //print_r($renter);die();?>
</pre> -->
<!-- Page -->

<div class="page animsition">
    <div class="page-header">
        <h1 class="page-title">Product Details</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>dashboard">Home</a></li>
            <li><a href="<?php echo base_url();?>user/allProduct">All Product</a></li>
        </ol>    
    </div>
    <div class="page-content container-fluid">
        
        <div class="row">
            
                        <div class="col-md-3">
                          <!-- Page Widget -->
                          <div class="widget widget-shadow text-center">
                            <div class="widget-header">
                              <div class="widget-header-content">
                                <a class="avatar avatar-lg" href="javascript:void(0)">

                                <?php 
                                $url = base_url()."../uploads/profile/54055ffa7b78c33c1a4310f7914e034c.png";
                                $t = base_url()."../uploads/profile/".$productDetail['profileImage'];
                                if(!empty($productDetail['profileImage']) && file_exists($t)){
                                  echo 'aa';
                                  die();

                                  $url = base_url()."../uploads/profile/".$productDetail['profileImage'];

                                 }else if(!empty($productDetail['profileImage']) && filter_var($productDetail['profileImage'], FILTER_VALIDATE_URL) === true){
                                  
                                    $url = $productDetail['profileImage'];
                                  }else  if(!empty($productDetail['profileImage'])){
                                   
                                      $url = base_url().'../uploads/profile/'.$productDetail['profileImage'];

                                  }else{

                                    $url = base_url()."../uploads/profile/".$productDetail['profileImage'];

                                    }?>
                                <img src="<?php echo $url;?>" alt="..." style="width: 100px; height: 100px;">

                                </a>
                                <h4 class="profile-user"><?php echo $productDetail['firstName']." ".$productDetail['lastName'];?></h4>
                                <div class="example">
                                  <div class="rating-menu">
                          <div class="rating-menu1" style="width:<?php echo $productDetail['rating']*20; ?>%;">  
                        </div>
                        </div>
                                </div>
                                <p class="profile-job"><?php echo $productDetail['email'];?></p>
                                
                               <!--  <ul class="usDetails list-unstyled">
                                  <li class="list-group-item"></li>
                                 <li class="list-group-item">Total Product <span class="badge badge-info">10</span></li> 
                                </ul> -->
                               <p><?php echo $productDetail['about'];?></p>
                              </div>
                            </div>
                          </div>
                          <!-- End Page Widget -->
                        </div>
                        <div class="col-md-9">
                          <!-- Panel -->
                          <div class="panel">
                            <div class="panel-body nav-tabs-animate nav-tabs-horizontal">
                                       <div class="media-right btn-right">
                        <a href="<?php echo base_url();?>user/allProduct/<?php echo $userId;?>" class="btn btn-primary waves-effect waves-light"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                      </div>
                              <ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
                                
                                <li class="active" role="presentation"><a data-toggle="tab" href="#PrDetails" aria-controls="PrDetails"
                                  role="tab">Product Details</a></li>
                                <li role="presentation"><a data-toggle="tab" href="#rented" aria-controls="profile" role="tab">Rented</a></li>
                                <li role="presentation"><a data-toggle="tab" href="#request" aria-controls="profile" role="tab">Request</a></li>
                                <li role="presentation"><a data-toggle="tab" href="#productGallery" aria-controls="activities" role="tab">Product Gallery</a></li>
                                 <li role="presentation"><a data-toggle="tab" href="#ProductDescription" aria-controls="activities" role="tab">Product Description</a></li>
                              </ul>
                        
                             <div class="tab-content">
                             <!-- start tab 1-->
                              <div class="tab-pane active animation-slide-left" id="PrDetails" role="tabpanel">
                                    <div class="productDetails">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="panel-heading">
                                                <h3 class="widget-title"><?php echo $productDetail['title'];?></h3>                   
                                                </div>

                                               

                                                <div class="productPrice">
                                                <h2>Total Price : <span><?php echo !empty($productDetail['totalPrice']) ? '$'.$productDetail['totalPrice'] : 'NA';?></span>  </h2>
                                                </div>
                                                <div class="condition">

                                               <h3>  <span class="label label-primary" id="viewPrice">View Price</span></h3>
              <div id="showHrTbl" class="csHide priceTable">
                  <table class="table">
                      <thead>
                          <tr>
                              <th>Duration</th>
                              <th>Price</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php $totalPrice = explode(",",$productDetail['totalPrice']);
                      $productForRental = explode(",",$productDetail['productForRental']);
                      foreach ($productForRental as $key => $value) { ?>
                      <tr>
                        <td>
                          <?php 
                          switch ($value) {
                              case 1:
                                  echo "8 Hour";
                                  break;
                              case 2:
                                  echo "12 Hour";
                                  break; 
                              case 3:
                                  echo "24 Hour";
                                  break;
                              case 4:
                                  echo "1 Week";
                                  break; 
                              case 5:
                                  echo "1 Month";
                                  break;
                          }
                          ?>
                        </td>
                        <td><?php echo "$ ".$totalPrice[$key];?></td>
                      </tr>
                    <?php } ?>
                      </tbody>
                  </table>
              </div>
            </div>

                                                <!-- <div class="productDec">
                                                <h2>Description :</h2>
                                                <span><?php echo !empty($productDetail['description']) ? $productDetail['description'] : 'NA';?></span>
                                                </div>
 -->
                                                <div class="condition">
                                                <h2>Condition : <span class="label label-primary"><?php echo !empty($productDetail['condition']) ? ucwords($productDetail['condition']) : 'NA';?></span></h2>
                                                </div>
                                                <?php if(!empty($productDetail['productAge'])){?>
                                                <div class="condition">
                                                <h2>Product Age : <span class="label label-primary"><?php echo !empty($productDetail['productAge']) ? ucwords($productDetail['productAge']) : 'NA';?></span></h2>
                                                </div>
                                                <?php }?>

                                                
                                                <div class="productDec">
                                                <h2>Instant Booking :</h2>
                                                <span><?php echo ($productDetail['instantBooking'] == 1) ? 'ON' : 'OFF';?></span>
                                                </div>
                                                 <div class="productDec">
                                                <h2>Address :</h2>
                                                <span><?php echo $productDetail['address'];?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                  <!-- End tab 1-->

                                  <!-- start tab 2 -->

                                  <div class="tab-pane animation-slide-left" id="rented" role="tabpanel">
                                  <div class="RequestList">
                                    <ul class="list-group">
                                    <?php if(!empty($renter)){ foreach($renter as $row){?>
                                      <li class="list-group-item menuLi">
                                      <div class="media">
                                        <div class="media-left">
                                          <a class="avatar" href="javascript:void(0)">
                                          <img class="img-responsive" src="<?php echo $row->profileImage;?>" style="height: 50px !important;
                                          width: 50px !important;" alt="...">
                                          </a>
                                        </div>
                                        <div class="media-body">
                                          <h4 class="media-heading"><?php echo $row->fullName;?></h4>
                                           <div class="rating-menu">
                          <div class="rating-menu1" style="width:<?php echo $row->rating*20; ?>%;"> </div> 
                        </div>
                        <br>
                                           <small><?php echo strtoupper($row->requestStatus);?><br></small>
                                 
                                          <small><?php echo $row->crd;?></small>

                                        </div>
                                      </div>
                                      </li>
                                    <?php }}else{?>
                                     <li class="list-group-item menuLi">
                                      <div class="media">
                                        <div class="media-left">
                                         
                                        </div>
                                        <div class="media-body">
                                          <h4 class="media-heading">No request found</h4>
                                        </div>
                                      </div>
                                      </li>
                                    <?php }?>
                                    </ul>
                                  </div>
                                </div>

                                  <!-- End tab 2 -->

                                  <!-- start tab 3 -->

                                  <div class="tab-pane animation-slide-left" id="request" role="tabpanel">
                                  <div class="RequestList">
                                    <ul class="list-group">
                                    <?php if(!empty($request)){ foreach($request as $row){?>
                                      <li class="list-group-item menuLi">
                                      <div class="media">
                                        <div class="media-left">
                                          <a class="avatar" href="javascript:void(0)">
                                          <img class="img-responsive" src="<?php echo $row->profileImage;?>" style="height: 50px !important;
                                          width: 50px !important;" alt="...">
                                          </a>
                                        </div>
                                        <div class="media-body">
                                          <h4 class="media-heading"><?php echo $row->fullName;?></h4>
                                            <div class="rating-menu">
                          <div class="rating-menu1" style="width:<?php echo $row->rating*20; ?>%;"> </div> 
                        </div>
                        <br>
                                          <small><?php echo $row->crd;?></small>
                                        </div>
                                      </div>
                                      </li>
                                    <?php }}else{?>
                                     <li class="list-group-item menuLi">
                                      <div class="media">
                                        <div class="media-left">
                                         
                                        </div>
                                        <div class="media-body">
                                          <h4 class="media-heading">No request found</h4>
                                        </div>
                                      </div>
                                      </li>
                                    <?php }?>
                                    </ul>
                                  </div>
                                </div>

                                <!-- End tab 3 -->

                                <!-- start tab 4 -->

                                <div class="tab-pane animation-slide-left" id="productGallery" role="tabpanel">
                                  <ul class="blocks blocks-100 blocks-xlg-4 blocks-md-3 blocks-sm-2 example prGallery" id="exampleGallery">
                                    <?php foreach ($pImages as $row){  ?>
                                      <li data-type="animal">
                                        <div class="widget widget-shadow">
                                          <a class="fancybox" href="<?php echo base_url().'../uploads/productImage/'.$row['productImage'];?>" data-fancybox-group="gallery">
                                                <?php if(!empty($row['productImage'])){ ?>                                          
                                                <img class="cover-image overlay-figure overlay-scale" src="<?php echo base_url().'../uploads/productImage/'.$row['productImage'];?>" alt="...">
                                                <?php } else{ ?>
                                                <img class="cover-image" src="<?php echo base_url().ADMIN_THEME;?>assets/images/pro.png" alt="...">
                                                <?php } ?> 
                                          </a>
                                        </div>
                                      </li>
                                    <?php }?>
                                      
                                  </ul>
                                </div>

                                <!-- End tab 4 -->

                                <!-- start tab 5 -->
                                <div class="tab-pane animation-slide-left" id="ProductDescription" role="tabpanel">
                                    <div class="">
                                    <?php echo $productDetail['description'];?>
                                    </div>
                                </div>
                                <!-- End tab 5 -->
                             </div>
                            </div>
                          </div>
                          <!-- End Panel -->
                        </div>
                    </div>
                
    </div>
</div>
<!-- End Page -->

<script type="text/javascript">
$('#showHrTbl').hide();
   $("#viewPrice").click(function(){

        $('#showHrTbl').slideToggle();
    });

</script>
