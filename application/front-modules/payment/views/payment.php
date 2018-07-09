<script type="text/javascript">
  var authToken = '<?php echo $this->session->userdata('authToken');?>';
</script>
<div class="paymentMain">
    <div class="content">
      <div class="sap_tabs">
        <div id="horizontalTab" style="display: block; width: 100%; margin: 0px;">
          <div class="pay-tabs">
            <h2>Select Payment Method</h2>
              <ul class="resp-tabs-list">
                <li class="resp-tab-item" aria-controls="tab_item-0" role="tab"><span><label><img src="<?php echo base_url().FRONT_THEME;?>images/pic2.png"></label>Credit Card</span></li>
                <li class="resp-tab-item" aria-controls="tab_item-1" role="tab"><span><label><img src="<?php echo base_url().FRONT_THEME;?>images/bank_pic.png"></label>Bank Account</span></li>
                <div class="clear"></div>
              </ul> 
          </div>
          <input type="hidden" value="<?php echo $this->uri->segment(3);?>" id="requestId">
          <div class="resp-tabs-container">
            <div class="tab-1 resp-tab-content" aria-labelledby="tab_item-0">
              <div class="payment-info">
                <h3 class="pay-title">Credit Card Info</h3>
                <form action="JavaScript:void(0);" method="post">
                  <div class="tab-for">       
                    <h5>Name On Card</h5>
                    <div>
                      <input type="text" value="" id="holderName">
                      <div id="holderName_error"></div>
                    </div>
                    <div>
                    <h5>Card Number</h5>                          
                      <input class="pay-logo" type="text" placeholder="XXXX-XXXX-XXXX-XXXX" id="cardNumber" onkeypress="return isNumberKey(event);" >
                      <div id="cardNumber_error"></div>
                    </div>
                  </div>  
                  <div class="transaction">
                    <div class="tab-form-left user-form">
                      <h5>Expiry Date</h5>
                        <ul>
                          <li>
                  
                            <select id="expiryMonth" minlength="2" class="text_box">
                              <option value="">XX</option>
                              <?php for($i=1;$i<=12;$i++){?>
                              <option value="<?php echo $i<10 ? "0".$i : $i;?>"><?php echo $i<10 ? "0".$i : $i;?></option>
                              <?php }?>
                            </select>
                            <div id="expiryMonth_error"></div> 
                          </li>
                          <li>

                             <select id="expiryYear" minlength="2" class="text_box">
                              <option value="">XXXX</option>
                              <?php for($i=2015;$i<=2050;$i++){?>
                              <option value="<?php echo $i;?>"><?php echo $i;?></option>
                              <?php }?>
                            </select>

                           
                            <div id="expiryYear_error"></div> 
                          </li>
                          
                        </ul>
                    </div>
                    <div class="tab-form-right user-form-rt">
                      <h5>CVV Number</h5>                         
                      <input type="text" placeholder="XXX" id="cvvNumber" onkeypress="return isNumberKey(event);" maxlength="4" >
                      <div id="cvvNumberr_error"></div>
                    </div>
                    <div class="clear"></div>
                  </div>
                  <button type="submit" id="cardPayment" class="has-spinner">Submit</button>          
                </form>
              </div>
            </div>
            <div class="tab-1 resp-tab-content" aria-labelledby="tab_item-1">
              <div class="payment-info">
                <h3>Add Your Bank Account</h3>
                <form action="JavaScript:void(0);" method="post">

                <div class="row">
                  <div class="col-md-12">
                    <div class="tab-for">       
                      <h5>Holder Name</h5>
                      <input type="text" value="" id="firstName" oninput="isNumberKey1(event);">
                      <div id="firstName_error"></div>
                    </div>
                  </div>
                  <!-- <div class="col-md-6">
                    <div class="tab-for">       
                      <h5>Last Name</h5>
                      <input type="text" value="" id="lastName">
                      <div id="lastName_error"></div>
                    </div>
                  </div> -->
              
                  <div class="col-md-12">
                    <div class="tab-for">       
                      <h5>Account Number</h5>
                      <input type="text" value="" placeholder="XXXX-XXXX-XXXX-XXXX" id="accountNumber">
                      <div id="accountNumber_error"></div>
                    </div>
                  </div>
                  <input type="hidden" id="countryCode" value="US">
                  <input type="hidden" id="currency" type="text" value="USD">

                 
                 <div class="col-md-12">
                    <div class="tab-for">       
                      <h5>Routing Number</h5>
                      <input type="text" id="routingnumber">
                      <div id="routingnumber_error"></div>
                    </div>
                  </div>
                </div>
                <button type="submit" id="bankPayment" class="has-spinner">Submit</button>          
                <div class="clear"></div>
                </form>
              </div>
            </div>
          </div>  
        </div>
      </div>  
    </div>
  </div>

  <script type="application/x-javascript">
addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
  function hideURLbar(){ window.scrollTo(0,1); } 
    $(document).ready(function () {
    $('#horizontalTab').easyResponsiveTabs({
      type: 'default',         
      width: 'auto', 
      fit: true 
    });
  });   
</script>