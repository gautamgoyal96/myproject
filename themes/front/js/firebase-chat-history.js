// <!-firebase chat history start Gk-->

var chatHistory = "chatHistory";
var database  = firebase.database().ref();
     ref = database.child(chatHistory).child(firebaseId);
     ref.on("value",gotData);
     function gotData(data){

      var scores = data.val();
        if(scores==null){
         $("#chatHistory").html('No chat history');
   }else{
            var keys = Object.keys(scores);
       dataShow(keys,scores);
     }

    }

 function dataShow(keys,scores){
    a = 0;
   $("#chatHistory").html("");
   if(keys.length==0){
         $("#chatHistory").html('<div class="chatList">No chat history </div>');
   }else{

   



    for (var i = 0; i < keys.length; i++) {
          var k = keys[i];
          var res = k.split("+");

      database.child("users").child(res[1]).once('value').then(function(snapshot) {
          var d = keys[a];
                 a++;
           var name = snapshot.val().name;
           var uImage = snapshot.val().image;
            var productId = scores[d].productId;
                        var productImage = scores[d].productImage;
                       var RreceiverId  =  scores[d].receiverId; 
                       var dt = new Date(scores[d].time);
                       var RsenderId  =  scores[d].senderId; 
                       var Userid =  scores[d].opponentId;
                        var message =  scores[d].message;
                        userId = RsenderId;
                     if(/^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/|www\.)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(message)){

                        var msg = "Send image";

                      } else {
                        
                        var msg = message; 

                      }

                      var month = dt.getMonth()+1;
                      var day = dt.getDate();

                      var output = (month<10 ? '0' : '') + month + '/' + (day<10 ? '0' : '') + day + '/' +  dt.getFullYear() ;

                      console.log(output);
                      console.log(output);
                      var hours = dt.getHours();
                      var minutes = dt.getMinutes();
                       var timeString = hours  + ":" + (minutes<10 ? '0' : '')+ minutes + ":" + dt.getSeconds();
                       var H = +timeString.substr(0, 2);
                      var h = (hours<10 ? '0' : '')+(H % 12) || 12;
                      var ampm = H < 12 ? "AM" : "PM";
                      postTime = output+" "+h + timeString.substr(2, 3) + ampm;
                      if (msg.length > 50) {
                          msg = msg.substr(0, 50)+'...';
                      }
                     $("#chatHistory").append('<div class="chatList"><div class="chatuserImg"><a href="'+base_url+'chat/index/'+Userid+'/'+productId+'"><img src="'+uImage+'"><div class="userInfo"><h3>'+name+'</h3><p>'+msg+'</p></div></a></div><div class="chatPr"><a href="'+base_url+"products/viewProduct/"+productId+'"><img src="'+productImage+'"></a><p>'+postTime+'</p></div></div>');
              
         
     });
             /* $.ajax({
                  url:base_url+'user/profilegetByChatId',
                  type:'post',
                 data: {'chatId':res[1]}, 
                  success:function(resp){

                    udata = $.parseJSON(resp);
                         var uImage = udata.image;
                       if(name!=""){
                        var name = udata.name; 
                       var d = keys[a];
                       console.log(name);
                       console.log(scores[d].message);
                       var productId = scores[d].productId;
                        var productImage = scores[d].productImage;
                       var RreceiverId  =  scores[d].receiverId; 
                       var dt = new Date(scores[d].time);
                       var RsenderId  =  scores[d].senderId; 
                       var Userid =  scores[d].opponentId;
                        var message =  scores[d].message;
                        userId = RsenderId;
                     if(/^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/|www\.)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(message)){

                        var msg = "Send image";

                      } else {
                        
                        var msg = message; 

                      }

                      var month = dt.getMonth()+1;
                      var day = dt.getDate();

                      var output = (day<10 ? '0' : '') + day + '/' + (month<10 ? '0' : '') + month + '/' + dt.getFullYear() ;
                       var timeString = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
                       var H = +timeString.substr(0, 2);
                      var h = (H % 12) || 12;
                      var ampm = H < 12 ? "AM" : "PM";
                      postTime = output+" "+h + timeString.substr(2, 3) + ampm;
       
                     $("#chatHistory").append('<div class="chatList"><a href="'+base_url+'chat/index/'+Userid+'/'+productId+'"><div class="chatuserImg"><img src="'+uImage+'"><div class="userInfo"><h3>'+name+'</h3><p>'+msg+'</p></div></div><div class="chatPr"><img src="'+productImage+'"><p>'+postTime+'</p></div></a></div>');
                    a++;
                  }
                  
                  }
            });*/


     }

   }

 }

 function dataSort(array){

array.sort(function(a,b){
  // Turn your strings into dates, and then subtract them
  // to get a value that is either negative, positive, or zero.
  return new Date(b.time) - new Date(a.time);
}); 

 }

    // <!-firebase chat history end Gk-->
