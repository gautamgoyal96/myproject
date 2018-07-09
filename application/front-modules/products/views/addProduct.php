
<script type="text/javascript">
  var emailStatus = "<?php echo $userData['emailVerified']?>";
    var bankAccountStatus = "<?php echo $userData['bankAccountStatus']?>";;
</script>
<!-- main middle content starts -->
<div class="mainWraper adjust_cntainer">
<div class="extra-margin"></div>
  <section class="productAdd pad-sec-60">
    <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-x-12">            
              <h2 class="secTitle"> Add Product </h2>
            </div>
      <div class="col-md-offset-2 col-md-8 col-sm-10 col-sm-offset-1">
        <?php if(!empty($error)){?>
                    <div class="alert dark alert-icon alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?php echo $error; ?>
                    </div>
                    
                <?php } ?>  
        <div class="productAdInner">
          <form method="post" action="#" enctype="multipart/form-data">
             <div class="form-group ">
              <p class="adimg">Add Product Image</p>
              <div class="addImg text-center">
                <ul class="list-inline">
                   <!--  <li>
                        <div class="imgShow">
                            <img src="images/deal-2.jpg">
                        </div>
                    </li> -->
                    <li>
                        <div class="imgShow">
                            <i class="fa fa-plus"></i> 
                            <input accept="image/*" id="fileupload" name="productImages[]" type="file" multiple="multiple" />
                        
                        </div>
                    </li>
                    <div id="dvPreview">
                                        <span id="fileupload-err"></span>

                    </div>

                </ul>      
              </div>
            </div> 
            <div class="form-group">
              <input type="text" class="form-control" id="title" name="title" placeholder="Title" oninput="addproduct(this.form);" maxlength="100" minlength="3">
              <span id="count2"></span>
              <span id="title-err"></span>

            </div>
            <div class="form-group">
              <textarea rows="4" class="form-control" name="description" id="description" placeholder="Short Description" oninput="addproduct(this.form);" maxlength="700" minlength="3"></textarea>
              <span id="count1"></span>
              <span id="description-err"></span>
            </div>
            <div class="form-group">
              <div class="condition">
                <h2>Product Age</h2>
                <div class="productAge condival">
                    <input id="radio1" name="condition" value="new" checked="checked" type="radio" onchange="addproduct(this.form);">
                    <label for="radio1">New</label>
                    <input id="radio2" name="condition" class="demo" value="used" type="radio" onchange="addproduct(this.form);">
                    <label for="radio2">Used</label>
                </div>
              </div>

              <div id="show-me" class="inputSelect container1 getAge">
                <span>
                  <input  id="year1" type="radio" name="productAge" value="-1" onchange="addproduct(this.form);">
                  <label for="year1">-1 Year</label>
                </span>
                <span>
                  <input id="year2" type="radio" name="productAge" value="1" onchange="addproduct(this.form);">
                  <label for="year2">1 Year</label>
                </span>
                <span>
                  <input id="year3" type="radio" name="productAge" value="2" onchange="addproduct(this.form);">
                  <label for="year3">2 Year</label>
                </span>
               <span>
                  <input id="year4" type="radio" name="productAge" value="3" onchange="addproduct(this.form);">
                  <label for="year4">3 Year</label>
                </span>
                <span>
                  <input id="year5" type="radio" name="productAge" value="4" onchange="addproduct(this.form);">
                  <label for="year5">4 Year</label>
                </span>
                <span>
                  <input id="year6" type="radio" name="productAge" value="5+" onchange="addproduct(this.form);">
                  <label for="year6">5+ Year</label>
                </span>
              </div>
              <span id="Product-err"></span>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="address" id="address" placeholder="Product Location Address" value='<?php echo !empty($zipCode) ? $zipCode : '' ;?>' oninput="addproduct(this.form);">
              <span id="address-err"></span>
            </div>
            <div class="form-group">
              <select class="form-control" name="categoryId" id="category" onchange="addproduct(this.form);">
                <option value="">Select Category</option>
                    <?php  foreach($cat as $cat):  ?>
                    <option value="<?php echo $cat->id; ?>" <?php if(isset($_POST['categoryId']) && $this->input->post('categoryId') == $cat->id){ echo "selected='selected'";}?> ><?php echo $cat->categoryName; ?></option>
                    <?php endforeach;?>
              </select>
               <span id="category-err"></span>
            </div>
            <div class="form-group">
              <input class="form-control" type="text" id="brand" name="brandId" value="" placeholder="Brand Name" oninput="addproduct(this.form);">
               <span id="brand-err"></span>
            </div>
            <div class="form-group">
             
                <div class="price_value_main">
              <input type="text" id="set_price1" class="form-control price_value" name="totalPrice1"  min="1" onkeypress="return isNumberKey(event);"  placeholder="Total Price For 8 Hours" oninput="addproduct(this.form);">
 
              <input type="text" id="set_price2" class="form-control price_value" name="totalPrice2"  min="1" onkeypress="return isNumberKey(event);"  placeholder="Total Price For 12 Hours" oninput="addproduct(this.form);">
   
              <input type="text" id="set_price3" class="form-control price_value" name="totalPrice3"  min="1" onkeypress="return isNumberKey(event);"  placeholder="Total Price For 24 Hours" oninput="addproduct(this.form);">

              <input type="text" id="set_price4" class="form-control price_value" name="totalPrice4"  min="1" onkeypress="return isNumberKey(event);"  placeholder="Total Price For 1 Week" oninput="addproduct(this.form);">

              <input type="text" id="set_price5" class="form-control price_value" name="totalPrice5"  min="1" onkeypress="return isNumberKey(event);"  placeholder="Total Price For 1 month" oninput="addproduct(this.form);">
              <span id="price-err" class="serror"></span>

              <span id="adminFees">Including admin fee <?php echo $adminFees;?>%</span>

              
              </div>
              <div id="PriceTime" class="inputSelect container1 timeVal">                 
            

                  <span>
                        <input id="time1" type="checkbox" name="productForRental1" value="1" onchange="addproduct(this.form);">
                        <label id="label1" onclick="showTimeVal8('1');"  for="time1">8 Hours</label>
                        </span>
                  <span>
                        <input id="time2" type="checkbox" name="productForRental2" value="2" onchange="addproduct(this.form);">
                        <label id="label2" onclick="showTimeVal12('2');"  for="time2">12 Hours</label>
                        </span>
                        
                     <span>
                        <input id="time3" type="checkbox" name="productForRental3" value="3" onchange="addproduct(this.form);">
                        <label id="label3" onclick="showTimeVal24('3');"  for="time3">24 Hours</label>
                        </span>
                         <span>
                        <input id="time4" type="checkbox" name="productForRental4" value="4" onchange="addproduct(this.form);">
                        <label  id="label4" onclick="showTimeVal1week('4');"  for="time4">1 Week</label>
                        </span>
                         <span>
                        <input id="time5" type="checkbox" name="productForRental5" value="5" onchange="addproduct(this.form);">
                        <label  id="label5" onclick="showTimeVal1month('5');"  for="time5">1 month</label>
                        </span>           
   
              </div>

             <span id="productForRental-err" class="serror"></span>
			
              
            </div>
            <div class="form-group">
            <a href="JavaScript:void(0)" id="availability">Availability Calendar</a>
                <input type="hidden" id="requestDate"  class="form-control" placeholder="Availability Calender" name="datePicker">
                <input type="hidden" id="calType" value="1" name="">
             <span id="altField-err" class="serror"></span>              
              <div id="datePickerRequest"></div>
            

            </div>
            <div class="form-group">
              <div class="condition">
                <h2>Instant Booking</h2>
                <div class="productAge">
                    <input id="bookingN" name="instantBooking" value="1" type="radio" onchange="addproduct(this.form);">
                    <label for="bookingN">ON</label>
                    <input id="bookingY" name="instantBooking" value="0" checked="checked" type="radio" onchange="addproduct(this.form);">
                    <label for="bookingY">OFF</label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <input class="csBtn" type="submit" onclick=" return addproduct(this.form);" name="submit" value="Submit"/>
            </div>
            <!-- Medai written 360px   -->
          </form>
        </div>
      </div>
      </div>
    </div>
  </section>
</div>

<script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyBCKpfnLn74Hi2GBmTdmsZMJORZ5xyL1as"></script>

  <!-- email Verfication check -->
  <div class="modal fade bookModal" id="emailVerify" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
<!--           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
 -->          <h4 class="modal-title" id="myModalLabel">Alert</h4>
        </div>
        <div class="modal-body">
            <div class="review_grids emilver">
          <div class="ratingStar">
            <p class="rt_str">Email verification Needed</p>   
            <p class="rt_str csTag"><span>A Verification email has been send to your inbox. Please click on the Verify Email link.If not found check your spam and junk folder.</span></p>
          </div>          
          <button type="button" class="btn btn-primary cs-btn has-spinner" id="emailVerifyStatus">Ok</button>
      </div>
        </div>
      </div>
    </div>
  </div>
  <!-- email Verfication check -->


 <!-- email Verfication check -->
  <div class="modal fade bookModal" id="bankVerify" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
<!--           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
 -->          <h4 class="modal-title" id="myModalLabel">Bank Account verification Needed</h4>
        </div>
        <div class="modal-body">
            <div class="review_grids emilver">
          <div class="ratingStar">
            <p class="rt_str csTag"><span>Please add your bank account detail. </span></p>
          </div>          
          <a href="<?php echo base_url('payment/addBankAccount');?>" class="btn btn-primary cs-btn has-spinner">Ok</a>
      </div>
        </div>
      </div>
    </div>
  </div>
  <!-- email Verfication check -->


