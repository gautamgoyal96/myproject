  /* Creater by Developer Gautam Goyal */

   function ajax_fun(url)
    { 
       alert('aaa');
        $.ajax({
            url: url,
            type: "POST",
            data:{address:address,categoryId:categoryId},          
            cache: false,
            beforeSend: function() {
                $("#ajaxdata").html("<img id='zlodaer' src='https://www.walshcreative.com/wp-content/plugins/smart-scroll-posts/images/smart_scroll-ajax_loader.gif' alt='' style='display: block;margin: 0 auto;'>");
            },      
            success: function(data){
                $("#ajaxdata").html(data);
            }
        });      
    } 

    function getPrc(prcMin, prcMax){
        allFilter();     
    }

    function getDist(distMin, distMax){
        allFilter(); 
    }

    function allFilter(){

        
        var radioValue = $("input[name='condition']:checked").val();
  
        var checkedCat = $('.getcat:checkbox:checked').map(function() {
            return this.value;
        }).get();
       
        var checkedBrand = $('.getbrand:checkbox:checked').map(function() {
            return this.value;
        }).get();
    
        var prc =$(".prcRange").val();

        var textPrc  = prc.replace("$", "");
        var tPrc  = textPrc.replace("$", "");
        var ttPrc  = tPrc.replace("+", "");
        var arrPrc = ttPrc.split('-');

        if(typeof arrPrc[0] != 'undefined' && arrPrc[0] != ''){
            var prcMin = arrPrc[0];
        }else{
            var prcMin = 0;
        }

        if(typeof arrPrc[1] != 'undefined' && arrPrc[1] != ''){
            var prcMax = arrPrc[1];
        }else{
            var prcMax = 100;
        }

        var dist =$(".productDist").val();                   
      
        var textDist  = dist.replace("miles", "");
        var tDist  = textDist.replace("miles", "");
        var arr = tDist.split('-');

        if(typeof arr[0] != 'undefined' && arr[0] != ''){
            var distMin = arr[0];
        }else{
            var distMin = 0;
        }

        if(typeof arr[1] != 'undefined' && arr[1] != ''){
            var distMax = arr[1];
        }else{
            var distMax = 20;
        }

        $.ajax({
            url: base_url+"products/allProductListing/"+page,
            type: "POST",             
            cache: false,
            data:{address:address,categoryId:categoryId,radioValue:radioValue,checkedCat:checkedCat,checkedBrand:checkedBrand,prcMin:prcMin,prcMax:prcMax,distMin:distMin,distMax:distMax},
            beforeSend: function() {
                $("#ajaxdata").html("<img id='zlodaer' src='https://www.walshcreative.com/wp-content/plugins/smart-scroll-posts/images/smart_scroll-ajax_loader.gif' alt='' style='display: block;margin: 0 auto;'>");
            }, 
            success: function(res){
                $("#ajaxdata").html(res);
            }
        });           
    }
    
    function clearData(){
        $('input[name="condition"]').attr('checked', false);
        $('.getcat').prop('checked', false);
        $('.collapse').removeClass('in');
        $('.getbrand').prop('checked', false);
        $(".productDist").val('');  
        $(".prcRange").val('');
        ajax_fun(base_url+"products/allProductListing");
    }

    $(document).ready(function(){

        $(".getcat,.getbrand,.condiVal").change(function (){ 

            var address = "<?php echo $this->input->post('address');?>";
            var categoryId = "<?php echo $this->input->post('categoryId');?>";
            
            var radioValue = $("input[name='condition']:checked").val();

            var checkedCat = $('.getcat:checkbox:checked').map(function(){
                return this.value;
            }).get();

            var checkedBrand = $('.getbrand:checkbox:checked').map(function(){
                return this.value;
            }).get();
            
            var dist =$(".productDist").val();                   
      
      var textDist  = dist.replace("miles", "");
      var tDist  = textDist.replace("miles", "");
      var arr = tDist.split('-');

      if(typeof arr[0] != 'undefined' && arr[0] != ''){
        var distMin = arr[0];
      }else{
        var distMin = 0;
      }

      if(typeof arr[1] != 'undefined' && arr[1] != ''){
        var distMax = arr[1];
      }else{
        var distMax = 20;
      }

            $.ajax({
                url: base_url+"products/allProductListing/"+page,
                type: "POST",             
                cache: false,
                data:{address:address,categoryId:categoryId,radioValue:radioValue,checkedCat:checkedCat,checkedBrand:checkedBrand,distMin:distMin,distMax:distMax},
                beforeSend: function() {
          $("#ajaxdata").html("<img id='zlodaer' src='https://www.walshcreative.com/wp-content/plugins/smart-scroll-posts/images/smart_scroll-ajax_loader.gif' alt='' style='display: block;margin: 0 auto;'>");
        }, 
                success: function(res){
                    $("#ajaxdata").html(res);
                }
            });
        });        

        $(".getcat").click(function () { 
            var checkedVals = $('.getcat:checkbox:checked').map(function() {
                return this.value;
            }).get();            

            $.ajax({
                url: base_url+'products/getCategoryBrands',
                type: "POST",             
                cache: false,
                data:{checkedVals:checkedVals},
                success: function(ress){
                    $("#brandData").html(ress);
                }
            });              
        });       
    }); 


  /* File Code End */

