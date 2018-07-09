<script type="text/javascript">
  var authToken = '<?php echo $this->session->userdata('authToken');?>';
</script>
<div class="paymentMain">
    <div class="content">
      <div class="sap_tabs">
        <div id="horizontalTab" style="display: block; width: 100%; margin: 0px;">
          <div class="pay-tabs">
<!--             <h2>Select Payment Method</h2>
 -->              <ul class="resp-tabs-list">
                <div class="clear"></div>
              </ul> 
          </div>
          <div class="resp-tabs-container">
            <div class="">
               <div class="payment-info">
                <h3>Add Your Bank Account</h3>
                <form action="JavaScript:void(0);" method="post">
                <div class="row">
                  <div class="col-md-6">
                    <div class="tab-for">       
                      <h5>First Name</h5>
                      <input type="text" value="" id="firstName" oninput="isNumberKey1(event);">
                      <div id="firstName_error"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="tab-for">       
                      <h5>Last Name</h5>
                      <input type="text" value="" id="lastName">
                      <div id="lastName_error"></div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="tab-for">       
                      <h5>Date of Birth</h5>
                      <input type="text" value="" id="dob">
                      <div id="dob_error"></div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="tab-for">       
                      <h5>Routing Number</h5>
                      <input type="text" id="routingnumber">
                      <div id="routingnumber_error"></div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="tab-for">       
                      <h5>Account Number</h5>
                      <input type="text" value="" placeholder="" id="accountNumber">
                      <div id="accountNumber_error"></div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="tab-for">       
                      <h5>Confirm Account Number</h5>
                      <input type="text" value="" placeholder="" id="caccountNumber">
                      <div id="caccountNumber_error"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="tab-for">       
                      <h5>Country Code</h5>
                      <input type="text" id="countryCode" value="US" readonly>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="tab-for">       
                      <h5>Currency</h5>
                      <input type="text" id="currency" type="text" value="USD" readonly>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="tab-for">       
                      <h5>Address</h5>
                      <input type="text" value="<?php echo !empty($ownerDetail['address']) ? $ownerDetail['address']: '';?>" id="zip_cde">
                      <div id="address_error"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="tab-for">       
                      <h5>City</h5>
                        <input type="text" id="city" name="city">
                      <div id="city_error"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="tab-for">       
                      <h5>State</h5>
                        <select name="state" id="state">
                         <option value="" >Select State</option>
                          <?php foreach($city as $c => $d){ ?>
                          <option  value="<?php echo $d; ?>" ><?php echo $d; ?></option>
                          <?php } ?>
                       </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="tab-for">       
                      <h5>Postal Code</h5>
                      <input type="text" value="" id="postalCode">
                      <div id="postalCode_error"></div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="tab-for">       
                      <h5>SSN Last</h5>
                      <input type="text" id="ssnLast">
                      <div id="ssnLast_error"></div>
                    </div>
                  </div>
                
                </div>
                <button type="submit" id="addBankAccount" class="has-spinner">Submit</button>          
                <div class="clear"></div>
                </form>
              </div>
            </div>
         
          </div>  
        </div>
      </div>  
    </div>
  </div>
