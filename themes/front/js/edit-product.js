
// <!-add product valdation custome start Gk-->


      function editproduct(form){
                  
        var flag=0;
        var fileupload = $.trim(jQuery("#fileupload").val());
        var title = $.trim(jQuery("#title").val());
        var description = $.trim(jQuery("#description").val());
        var address = $.trim(jQuery("#address").val());
        var category = $.trim(jQuery("#category").val());
        var brand = $.trim(jQuery("#brand").val());
        var altField = $.trim(jQuery("#altField").val());
        var price = $.trim(jQuery(".valPrice").val());
        $('#productForRental-err').html(""); 
        $('#altField-err').html(""); 
        jQuery("#altField").parent("div").removeClass("has-error");
        $('#price-err').html(""); 
        jQuery(".price_value").parent("div").removeClass("has-error");

      /*  if ( ( $('input[name=productForRental1]:checked').length==0) && ($('input[name=productForRental2]:checked').length==0) && ($('input[name=productForRental3]:checked').length==0 ) && ($('input[name=productForRental4]:checked').length==0) && ($('input[name=productForRental5]:checked').length==0 )) {
              flag=1;
            $('#productForRental-err').html("<p class='serror'>Product for rental is required</p>");

        }else*/ if(price=='' || price==''){
            flag=1;
            jQuery(".price_value").parent("div").addClass("has-error");
            $('#price-err').html("<p class='serror'>Total Price field is required</p>");

        }


        if(flag){

            //$(window).scrollTop(0);

            return false ;


        }else{

            return true;

        }
    }


// <!-add product valdation custome end Gk-->


    // <!-add product price function upload custome end Gk-->


    function showTimeVal8(id){
                      $('#set_price1').removeClass("valPrice");
                      $('#set_price2').removeClass("valPrice");
                      $('#set_price3').removeClass("valPrice");
                      $('#set_price4').removeClass("valPrice");
                      $('#set_price5').removeClass("valPrice");
                  var set_price1 = $('#set_price1').val();
                  var set_price2 = $('#set_price2').val();
                  var set_price3 = $('#set_price3').val();
                  var set_price4 = $('#set_price4').val();
                  var set_price5 = $('#set_price5').val();
                
                   if(set_price2==""){

                    $('#time2').attr('checked', false); // Unchecks it
                    $('#label2').removeClass("actCheckbox");
                    $('#set_price2').removeClass("valPrice");

                  }
                   if(set_price3==""){

                    $('#time3').attr('checked', false); // Unchecks it
                    $('#label3').removeClass("actCheckbox");
                    $('#set_price3').removeClass("valPrice");

                  }
                   if(set_price4==""){

                    $('#time4').attr('checked', false); // Unchecks it
                    $('#label4').removeClass("actCheckbox");
                    $('#set_price4').removeClass("valPrice");

                  }
                   if(set_price5==""){

                    $('#time5').attr('checked', false); // Unchecks it
                    $('#label5').removeClass("actCheckbox");
                    $('#set_price5').removeClass("valPrice");
                  }

                      $('#set_price1').hide();
                      $('#set_price2').hide();
                      $('#set_price3').hide();
                      $('#set_price4').hide();
                      $('#set_price5').hide();

                      $("#productForRental-error").html("");
                      if($("#time"+id).is(":checked")==true){
                         $('#set_price'+id).hide();
                         $('#set_price'+id).removeClass("valPrice");
                          $('#set_price'+id).show();
                          $('#set_price'+id).addClass("valPrice");
                          $("#label"+id).addClass("actCheckbox");

                         if(set_price1){

                            $("#time"+id).attr('checked', true); // Unchecks it
                             $('#set_price'+id).show();
                             $('#set_price'+id).addClass("valPrice");
                             $("#label"+id).addClass("actCheckbox");

                        }


                      }else{


                       $('#set_price'+id).show();
                       $('#set_price'+id).addClass("valPrice");


                         
                      }
                  }
                   function showTimeVal12(id){

                  var set_price1 = $('#set_price1').val();
                  var set_price2 = $('#set_price2').val();
                  var set_price3 = $('#set_price3').val();
                  var set_price4 = $('#set_price4').val();
                  var set_price5 = $('#set_price5').val();
                  if(set_price1==""){

                    $('#time1').attr('checked', false); // Unchecks it
                    $('#label1').removeClass("actCheckbox");
                    $('#set_price1').removeClass("valPrice");

                  }
               
                   if(set_price3==""){

                    $('#time3').attr('checked', false); // Unchecks it
                    $('#label3').removeClass("actCheckbox");
                    $('#set_price3').removeClass("valPrice");

                  }
                   if(set_price4==""){

                    $('#time4').attr('checked', false); // Unchecks it
                    $('#label4').removeClass("actCheckbox");
                    $('#set_price4').removeClass("valPrice");

                  }
                   if(set_price5==""){

                    $('#time5').attr('checked', false); // Unchecks it
                    $('#label5').removeClass("actCheckbox");
                    $('#set_price5').removeClass("valPrice");

                  }

                     $('#set_price1').hide();
                      $('#set_price2').hide();
                      $('#set_price3').hide();
                      $('#set_price4').hide();
                      $('#set_price5').hide();
                      $('#set_price1').removeClass("valPrice");
                      $('#set_price2').removeClass("valPrice");
                      $('#set_price3').removeClass("valPrice");
                      $('#set_price4').removeClass("valPrice");
                      $('#set_price5').removeClass("valPrice");

                      $("#productForRental-error").html("");
                      if($("#time"+id).is(":checked")==true){

                         /* $('#set_price'+id).hide();
                          $('#set_price'+id).removeClass("valPrice");
                           */$('#set_price'+id).show();
                            $("#label"+id).addClass("actCheckbox");
                            $('#set_price'+id).addClass("valPrice");

                         if(set_price2){

                            $("#time"+id).attr('checked', true); // Unchecks it
                            $('#set_price'+id).show();
                            $("#label"+id).addClass("actCheckbox");
                            $('#set_price'+id).addClass("valPrice");



                        }


                      }else{

                          $('#set_price'+id).show();
                          $('#set_price'+id).addClass("valPrice");
                         
                      }
                  }
                   function showTimeVal24(id){

                     var set_price1 = $('#set_price1').val();
                  var set_price2 = $('#set_price2').val();
                  var set_price3 = $('#set_price3').val();
                  var set_price4 = $('#set_price4').val();
                  var set_price5 = $('#set_price5').val();
                  if(set_price1==""){

                    $('#time1').attr('checked', false); // Unchecks it
                    $('#label1').removeClass("actCheckbox");
                    $('#set_price1').removeClass("valPrice");

                  }
                   if(set_price2==""){

                    $('#time2').attr('checked', false); // Unchecks it
                    $('#label2').removeClass("actCheckbox");
                    $('#set_price2').removeClass("valPrice");

                  }
        
                   if(set_price4==""){

                    $('#time4').attr('checked', false); // Unchecks it
                    $('#label4').removeClass("actCheckbox");
                    $('#set_price4').removeClass("valPrice");

                  }
                   if(set_price5==""){

                    $('#time5').attr('checked', false); // Unchecks it
                    $('#label5').removeClass("actCheckbox");
                    $('#set_price5').removeClass("valPrice");

                  }

                     $('#set_price1').hide();
                      $('#set_price2').hide();
                      $('#set_price3').hide();
                      $('#set_price4').hide();
                      $('#set_price5').hide();
                        $('#set_price1').removeClass("valPrice");
                      $('#set_price2').removeClass("valPrice");
                      $('#set_price3').removeClass("valPrice");
                      $('#set_price4').removeClass("valPrice");
                      $('#set_price5').removeClass("valPrice");
                      $("#productForRental-error").html("");
                      if($("#time"+id).is(":checked")==true){
                          $('#set_price'+id).show();
                            $("#label"+id).addClass("actCheckbox");
                            $('#set_price'+id).addClass("valPrice");

                           if(set_price3){

                            $("#time"+id).attr('checked', true); // Unchecks it
                             $('#set_price'+id).show();
                             $("#label"+id).addClass("actCheckbox");
                              $('#set_price'+id).addClass("valPrice");




                          }

                      }else{
                          $('#set_price'+id).show();
                          $('#set_price'+id).addClass("valPrice");

                         
                      }
                  }
                   function showTimeVal1week(id){

                     var set_price1 = $('#set_price1').val();
                  var set_price2 = $('#set_price2').val();
                  var set_price3 = $('#set_price3').val();
                  var set_price4 = $('#set_price4').val();
                  var set_price5 = $('#set_price5').val();
                  if(set_price1==""){

                    $('#time1').attr('checked', false); // Unchecks it
                    $('#label1').removeClass("actCheckbox");
                    $('#set_price1').removeClass("valPrice");

                  }
                   if(set_price2==""){

                    $('#time2').attr('checked', false); // Unchecks it
                    $('#label2').removeClass("actCheckbox");
                    $('#set_price2').removeClass("valPrice");
                  }
                   if(set_price3==""){

                    $('#time3').attr('checked', false); // Unchecks it
                    $('#label3').removeClass("actCheckbox");
                    $('#set_price3').removeClass("valPrice");

                  }
           
                   if(set_price5==""){

                    $('#time5').attr('checked', false); // Unchecks it
                    $('#label5').removeClass("actCheckbox");
                    $('#set_price5').removeClass("valPrice");

                  }

                     $('#set_price1').hide();
                      $('#set_price2').hide();
                      $('#set_price3').hide();
                      $('#set_price4').hide();
                      $('#set_price5').hide();
                        $('#set_price1').removeClass("valPrice");
                      $('#set_price2').removeClass("valPrice");
                      $('#set_price3').removeClass("valPrice");
                      $('#set_price4').removeClass("valPrice");
                      $('#set_price5').removeClass("valPrice");
                      $("#productForRental-error").html("");
                      if($("#time"+id).is(":checked")==true){
                          $('#set_price'+id).show();
                            $("#label"+id).addClass("actCheckbox");
                            $('#set_price'+id).addClass("valPrice");

                            if(set_price4){

                            $("#time"+id).attr('checked', true); // Unchecks it
                             $('#set_price'+id).show();
                            $("#label"+id).addClass("actCheckbox");
                            $('#set_price'+id).addClass("valPrice");



                          }

                      }else{
                          $('#set_price'+id).show();
                          $('#set_price'+id).addClass("valPrice");

                         
                      }
                  }
                  function showTimeVal1month(id){

                     var set_price1 = $('#set_price1').val();
                  var set_price2 = $('#set_price2').val();
                  var set_price3 = $('#set_price3').val();
                  var set_price4 = $('#set_price4').val();
                  var set_price5 = $('#set_price5').val();

                  if(set_price1==""){

                    $('#time1').attr('checked', false); // Unchecks it
                    $('#label1').removeClass("actCheckbox");
                    $('#set_price1').removeClass("valPrice");


                  }
                   if(set_price2==""){

                    $('#time2').attr('checked', false); // Unchecks it
                    $('#label2').removeClass("actCheckbox");
                    $('#set_price1').removeClass("valPrice");

                  }
                   if(set_price3==""){

                    $('#time3').attr('checked', false); // Unchecks it
                    $('#label3').removeClass("actCheckbox");
                    $('#set_price3').removeClass("valPrice");

                  }
                   if(set_price4==""){

                    $('#time4').attr('checked', false); // Unchecks it
                    $('#label4').removeClass("actCheckbox");
                    $('#set_price4').removeClass("valPrice");

                  }
              

                     $('#set_price1').hide();
                      $('#set_price2').hide();
                      $('#set_price3').hide();
                      $('#set_price4').hide();
                      $('#set_price5').hide();
                        $('#set_price1').removeClass("valPrice");
                      $('#set_price2').removeClass("valPrice");
                      $('#set_price3').removeClass("valPrice");
                      $('#set_price4').removeClass("valPrice");
                      $('#set_price5').removeClass("valPrice");
                      $("#productForRental-error").html("");
                      if($("#time"+id).is(":checked")==true){
                          $('#set_price'+id).show();
                            $("#label"+id).addClass("actCheckbox");
                            $('#set_price'+id).addClass("valPrice");

                            if(set_price5){

                             $("#time"+id).attr('checked', true); // Unchecks it
                             $('#set_price'+id).show();
                             $("#label"+id).addClass("actCheckbox");
                             $('#set_price'+id).addClass("valPrice");



                          }

                      }else{
                          $('#set_price'+id).show();
                          $('#set_price'+id).addClass("valPrice");

                         
                      }
                  }

       window.onload = function () {

            var url = base_url+"availcalender/";
            var requestDate = $("#requestDate").val();
            $.ajax({
              
                url: url,
                type: "POST",
                data:{calType:"1",requestDate:requestDate},    
                beforeSend: function() {
                    $("#requestDate1").addClass("onloadCal"); 
                    $("#requestDate1").removeClass("hasDatepicker");                           
                },  
                cache: false,
                success: function(data){
                  $("#requestDate1").removeClass("onloadCal");
                  $("#requestDate1").addClass("hasDatepicker ");                            
                 $("#datePickerRequest").html(data);

                }
            }); 

      }    

  $('#datePickerRequest').hide();

           $("#availability").click(function(){
              if($("#datePickerRequest").is(":visible")){
                $('#datePickerRequest').slideUp();
                
              }else{
                 $('#datePickerRequest').slideDown();
              }

           });  

    // <!-edit product price function upload custome end Gk-->
