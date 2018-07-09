  /* Creater by Developer Gautam Goyal */

    function setState(a){

      var a = a.replace(" ", "1");
      var className = $('#'+a).attr('class');
      var state = className.replace("1", " ");
      $('#state').val(state);


    }
    $("#lastName").keypress(function(e) {

        var code = e.keyCode || e.which;
        if ((code < 65 || code > 90) && (code < 97 || code > 122) && code != 32 && code != 46 && code != 9 && code != 8) {
            jQuery("#lastName").parent("div").addClass("has-error");
            $('#lastName_error').html("<p class='err_msg'> Only alphabets are allowed</p>");
            return false;
        } else {
            jQuery("#lastName").parent("div").removeClass("has-error");
            $('#lastName_error').html("");
            return true;
        }

   });
  $("#firstName").keypress(function(e) {
      var code = e.keyCode || e.which;
      if ((code < 65 || code > 90) && (code < 97 || code > 122) && code != 32 && code != 46 && code != 9 && code != 8) {
          jQuery("#firstName").parent("div").addClass("has-error");
          $('#firstName_error').html("<p class='err_msg'> Only alphabets are allowed</p>");
          return false;
      } else {
          jQuery("#firstName").parent("div").removeClass("has-error");
          $('#firstName_error').html("");
          return true;
      }
  });

  $( "#dob" ).datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          changeYear: true,
          numberOfMonths: 1,
          maxDate: 0,
          yearRange: "-100:+0",
          dateFormat: "yy-mm-dd",
        })


    $("#addBankAccount").click(function(){
          var firstName = $("#firstName").val();
          var lastName = $("#lastName").val();
          var dob = $("#dob").val();
          var accountNumber = $("#accountNumber").val();
          var countryCode = $("#countryCode").val();
          var currency = $("#currency").val();
          var address = $("#zip_cde").val();
          var city = $("#city").val();
          var state = $("#state").val();
          var postalCode = $("#postalCode").val();
          var ssnLast = $("#ssnLast").val();
          var caccountNumber = $("#caccountNumber").val();
          var routingnumber = $("#routingnumber").val();
          data = {holderName:firstName+" "+lastName,dob:dob,accountNo:accountNumber,country:countryCode,currency:currency,address:address,city:city,state:state,postalCode:postalCode,ssnLast:ssnLast,routingNumber:routingnumber,saveDetail:"1"};

          jQuery("#firstName").parent("div").removeClass("has-error");
              $('#firstName_error').html("");
          jQuery("#lastName").parent("div").removeClass("has-error");
              $('#lastName_error').html("");
          jQuery("#dob").parent("div").removeClass("has-error");
              $('#dobe_error').html("");
          jQuery("#accountNumber").parent("div").removeClass("has-error");
              $('#accountNumber_error').html("");  
          jQuery("#address").parent("div").removeClass("has-error");
              $('#address_error').html("");  
          jQuery("#city").parent("div").removeClass("has-error");
              $('#city_error').html("");  
          jQuery("#postalCode").parent("div").removeClass("has-error");
              $('#postalCode_error').html("");  
          jQuery("#ssnLast").parent("div").removeClass("has-error");
              $('#ssnLast_error').html("");        
          jQuery("#routingnumber").parent("div").removeClass("has-error");
              $('#routingnumber_error').html(""); 
          jQuery("#caccountNumber").parent("div").removeClass("has-error");
              $('#caccountNumber_error').html(""); 
             

            if(firstName==""){

                    jQuery("#firstName").parent("div").addClass("has-error");
                    $('#firstName_error').html("<p class='serror'>First Name field is required</p>");

            }else if(lastName==""){

                    jQuery("#lastName").parent("div").addClass("has-error");
                    $('#lastName_error').html("<p class='serror'>Last Name field is required</p>");

            }else if(dob==""){

                    jQuery("#dob").parent("div").addClass("has-error");
                    $('#dob_error').html("<p class='serror'>Date of birth field is required</p>");

            }else if(routingnumber==""){

                    jQuery("#routingnumber").parent("div").addClass("has-error");
                    $('#routingnumber_error').html("<p class='serror'>Routing number field is required</p>");

            }else if(accountNumber==""){

                    jQuery("#accountNumber").parent("div").addClass("has-error");
                    $('#accountNumber_error').html("<p class='serror'>Account Number field is required</p>");

            }else if(caccountNumber==""){

                    jQuery("#caccountNumber").parent("div").addClass("has-error");
                    $('#caccountNumber_error').html("<p class='serror'>Confirm Account Number field is required</p>");

            }else if(caccountNumber!=accountNumber){

                    jQuery("#caccountNumber").parent("div").addClass("has-error");
                    $('#caccountNumber_error').html("<p class='serror'>Account number and confirm account number should be same.</p>");

            }else if(address==""){

                    jQuery("#address").parent("div").addClass("has-error");
                    $('#address_error').html("<p class='serror'>Address field is required</p>");

            }else if(city==""){

                    jQuery("#city").parent("div").addClass("has-error");
                    $('#city_error').html("<p class='serror'>City field is required</p>");

            }else if(postalCode==""){

                    jQuery("#postalCode").parent("div").addClass("has-error");
                    $('#postalCode_error').html("<p class='serror'>Postal Code field is required</p>");

            }else if(ssnLast==""){

                    jQuery("#ssnLast").parent("div").addClass("has-error");
                    $('#ssnLast_error').html("<p class='serror'>Ssn Last  field is required</p>");

            }else{

                var btn = $(this);             
                var url = base_url+"service/stripepayment/addBackAccount/";
                $.ajax({
                  
                    url: url,
                    type: "POST",
                    data:data,    
                    headers: {"authToken": authToken},                      
                    beforeSend: function() {
                        $(btn).buttonLoader('start'); 
                    },  
                    cache: false,
                    success: function(data){
                        $(btn).buttonLoader('stop');
                         if(data.status=="fail"){

                        messageDataAlert(data.message);

                     }else{

                        window.location = base_url + "user/myProfile";

                     }


                    }
                }); 
            }        
    });


   $("#bankPayment").click(function(){
          var firstName = $("#firstName").val();
          var lastName = $("#lastName").val();
          var accountNumber = $("#accountNumber").val();
          var countryCode = $("#countryCode").val();
          var currency = $("#currency").val();
          var routingnumber = $("#routingnumber").val();
          var requestId = $("#requestId").val();
          data = {holderName:firstName,accountNo:accountNumber,country:countryCode,currency:currency,routingNumber:routingnumber,saveDetail:"0",id:requestId};

          jQuery("#firstName").parent("div").removeClass("has-error");
              $('#firstName_error').html("");
          jQuery("#lastName").parent("div").removeClass("has-error");
              $('#lastName_error').html("");
          jQuery("#accountNumber").parent("div").removeClass("has-error");
              $('#accountNumber_error').html("");  
          jQuery("#routingnumber").parent("div").removeClass("has-error");
              $('#routingnumber_error').html("");  
       
  

            if(firstName==""){

                    jQuery("#firstName").parent("div").addClass("has-error");
                    $('#firstName_error').html("<p class='serror'>Holder Name field is required</p>");

            }else if(accountNumber==""){

                    jQuery("#accountNumber").parent("div").addClass("has-error");
                    $('#accountNumber_error').html("<p class='serror'>Account Number field is required</p>");

            }else if(routingnumber==""){

                    jQuery("#routingnumber").parent("div").addClass("has-error");
                    $('#routingnumber_error').html("<p class='serror'>Routing number field is required</p>");

            }else{

                var btn = $(this);             
                var url = base_url+"service/stripepayment/addBackAccount/";
                $.ajax({
                  
                    url: url,
                    type: "POST",
                    data:data,    
                    headers: {"authToken": authToken},                      
                    beforeSend: function() {
                        $(btn).buttonLoader('start'); 
                    },  
                    cache: false,
                    success: function(data){
                        $(btn).buttonLoader('stop');
                         if(data.status=="fail"){

                        messageDataAlert(data.message);

                     }else{

                       window.location = base_url + "transaction/transactionInfo/"+requestId;

                     }


                    }
                }); 
            }        
    });


    $("#cardPayment").click(function(){

          var holderName = $("#holderName").val();
           var cardNumber = $("#cardNumber").val();
          var expiryMonth = $("#expiryMonth").val();
          var expiryYear = $("#expiryYear").val();
          var cvvNumber = $("#cvvNumber").val();
          var requestId = $("#requestId").val();
          data = {holderName:holderName,number:cardNumber,exp_month:expiryMonth,exp_year:expiryYear,cvv:cvvNumber,saveDetail:"0",id:requestId};

          jQuery("#holderName").parent("div").removeClass("has-error");
              $('#holderName_error').html("");
          jQuery("#cardNumber").parent("div").removeClass("has-error");
              $('#cardNumber_error').html("");
          jQuery("#expiryMonth").parent("div").removeClass("has-error");
              $('#expiryMonth_error').html("");
          jQuery("#expiryYear").parent("div").removeClass("has-error");
              $('#expiryYear_error').html("");
          jQuery("#cvvNumber").parent("div").removeClass("has-error");
              $('#cvvNumberr_error').html("");  
        
             

            if(holderName==""){

                    jQuery("#holderName").parent("div").addClass("has-error");
                    $('#holderName_error').html("<p class='serror'>Card holder name field is required</p>");

            }else if(cardNumber==""){

                    jQuery("#cardNumber").parent("div").addClass("has-error");
                    $('#cardNumber_error').html("<p class='serror'>Card number field is required</p>");

            }else if(expiryMonth==""){

                    jQuery("#expiryMonth").parent("div").addClass("has-error");
                    $('#expiryMonth_error').html("<p class='serror'>Expiry month field is required</p>");

            }else if(expiryYear==""){

                    jQuery("#expiryYear").parent("div").addClass("has-error");
                    $('#expiryYear_error').html("<p class='serror'>Expiry year field is required</p>");

            }else if(cvvNumber==""){

                    jQuery("#cvvNumber").parent("div").addClass("has-error");
                    $('#cvvNumberr_error').html("<p class='serror'>Cvv number field is required</p>");

            }else{

                var btn = $(this);             
                var url = base_url+"service/stripepayment/addCardAccount/";
                $.ajax({
                  
                    url: url,
                    type: "POST",
                    data:data,    
                    headers: {"authToken": authToken},                      
                    beforeSend: function() {
                        $(btn).buttonLoader('start'); 
                    },  
                    cache: false,
                    success: function(data){
                        $(btn).buttonLoader('stop');
                     if(data.status=="fail"){

                        messageDataAlert(data.message);

                     }else{

                       window.location = base_url + "transaction/transactionInfo/"+requestId;

                     }
                    

                    }
                }); 
            }        
    });

   / * Message on alert box */
  function messageDataAlert(msg){

     // $("#mainBox").addClass('noScrollBody');
     $('<div></div>').appendTo('body')
        .html('<div class="dialogContent"><h6>'+msg+'</h6></div>')
        .dialog({
            modal: true, title: 'Alert', zIndex: 10000, autoOpen: true,
            width: '400', resizable: false,
           close: function (event, ui) {
                $(this).remove();
            }
      });

  }

  /* End */
  /* File Code End */

