  /* Creater by Developer Gautam Goyal */

      $(".view-availability").click(function(){
        $("#calType").val('0');
        if($("#datePickerRequest").is(":visible")){
          $('#datePickerRequest').slideUp();
          
        }else{
           $('#datePickerRequest').slideDown();
        }

    });


    $(".requestDate1").click(function(){

          var slot = $("#selected_time").val();
          var requestDate = $("#requestDate").val();
           var calType = $("#calType").val();
          jQuery("#selected_time").parent("div").removeClass("has-error");
              $('#rerror').html("");

            if(slot==""){

                    jQuery("#selected_time").parent("div").addClass("has-error");
                    $('#rerror').html("<p class='serror'>Time slot field is required</p>");

            }else{
              
                var url = base_url+"availcalender/";
                $.ajax({
                  
                    url: url,
                    type: "POST",
                    data:{id:productId,slot : slot,"requestDate":requestDate,calType:calType},    
                    beforeSend: function() {
                        $("#requestDate1").addClass("onloadCal"); 
                        $("#requestDate1").removeClass("hasDatepicker");                           
                    },  
                    cache: false,
                    success: function(data){
                      $("#requestDate1").removeClass("onloadCal");
                      $("#requestDate1").addClass("hasDatepicker ");                            
                      $("#modify-datePickerRequest").html(data);
                    if(userType==2){

                      $("#datePickerRequest").html(data);

                    }
                     if($("#datePickerRequest").is(":visible")){
                           $("#datePickerRequest").html(data);
                           $("#modify-datePickerRequest").html("");
                      }

                    }
                }); 
            }        
    });



    function doneData(){

    $("#datePickerRequest").html("");
    $("#modify-datePickerRequest").html("");
    }
    function clearcallendarData(){

      if ($(".cal").hasClass('calendar_active_av')){

      }else{
        
        $("#datePickerRequest").html("");
        $("#modify-datePickerRequest").html("");

      }
      $(".cal").removeClass("calendar_active_av");
      $("#orig-dates").val("");
      $("#requestDate").val("");
      $("#requestDate1").val("");
    }

    $("#selected_time").change(function(){
        jQuery("#selected_time").parent("div").removeClass("has-error");
        $('#rerror').html("");
        var val = this.value;

        if(val != ""){

            if(val == "1" || val=="2" || val=="3"){

                $("#availType").val('1');

            }else if(val == "4"){

                $("#availType").val('2');

            }else if(val == "5"){

                $("#availType").val('3');
            }
        }

        $("#datePickerRequest").html("");
       $("#modify-datePickerRequest").html("");
        $(".cal").removeClass("calendar_active_av");
        $("#orig-dates").val("");
        $("#requestDate").val("");
        $("#requestDate1").val("");


    });


    /* End */

     /* Price Table show hide */

   $("#viewPrice").click(function(){

        $('#showHrTbl').slideToggle();
    });


    /* Book Product Function Start*/

    $(".request-send").click(function(){

       var requestType = this.value;
       var availType = $("#availType").val();
       var slot = $("#selected_time").val();
      var requestDate = $("#requestDate").val();
      var requestEndDate = $("#requestEndDate").val();
        jQuery("#selected_time").parent("div").removeClass("has-error");
        $('#rerror').html("");
        jQuery("#requestDate1").parent("div").removeClass("has-error");
        $('#serror').html("");

        if(slot==""){

                jQuery("#selected_time").parent("div").addClass("has-error");
                $('#rerror').html("<p class='serror'>Time slot field is required</p>");

        }else if(requestDate==""){

                jQuery("#requestDate1").parent("div").addClass("has-error");
                $('#serror').html("<p class='serror'>Rental date field is required</p>");

        }else{
              var btn = $(this);
              var url = base_url+"products/bookProduct/";
                $.ajax({
                  
                    url: url,
                    type: "POST",
                    data:{id:productId,slot : slot,requestDate:requestDate,requestEndDate:requestEndDate,ownerId:ownerId,availType:availType,requestType:requestType,price:price},      
                    cache: false,
                    beforeSend: function() {
                        $(btn).buttonLoader('start');                               
                    },
                    success: function(data){
                       $(btn).buttonLoader('stop');
                      window.location.reload();

                    }
                }); 


        }

    });

    /* End */

    /* Login  Function Start*/

    $(document).on("click", ".logbkNow", function(){
       
        $('#loginFirst').modal('show'); 
    });
    /* End */


    /* Login  Function Start*/

    $(document).on("click", ".chatFirst", function(){
       
        $('#loginchatFirst').modal('show'); 
    });
    /* End */


    /* Request Update Function Start*/

    $(".request-update").click(function(){
       var requestStatus = this.value;
       var requestid = $(this).data('requestid'); 
       var btn = $(this);
       var url = base_url+"products/requestUpdate/";
        $.ajax({
          
            url: url,
            type: "POST",
            data:{id:productId,requestid:requestid,requestStatus:requestStatus},      
            cache: false,
            beforeSend: function() {
              $(btn).buttonLoader('start');                               
            },
            success: function(data){
               $(btn).buttonLoader('stop');
              window.location.reload();

            }
        }); 

    });
      /* End */
   $("#rq-modifiy").click(function(){

        $("#calType").val('1');
       var requestid =  $(this).data("requestid");
       var bookstartdate =  $(this).data("bookstartdate");
       var bookenddate =  $(this).data("bookenddate");
       var availtype =  $(this).data("availtype");
       var productrorrental =  $(this).data("productrorrental");
       if(productrorrental==1){
        jQuery("#time2").attr('checked', true);

       }else if(productrorrental==2){
        jQuery("#time3").attr('checked', true);
       }else if(productrorrental==3){
        jQuery("#time4").attr('checked', true);
       }else if(productrorrental==4){
        jQuery("#time5").attr('checked', true);
       }else if(productrorrental==5){
        jQuery("#time6").attr('checked', true);
       }
       var bookAllDate =  $(this).data("bookalldate");
       var price =  $(this).data("price");
       $("#price") .val(price);
/*       $("#requestEndDate").val(bookenddate);
*/       $("#requestDate").val(bookstartdate);
       $("#selected_time").val(productrorrental);
       $("#availType").val(availtype);
       $("#requestDate1").val(bookAllDate);
        $("#requestid").val(requestid);


   });

    $(".selected_time").change(function(){

        var val = this.value;

        if(val != ""){

            if(val == "1" || val=="2" || val=="3"){

                $("#availType").val('1');

            }else if(val == "4"){

                $("#availType").val('2');

            }else if(val == "5"){

                $("#availType").val('3');
            }
        }

        $("#selected_time").val(val);
        $("#datePickerRequest").html("");
       $("#modify-datePickerRequest").html("");
        $(".cal").removeClass("calendar_active_av");
        $("#orig-dates").val("");
        $("#requestDate").val("");
        $("#requestDate1").val("");


    });

    $(".view-modify-availability").click(function(){
        if($("#modify-datePickerRequest").is(":visible")){

          $('#modify-datePickerRequest').slideUp();
          
        }else{
           $('#modify-datePickerRequest').slideDown();
        }

    });

    $("#request-modifiy-update").click(function(){

        var price = $("#price").val();
        var requestid = $("#requestid").val();
        var slot = $("#selected_time").val();
        var availType = $("#availType").val();
        var requestEndDate = $("#requestEndDate").val();
        var requestDate = $("#requestDate").val();
          jQuery("#selected_time").parent("div").removeClass("has-error");
          $('#rerror').html("");
          jQuery("#price-error").parent("div").removeClass("has-error");
          $('#price-error').html("");

          if(price==""){

                  jQuery("#price-error").parent("div").addClass("has-error");
                  $('#price-error').html("<p class='serror'>Price field is required</p>");

          }else if(requestDate==""){

                  jQuery("#requestDate1").parent("div").addClass("has-error");
                  $('#serror').html("<p class='serror'>Rental date field is required</p>");

          }else{
                var btn = $(this);
                var url = base_url+"products/requestUpdate/";
                  $.ajax({
                    
                      url: url,
                      type: "POST",
                      data:{id:productId,requestid : requestid,requestDate:requestDate,requestEndDate:requestEndDate,availType:availType,price:price,slot:slot,requestStatus:"modify"},      
                      cache: false,
                      beforeSend: function() {
                          $(btn).buttonLoader('start');                               
                      },
                      success: function(data){
                         $(btn).buttonLoader('stop');
                         $(window).scrollTop(0);
                         window.location.reload();

                      }
                  }); 


          }

    });

     $("#view-modification").click(function(){

        $("#calType").val('1');
       var requestid =  $(this).data("requestid");
       var bookstartdate =  $(this).data("bookstartdate");
       var bookenddate =  $(this).data("bookenddate");
       var availtype =  $(this).data("availtype");
       var productrorrental =  $(this).data("productrorrental");
       if(productrorrental==1){
        productrorrental = "8 Hour";

       }else if(productrorrental==2){

         productrorrental = "12 Hour";

       }else if(productrorrental==3){
        
         productrorrental = "24 Hour";

       }else if(productrorrental==4){
       
        productrorrental = "1 Week";

       }else if(productrorrental==5){
        
         productrorrental = "1 Month";

       }
       
       var bookAllDate =  $(this).data("bookalldate");
       var price =  "$ "+$(this).data("price");
       $("#modify-price") .html(price);
       $("#requestEndDate").val(bookenddate);
       $("#requestDate").val(bookstartdate);
       $("#modify-slot").html(productrorrental);
       $("#availType").val(availtype);
       $("#modify-date").html(bookAllDate);
        $("#mrequestid").val(requestid);


   });

   $(".modify-update").click(function(){

       var requestStatus = "modify";
        var modifyStatus = this.value;
       var requestid = $("#mrequestid").val(); 
       var btn = $(this);
       var url = base_url+"products/requestUpdate/";
        $.ajax({
          
            url: url,
            type: "POST",
            data:{id:productId,requestid:requestid,requestStatus:requestStatus,modifyStatus:modifyStatus},      
            cache: false,
            beforeSend: function() {
              $(btn).buttonLoader('start');                               
            },
            success: function(data){
               $(btn).buttonLoader('stop');
               window.location.reload();

            }
        }); 

    });

        if(userTypeCheckStatus==1){
                  

          window.onload = function () {

                   $('#userTypeCheckStatus').modal({  backdrop: 'static'});
          };

        }


        $(".finishRental").click(function(){
       var requestid = this.value;
       var btn = $(this);
       var url = base_url+"products/requestUpdate/";
       var requestStatus = "complete"
        var finishstatus =  $("#finishStatus").val();
        $.ajax({
          
            url: url,
            type: "POST",
            data:{id:productId,requestid:requestid,requestStatus:requestStatus,finishstatus:finishstatus},      
            cache: false,
            beforeSend: function() {
              $(btn).buttonLoader('start');                               
            },
            success: function(data){
               $(btn).buttonLoader('stop');
                window.location.reload();

            }
        }); 

    });


    $(".finishStatus").click(function(){

      var rId = this.value;

      var status = $(this).data('finishstatus');
      $(".finishRental").val(rId);
      $("#finishStatus").val(status);

    });

       $(".fenish-request-update").click(function(){

                  var finishstatus =  this.value;

                   var requestid =  $(this).data('requestid');
                   var btn = $(this);


                  if(finishstatus=="accept"){

                      var msg = "Are you sure want to accept this finish request ?";

                  }else{

                    var msg = "Are you sure want to reject this finish request ?";
                  }

                  $("#mainBox").addClass('noScrollBody');

                 $('<div></div>').appendTo('body')
                          .html('<div class="dialogContent"><h6>'+msg+'</h6></div>')
                          .dialog({
                              modal: true, title: 'Alert', zIndex: 10000, autoOpen: true,
                              width: 'auto', resizable: false,
                              buttons: {
                                  Yes: function () {

                                           var url = base_url+"products/requestUpdate/";
                                           var requestStatus = "complete"
                                            $.ajax({
                                              
                                                url: url,
                                                type: "POST",
                                                data:{id:productId,requestid:requestid,requestStatus:requestStatus,finishstatus:finishstatus,type:"1"},      
                                                cache: false,
                                                beforeSend: function() {
                                                  $(btn).buttonLoader('start');                               
                                                },
                                                success: function(data){
                                                   $(btn).buttonLoader('stop');
                                               window.location.reload();

                                                }
                                            }); 

                                   },
                                      No: function () {
                                          $(this).dialog("close");
                                      }
                                  },
                                  close: function (event, ui) {
                                     $("#cal"+i).html(i);
                                      $(this).remove();
                                  }
                            });

    });

    $(".send-invoice").click(function(){

          var rId = this.value;

          var bookstartdate = $(this).data('bookstartdate');
          var bookenddate = $(this).data('bookenddate');
          var extrapay = $(this).data('extrapay');
          var price = $(this).data('price');
          var myProductForRental = $(this).data("myproductforrental");
          $("#rFrom").html(bookstartdate);
          $("#rTo").html(bookenddate);
           $("#fprice").html("$ "+price);
           var total = price;
           if(extrapay!=""){
           var total = parseInt(price)+parseInt(extrapay);
           }
            $("#totalPrice").html("$ "+total);
             $("#sFor").html(myProductForRental);
            $("#f-price-hidden").val(price);
            $("#extra-payment").val(extrapay);
            $(".payRequestID").val(rId);
         

    });

    $("#extra-payment").keyup(function(){

      var extra = this.value;
        if(extra == ""){

          var  price = $("#f-price-hidden").val();
          $("#totalPrice").html("$ "+price);

        }else{

          var  price = $("#f-price-hidden").val();
          var total = parseInt(price)+parseInt(extra);
          $("#totalPrice").html("$ "+total);
        }

    });



    $(".sendInvoice").click(function(){

       var requestid = this.value;
       var btn = $(this);
       var url = base_url+"products/requestUpdate/";
       var requestStatus = "complete"
       var finishstatus =  "sendInvoice";
        var extrapayment = $("#extra-payment").val();
        $.ajax({
          
            url: url,
            type: "POST",
            data:{id:productId,requestid:requestid,requestStatus:requestStatus,finishstatus:finishstatus,extrapayment:extrapayment},      
            cache: false,
            beforeSend: function() {
              $(btn).buttonLoader('start');                               
            },
            success: function(data){
               $(btn).buttonLoader('stop');
               window.location.reload();

            }
        }); 

    });

     $(".paynow").click(function(){

       var requestid = this.value;
       var btn = $(this);
       $(btn).buttonLoader('start');                               
        window.location = base_url+"payment/index/"+requestid;


    });

  function isNumberKey3(evt) {
        alert(evt.which);

    var charCode = (evt.which) ? evt.which : event.keyCode;

        if (charCode > 31
            && (charCode < 48 || charCode > 57)){
            return false;
        }
    return true;

  }

    $(".send-invoice").click(function(){

          var rId = this.value;

          var bookstartdate = $(this).data('bookstartdate');
          var bookenddate = $(this).data('bookenddate');
          var extrapay = $(this).data('extrapay');
          var price = $(this).data('price');
          var myProductForRental = $(this).data("myproductforrental");
          $("#rFrom").html(bookstartdate);
          $("#rTo").html(bookenddate);
           $("#fprice").html("$ "+price);
           var total = price;
           if(extrapay!=""){
           var total = parseInt(price)+parseInt(extrapay);
           }
            $("#totalPrice").html("$ "+total);
             $("#sFor").html(myProductForRental);
             $("#extra-payment").html("$ "+extrapay);
             if(extrapay==""){
                $("#extra-data").hide();
             }
            $("#f-price-hidden").val(price);
            $("#extra-payment").val(extrapay);
            $(".payRequestID").val(rId);
         

    });


       $(".review-submit").click(function(){
       var requestID = this.value;
       var rate_value = $("#rate_value").val();
       var review = $("#review").val();
        $('#rate_error').html("");
        $('#review_error').html("");
        if(rate_value==""){

                $('#rate_error').html("<p class='serror'>Rating is required</p>");

        }else if(review==""){

                $('#review_error').html("<p class='serror'>Review is required</p>");

        }else{
              var btn = $(this);
              var url = base_url+"products/postRatingReview/";
                $.ajax({
                  
                    url: url,
                    type: "POST",
                    data:{productId:productId,stars : rate_value,comment:review,receiveById:ownerId,requestId:requestID},      
                    cache: false,
                    beforeSend: function() {
                        $(btn).buttonLoader('start');                               
                    },
                    success: function(data){
                       $(btn).buttonLoader('stop');
                     window.location.reload();

                    }
                }); 


        }

    });



  /* File Code End */

