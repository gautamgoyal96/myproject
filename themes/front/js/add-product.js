    $("input[name='condition']").click(function () {
        $('#show-me').css('display', ($(this).val() === 'used') ? 'block':'none');
    });


$(document).ready(function() {
    var text_max1 = 700;
    $('#count1').html(text_max1 + ' characters');

    $('#description').keyup(function() {
        var text_length1 = $('#description').val().length;
        var text_remaining1 = text_max1 - text_length1;

        $('#count1').html(text_remaining1 + ' characters left');
    });
});

$(document).ready(function() {
    var text_max1 = 100;
    $('#count2').html(text_max1 + ' characters');

    $('#title').keyup(function() {
        var text_length1 = $('#title').val().length;
        var text_remaining1 = text_max1 - text_length1;

        $('#count2').html(text_remaining1 + ' characters left');
    });
});

    function initialize() {
        var input = document.getElementById('address');
        new google.maps.places.Autocomplete(input);
    }
    google.maps.event.addDomListener(window, 'load', initialize);


// <!-add product valdation custome start Gk-->


      function addproduct(form){
                  
        var flag=0;
        var fileupload = $.trim(jQuery("#fileupload").val());
        var title = $.trim(jQuery("#title").val());
        var description = $.trim(jQuery("#description").val());
        var address = $.trim(jQuery("#address").val());
        var category = $.trim(jQuery("#category").val());
        var brand = $.trim(jQuery("#brand").val());
        var altField = $.trim(jQuery("#altField").val());
        var price = $.trim(jQuery(".valPrice").val());
        $('#fileupload-err').html(""); 
        jQuery("#title").parent("div").removeClass("has-error");
        $('#title-err').html(""); 
        jQuery("#description").parent("div").removeClass("has-error");
        $('#description-err').html(""); 
        $('#Product-err').html(""); 
        jQuery("#address").parent("div").removeClass("has-error");
        $('#address-err').html(""); 
        jQuery("#category").parent("div").removeClass("has-error");
        $('#category-err').html(""); 
        jQuery("#brand").parent("div").removeClass("has-error");
        $('#brand-err').html(""); 
        $('#productForRental-err').html(""); 
        $('#altField-err').html(""); 
        jQuery("#altField").parent("div").removeClass("has-error");
        $('#price-err').html(""); 
        jQuery(".price_value").parent("div").removeClass("has-error");

        if(fileupload=='' || fileupload==''){
            flag=1;
            $('#fileupload-err').html("<p class='serror'>Please select atleast 1 image</p>");

        }else if(title=='' || title==''){
            flag=1;
            jQuery("#title").parent("div").addClass("has-error");
            $('#title-err').html("<p class='serror'>Title field is required</p>");

        }else if(description=='' || description==''){
            flag=1;
            jQuery("#description").parent("div").addClass("has-error");
            $('#description-err').html("<p class='serror'>Description field is required</p>");

        }else if($('#radio2:checked').length != 0 && $('input[name=productAge]:checked').length==0){

            flag=1;
            $('#Product-err').html("<p class='serror'>Product age field is require</p>");

        }else if(address=='' || address==''){
            flag=1;
            jQuery("#address").parent("div").addClass("has-error");
            $('#address-err').html("<p class='serror'>Address field is required</p>");

        }else if(category=='' || category==''){
            flag=1;
            jQuery("#category").parent("div").addClass("has-error");
            $('#category-err').html("<p class='serror'>Category field is required</p>");

        }else if(brand=='' || brand==''){
            flag=1;
            jQuery("#brand").parent("div").addClass("has-error");
            $('#brand-err').html("<p class='serror'>Brand field is required</p>");

        }else if ( ( $('input[name=productForRental1]:checked').length==0) && ($('input[name=productForRental2]:checked').length==0) && ($('input[name=productForRental3]:checked').length==0 ) && ($('input[name=productForRental4]:checked').length==0) && ($('input[name=productForRental5]:checked').length==0 )) {
              flag=1;
            $('#productForRental-err').html("<p class='serror'>Product for rental is required</p>");

        }else if(price=='' || price==''){
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


// <!-add product Multiple file upload custome end Gk-->



    $(function () {
        $("#fileupload").change(function () {
            var imgLen = document.getElementById('fileupload').files.length;
            if(imgLen > 0 && imgLen <= 3){

                if (typeof (FileReader) != "undefined") {
                    var dvPreview = $("#dvPreview");
                    dvPreview.html("");
                    var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
                    $($(this)[0].files).each(function () {
                        var file = $(this);
                        if (regex.test(file[0].name.toLowerCase())) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                var img = $("<img />");
                                img.attr("style", "height:100px;width: 100px");
                                img.attr("src", e.target.result);
                                dvPreview.append(img);
                            }
                            reader.readAsDataURL(file[0]);
                        } else {
                            alert(file[0].name + " is not a valid image file.");
                            dvPreview.html("");
                            return false;
                        }
                    });
                } else {
                    alert("This browser does not support HTML5 FileReader.");
                }
            }else{
                $('#serror').text('Please select atleast 1 or less than 3 images');
            }
        });
    });


    // <!-add product Multiple file upload custome end Gk-->


    // <!-add product price function upload custome end Gk-->


                      $('#set_price1').hide();
                      $('#adminFees').hide();
                      $('#set_price2').hide();
                      $('#set_price3').hide();
                      $('#set_price4').hide();
                      $('#set_price5').hide();
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
                  $('#adminFees').show();
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

                         $('#set_price'+id).show();
                          $("#label"+id).addClass("actCheckbox");
                          $('#set_price'+id).addClass("valPrice");

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
                  $('#adminFees').show();
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
                         $('#set_price'+id).show();
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
                    $('#adminFees').show();
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

                   $('#adminFees').show();
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
                  
                  $('#adminFees').show();
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

      
        if(emailStatus==0){
                    $('#emailVerify').modal({
         backdrop: 'static'
        });

          window.onload = function () {
                 $("#emailVerify").modal('show');
                  };

        }

        $("#emailVerifyStatus").click(function(){

              window.location = base_url+"user/myProfile/";


        });


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

               if(bankAccountStatus=="no"){
                    $('#bankVerify').modal({
         backdrop: 'static'
        });

          window.onload = function () {
                 $("#bankVerify").modal('show');
                  };

        }

    // <!-add product price function upload custome end Gk-->
