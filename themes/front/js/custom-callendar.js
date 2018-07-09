  /* Creater by Developer Gautam Goyal */

  /* Month Change on callender */
  function monthChange(month,year){

      var requestDate = $("#requestDate").val();
      var calType = $("#calType").val();
      var MONTH = (month < 10 ? '0' + month : month);
          $.ajax({
          url: base_url+'availcalender/',
          type:'get',
          data:'month='+MONTH+'&year='+year+'&requestDate='+requestDate+"&slot="+slot+"&calType="+calType+"&pId="+pId,
          beforeSend: function() {

              $("#requestDate1").addClass("onloadCal"); 
              $("#requestDate1").removeClass("hasDatepicker"); 

          },  
            success:function(calresp){

               $("#requestDate1").removeClass("onloadCal");
               $("#requestDate1").addClass("hasDatepicker ");

            $("#modify-datePickerRequest").html(calresp);

            if($("#datePickerRequest").is(":visible")){

                   $("#datePickerRequest").html(calresp);                   
                   $("#modify-datePickerRequest").html("");
            }


            }

      });

  }

  /* End */

  /* Callendar All Function */               
    function my(i) {

        var a = $("#cal"+i).data("id");

        var currentDate = $.datepicker.formatDate('yy-mm-dd', new Date());
        if(jQuery.type(a)=="undefined"){


        }else if(currentDate>a){

            messageAlert("You can not select previous date");

        }else if ($("#cal"+i).hasClass('calendar_active') && slot !=""){

            messageAlert("Please select another date");


        } else{

          if(slot==""){

             
                if ($("#cal"+i).hasClass('calendar_active')){

                    $("#cal"+i).removeClass("calendar_active");
                  var old = $("#requestDate").val();
                  var res = old.split(",");
                  var _searchedIndex = $.inArray(a,res);
                  
                   if(_searchedIndex >= 0){
                     res.splice(_searchedIndex,1);
                    $("#requestDate").val(res);
                  }


                }else{

                var old = $("#requestDate").val();
                newData = a;
                if(old!=""){

                  var newData = old+","+a;

                }

                $("#requestDate").val(newData);
                 $("#cal"+i).addClass("calendar_active");


                } 

               
                var cD = $.datepicker.formatDate('dmm', new Date());
                if($("#cal"+cD).hasClass('calendar_active')){
                  $("#cal"+cD).removeClass("calendar_today");
                  $("#cal"+cD).addClass("calendar_days");

                }else if($("#cal"+cD).hasClass('calendar_active_av')){
                  $("#cal"+cD).removeClass("calendar_today");
                  $("#cal"+cD).addClass("calendar_days");

                } else {
                    $("#cal"+cD).addClass("calendar_today");
                    $("#cal"+cD).removeClass("calendar_days");

                }   


          }else if(slot==1 || slot==2 || slot==3){

                var preDate = $("#orig-dates").val();

                if(preDate){

                    $("#cal"+preDate).removeClass("calendar_active_av");

                }

                $("#requestDate").val(a);
                $("#requestDate1").val(a);
                $("#orig-dates").val(i);
                $("#cal"+i).addClass("calendar_active_av");

               
                var cD = $.datepicker.formatDate('dmm', new Date());
                if ($("#cal"+cD).hasClass('calendar_active')){
                    $("#cal"+cD).removeClass("calendar_today");
                    $("#cal"+cD).addClass("calendar_days");

                }else if($("#cal"+cD).hasClass('calendar_active_av')){
                  $("#cal"+cD).removeClass("calendar_today");
                    $("#cal"+cD).addClass("calendar_days");

                }else {
                    $("#cal"+cD).addClass("calendar_today");
                    $("#cal"+cD).removeClass("calendar_days");

                }  


                                  


            }else if(slot==4){

                  var preDate = $("#orig-dates").val();
                  var cD = $.datepicker.formatDate('ddmm', new Date());
                  if(preDate){

                      for (var i = 0; i < 7; i++) {

                          var date = new Date(preDate);
                          date.setDate(date.getDate() + i);
                          var m = (date.getMonth()+1);
                          var MONTH = (m < 10 ? '0' + m : m);
                          var dateMsg = date.getFullYear()+"/"+ MONTH + "/" + date.getDate();

                          $("#cal"+date.getDate()+MONTH).removeClass("calendar_active_av");

                      }


                  }
                  $("#requestDate").val(a);
                  var date = new Date(a);
                  date.setDate(date.getDate() + 6);
                  var m = (date.getMonth()+1);
                  var MONTH = (m < 10 ? '0' + m : m);
                  var lastDate = date.getFullYear()+"-"+ MONTH + "-" + date.getDate();

                  $("#requestDate1").val(a+" to "+ lastDate);
                  $("#requestEndDate").val(lastDate);
                  $("#orig-dates").val(a);

                  for (var i = 0; i < 7; i++) {

                      var date = new Date(a);
                      date.setDate(date.getDate() + i);
                      var m = (date.getMonth()+1);
                      var MONTH = (m < 10 ? '0' + m : m);
                      var dateMsg = date.getFullYear()+"/"+ MONTH + "/" + date.getDate();
                      $("#cal"+date.getDate()+MONTH).addClass("calendar_active_av");

                       var d = date.getDate();
                      var DAY = (d < 10 ? '0' + d : d);
                      var dateCheck = date.getFullYear()+"-"+ MONTH + "-" + DAY;
                      var myData =  checkdate(dateCheck);
                      if(myData==1){
                        messageAlert("Please select another date");
                        $("#requestDate1").val("");
                        $("#orig-dates").val("");
                        $("#requestDate").val(""); 
                        $("#requestEndDate").val(""); 
                        $("#orig-dates").val("");  
                        $(".cal").removeClass("calendar_active_av");
                        break;
                      }
                      if ($("#cal"+date.getDate()+MONTH).hasClass('calendar_active')){
                          $(".cal").removeClass("calendar_active_av");
                          $("#requestDate1").val("");
                          $("#orig-dates").val("");
                          $("#requestDate").val("");                  
                          messageAlert("Please select another date");
                          break; 

                      }

                  } 
                  if ($("#cal"+cD).hasClass('calendar_active_av')){

                      $("#cal"+cD).removeClass("calendar_today");
                      $("#cal"+cD).addClass("calendar_days");

                  }else if($("#cal"+cD).hasClass('calendar_active')){
                       $("#cal"+cD).removeClass("calendar_today");
                      $("#cal"+cD).addClass("calendar_days");
                  
                  } else {

                      $("#cal"+cD).addClass("calendar_today");
                      $("#cal"+cD).removeClass("calendar_days");
                  }               


            }else if(slot==5){


                  var preDate = $("#orig-dates").val();
                  var cD = $.datepicker.formatDate('ddmm', new Date());
                  if(preDate){

                      for (var i = 0; i < 30; i++) {

                          var date = new Date(preDate);
                          date.setDate(date.getDate() + i);
                          var m = (date.getMonth()+1);
                          var MONTH = (m < 10 ? '0' + m : m);
                          var dateMsg = date.getFullYear()+"/"+ MONTH + "/" + date.getDate();
                          $("#cal"+date.getDate()+MONTH).removeClass("calendar_active_av");

                      }


                  }
                  var date = new Date(a);
                  date.setDate(date.getDate() + 29);
                  var m = (date.getMonth()+1);
                  var MONTH = (m < 10 ? '0' + m : m);
                  var lastDate = date.getFullYear()+"-"+ MONTH + "-" + date.getDate();
                  $("#requestDate1").val(a+" to "+ lastDate);
                  $("#requestEndDate").val(lastDate);
                  $("#requestDate").val(a);
                  $("#orig-dates").val(a);

                  for (var i = 0; i < 30; i++) {

                      var date = new Date(a);
                      date.setDate(date.getDate() + i);
                      var m = (date.getMonth()+1);
                      var MONTH = (m < 10 ? '0' + m : m);
                      var dateMsg = date.getFullYear()+"/"+ MONTH + "/" + date.getDate();
                      $("#cal"+date.getDate()+MONTH).addClass("calendar_active_av");
                      var d = date.getDate();
                      var DAY = (d < 10 ? '0' + d : d);
                      var dateCheck = date.getFullYear()+"-"+ MONTH + "-" + DAY;
                      var myData =  checkdate(dateCheck);
                      if(myData==1){

                        messageAlert("Please select another date");
                        $("#requestDate1").val("");
                        $("#orig-dates").val("");
                        $("#requestDate").val(""); 
                        $("#requestEndDate").val(""); 
                        $("#orig-dates").val("");  
                        $(".cal").removeClass("calendar_active_av");
                        break;
                      }
                      if ($("#cal"+date.getDate()+MONTH).hasClass('calendar_active')){

                          $(".cal").removeClass("calendar_active_av");
                          messageAlert("Please select another date");
                          $("#requestDate1").val("");
                          $("#orig-dates").val("");
                          $("#requestDate").val("");
                          break; 


                      }

                  } 

                  if ($("#cal"+cD).hasClass('calendar_active_av')){

                      $("#cal"+cD).removeClass("calendar_today");
                      $("#cal"+cD).addClass("calendar_days");

                  }else if($("#cal"+cD).hasClass('calendar_active')){
                  
                  } else {

                      $("#cal"+cD).addClass("calendar_today");
                      $("#cal"+cD).removeClass("calendar_days");
                      
                  }  


            }

        }

    }

   /* End */     

   function checkdate(dateMsg){

     var url = base_url+"availcalender/checkDate/";
      $.ajax({
        
          url: url,
          type: "POST",
          data:{date:dateMsg},      
          cache: false,
          success: function(data){
             $("#errorValue").val("0");
             if(data==1){
                $("#errorValue").val(data);
                 $(".cal").removeClass("calendar_active_av");
                  $("#requestDate1").val("");
                  $("#orig-dates").val("");
                  $("#requestDate").val(""); 
                  $("#requestEndDate").val(""); 
                  $("#orig-dates").val("");                 

             }

          }
      }); 

      return  $("#errorValue").val();
                  
   }      

 /* Message on alert box */
  function messageAlert(msg){

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