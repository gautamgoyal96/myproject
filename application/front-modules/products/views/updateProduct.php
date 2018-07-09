<!-- main middle content starts -->
<style type="text/css">
  .mhidden{
    display: none;
  }
</style>
<?php 
$productForRental = explode(",",$details->productForRental);
$totalPrice = explode(",",$details->totalPrice);

$productForRental8hrs = $price8hrs = $productForRenta12hrs =  $price12hrs = $productForRenta24hrs = $price24hrs = $productForRenta1week = $price1week =  $productForRenta1m =  $price1m = '0';
if(in_array("1", $productForRental)){

  $key = array_search('1', $productForRental); // $key = 2;

  $productForRental8hrs = "1";
  $price8hrs = $totalPrice[$key];

}
if(in_array("2", $productForRental)){

  $key = array_search('2', $productForRental); // $key = 2;
  $productForRenta12hrs = "2";
  $price12hrs = $totalPrice[$key];

}
if(in_array("3", $productForRental)){

  $key = array_search('3', $productForRental); // $key = 2;

  $productForRenta24hrs = "3";
  $price24hrs = $totalPrice[$key];
  

}
if(in_array("4", $productForRental)){
  
  $key = array_search('4', $productForRental); // $key = 2;
  $productForRenta1week = "4";
  $price1week = $totalPrice[$key];

}
if(in_array("5", $productForRental)){

  $key = array_search('5', $productForRental); // $key = 2;
  $productForRenta1m = "5";
  $price1m = $totalPrice[$key];

}

?>
<div class="mainWraper adjust_cntainer">
<div class="extra-margin"></div>
  <section class="productAdd pad-sec-60">
    <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-x-12">            
              <h2 class="secTitle"> Edit Product </h2>
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
          <form method="post" action="<?php echo base_url('products/productUpdate');?>">
          <input type="hidden" value="<?php echo $details->id;?>" name="id">

          <div class="form-group">
             
  

              <div class="price_value_main">
              <input type="text" id="set_price1" class="form-control price_value  <?php if(empty($price8hrs)){echo "mhidden";}else{ echo "valPrice";}?>" name="totalPrice1"  min="1" onkeypress="return isNumberKey(event);"  placeholder="Total Price For 8 Hours" oninput="editproduct(this.form);" value="<?php echo $price8hrs ? $price8hrs : "";?>">
 
              <input type="text" id="set_price2" class="form-control price_value <?php if(!empty($price8hrs) || empty($price12hrs) || !empty($price24hrs) && !empty($price1week) && !empty($price1m) && !empty($price8hrs)){echo "mhidden";}else{ echo "valPrice";}?>" name="totalPrice2"  min="1" onkeypress="return isNumberKey(event);"  placeholder="Total Price For 12 Hours" oninput="editproduct(this.form);" value="<?php echo $price12hrs ? $price12hrs : "";?>">
   
              <input type="text" id="set_price3" class="form-control price_value <?php if(empty($price24hrs) || !empty($price8hrs) || !empty($price12hrs) || !empty($price1week) && !empty($price1m) && empty($price24hrs)){echo "mhidden";}else{ echo "valPrice";}?>" name="totalPrice3"  min="1" onkeypress="return isNumberKey(event);"  placeholder="Total Price For 24 Hours" oninput="editproduct(this.form);" value="<?php echo $price24hrs ? $price24hrs : "";?>">

              <input type="text" id="set_price4" class="form-control price_value <?php if(empty($price1week) || !empty($price24hrs) || !empty($price12hrs) ||  !empty($price8hrs)){echo "mhidden";}else{ echo "valPrice";}?>" name="totalPrice4"  min="1" onkeypress="return isNumberKey(event);"  placeholder="Total Price For 1 Week" oninput="editproduct(this.form);" value="<?php echo $price1week ? $price1week : "";?>">

              <input type="text" id="set_price5" class="form-control price_value <?php if(empty($price1m) || !empty($price1week) && !empty($price1m) && !empty($price8hrs) && !empty($price12hrs) || !empty($price8hrs) || !empty($price12hrs) && !empty($price1week) || !empty($price1m) && !empty($price1week)  || !empty($price1m) && !empty($price24hrs) || !empty($price1m) && !empty($price1m)){echo "mhidden";}else{ echo "valPrice";}?>" name="totalPrice5"  min="1" onkeypress="return isNumberKey(event);"  placeholder="Total Price For 1 month" oninput="editproduct(this.form);" value="<?php echo $price1m ? $price1m : "";?>">
              <span id="price-err" class="serror"></span>

              
              </div>


              <div id="PriceTime" class="inputSelect container1 timeVal">                 
            

                  <span>
                        <input id="time1" type="checkbox" name="productForRental1" value="1" onchange="editproduct(this.form);" <?php if($productForRental8hrs == "1") { echo 'checked="checked"';}?>>
                        <label id="label1" onclick="showTimeVal8('1');"  for="time1">8 Hours</label>
                        </span>
                  <span>
                        <input id="time2" type="checkbox" name="productForRental2" value="2" onchange="editproduct(this.form);" <?php if($productForRenta12hrs == "2") { echo 'checked="checked"';}?>>
                        <label id="label2" onclick="showTimeVal12('2');"  for="time2">12 Hours</label>
                        </span>
                        
                     <span>
                        <input id="time3" type="checkbox" name="productForRental3" value="3" onchange="editproduct(this.form);" <?php if($productForRenta24hrs == "3") { echo 'checked="checked"';}?>>
                        <label id="label3" onclick="showTimeVal24('3');"  for="time3">24 Hours</label>
                        </span>
                         <span>
                        <input id="time4" type="checkbox" name="productForRental4" value="4" onchange="editproduct(this.form);" <?php if($productForRenta1week == "4") { echo 'checked="checked"';}?>>
                        <label  id="label4" onclick="showTimeVal1week('4');"  for="time4">1 Week</label>
                        </span>
                         <span>
                        <input id="time5" type="checkbox" name="productForRental5" value="5" onchange="editproduct(this.form);" <?php if($productForRenta1m == "5") { echo 'checked="checked"';}?>>
                        <label  id="label5" onclick="showTimeVal1month('5');"  for="time5">1 month</label>
                        </span>           
   
              </div>

             <span id="productForRental-err" class="serror"></span>
			
              
            </div>
            <div class="form-group">
                        <a href="JavaScript:void(0)" id="availability">Availability Calendar</a>
                <input type="hidden" id="requestDate"  class="form-control date" placeholder="Availability Calender" name="datePicker" value="<?php echo $details->availStartDate; ?>">
                <input type="hidden" id="calType" value="1" name="">
               <span id="altField-err" class="serror"></span>              
              <div id="datePickerRequest"></div>

            </div>

            <div class="form-group">
              <div class="condition">
                <h2>Instant Booking</h2>
                <div class="productAge">
                    <input id="bookingN" name="instantBooking" value="1" <?php if($details->instantBooking== "1") { ?>checked="checked" <?php }?>  type="radio">
                    <label for="bookingN">ON</label>
                    <input id="bookingY" name="instantBooking" value="0" <?php if($details->instantBooking== "0") { ?>checked="checked" <?php }?> type="radio">
                    <label for="bookingY">OFF</label>
                </div>
              </div>
            </div>

            <div class="form-group">
              <input class="csBtn" type="submit" onclick=" return editproduct(this.form);" name="submit" value="Submit"/>
            </div>
            <!-- Medai written 360px   -->
          </form>
        </div>
      </div>
      </div>
    </div>
  </section>
</div>
