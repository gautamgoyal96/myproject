    <script type="text/javascript">                
    var senderId = "<?php echo $senderDetail['firebaseId'];?>";
    var receiverId = "<?php echo $reciverDetail['firebaseId'];?>";
    var productImage = "<?php echo $images[0]->productImage;?>";
    var productId = "<?php echo  $details->id; ?>";
    var receiverName = "<?php echo $reciverDetail['firstName']." ".$reciverDetail['lastName'];?>";
    var senderName = "<?php echo $senderDetail['firstName']." ".$senderDetail['lastName'];?>";
    var productName = "<?php echo  $details->title; ?>";
    var reciverImg = "<?php echo $reciverDetail['url'];?>";
    var senderImg = "<?php echo $senderDetail['url'];?>";
    var receiverToken = "<?php echo $reciverDetail['firebaseToken'];?>";
    var senderToken = "<?php echo $senderDetail['firebaseToken'];?>";
    var sopponentId = "<?php echo $senderDetail['id'];?>";
    var ropponentId = "<?php echo $reciverDetail['id'];?>";

    </script>

        <link rel="stylesheet" href="<?php echo base_url().FRONT_THEME;?>css/jquery.fancybox.css">
  <script src="https://www.gstatic.com/firebasejs/3.3.0/firebase.js"></script>
  <script src="https://cdn.firebase.com/libs/firechat/3.0.1/firechat.min.js"></script>
    <script type="text/javascript">
         var config = {
        apiKey: "AIzaSyDdtWa5VtbZUJCU68EaT4sAkFOY017RVYk",
        authDomain: "ava-rents-bea86.firebaseapp.com",
        databaseURL: "https://ava-rents-bea86.firebaseio.com",
        projectId: "ava-rents-bea86",
        storageBucket: "ava-rents-bea86.appspot.com",
        messagingSenderId: "918604010413"
      };
      firebase.initializeApp(config);
    </script>
<div class="extra-margin"></div>
<section class="main_section chatSec pad-sec-60">
   <div class="container">
      <div class="chat_container">
        <div class="col-sm-3 chat_sidebar">
        <a href="<?php echo base_url()."products/viewProduct/".$details->id;?>">
          <div class="ChatProduct">
            <img src="<?php echo $images[0]->productImage;?>">
            <h3><?php echo !empty($details->title) ? $details->title  : 'NA'; ?></h3>
          </div>
          </a>
        </div>
        <!--chat_sidebar-->
        <div class="col-sm-9 message_section">
          <div class="row">
            <div class="new_message_head">
              <div class="pull-left chat-userimg">
                    <img src="<?php echo $reciverDetail['url'];?>" alt="User Avatar" class="img-circle"> <span><?php echo $reciverDetail['firstName']." ".$reciverDetail['lastName'];?></span>
              </div>
            </div>
            <div class="chat_area scrollDown">
              <ul class="list-unstyled messages" id="chatMsg">

              </ul>
            </div><!--chat_area-->
            <div class="message_write">
              <div class="emoji-box">
              <!-- data-emojiable="true" -->
              <textarea class="form-control" id="status_message" placeholder="Type a message..." data-emojiable="true"></textarea>
              </div>              <div class="clearfix"></div>
              <div class="chat_bottom"><a  class="pull-left upload_btn"><i class="fa fa-cloud-upload" aria-hidden="true"></i><input type="file" id="image" accept="image/*" ></a>
              <button class="pull-right btn btn-success" type="button" id="messageForm" >Send</button>
              <input type="hidden" id="room">
              </div>
           </div>
        </div>
      </div> <!--message_section-->
    </div>
  </div>
</section>

<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <h4 class="modal-title" id="myModalLabel">Image preview</h4>
    </div>
    <div class="modal-body">
      <img src="" id="imagepreview" style="width: 100%; height: 350px;" >
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
    </div>
  </div>
  </div>


 <script type="text/javascript">

  function showImageBig(imageUrl){
   
    // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
  }

$('.messages').on('click','a.appeared',function() {    
        var imageurl = $(this).data('image');
       // if(imageurl != ''){
          $('#imagepreview').attr('src',imageurl);
          $('#imagemodal').modal('show'); 
       // }
    });



    var room1 = productId+"+"+senderId+"+"+receiverId;
  var room2 = productId+"+"+receiverId+"+"+senderId;
  var chatHistory = "chatHistory";
var chat = "chat";
                var senderIdRef = firebase.database().ref().child(chat).child(room1);
          senderIdRef.on("value",sgotData);
    $("#room").val(room2);
                  firebase.database().ref().child(chat).child(room1);

            function sgotData(sdata){

                var sdata = sdata.val();

                var reciveIdRef = firebase.database().ref().child(chat).child(room2);
          reciveIdRef.on("value",rgotData);

              function rgotData(rdata){

                 var rdata = rdata.val();

                if(sdata!=null){

                  $("#room").val(room1);
                   var room = $("#room").val();
                    ref = firebase.database().ref().child(chat).child(room).limitToLast(100);
                    ref.on("value",gotData);

                }else if(rdata!=null){

                  $("#room").val(room2);
                    var room = $("#room").val();
                    ref = firebase.database().ref().child(chat).child(room).limitToLast(100);
                    ref.on("value",gotData);

                }else{

                 $("#room").val(room1);
                  firebase.database().ref().child(chat).child(room1);
                   var room = $("#room").val();
                  ref = firebase.database().ref().child(chat).child(room).limitToLast(100);
                  ref.on("value",gotData);


                }

            }
        }



  var room = $("#room").val();

    function gotData(data){

      var scores = data.val();
      var keys = Object.keys(scores);

      $("#chatMsg").html("");
      for (var i = 0; i < keys.length; i++) {
          var k = keys[i];
         var message = scores[k].message;

d ='' 
if(/^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/|www\.)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(message)){

            var msg = "<a href='#' class='appeared' data-image="+message+"><img src="+message+" heigh='150' width='150' id="+message+"></a>";
            d='';

} else {
         var msg = message; 
        if (msg.length > 90) {
              d = 'my';
         }
     
}

        
          var RsenderId  =  scores[k].senderId; 
         var dt = new Date(scores[k].time);

      var month = dt.getMonth()+1;
                      var day = dt.getDate();

                       var output = (month<10 ? '0' : '') + month + '/' + (day<10 ? '0' : '') + day + '/' +  dt.getFullYear() ;

                      var hours = dt.getHours();
                      var minutes = dt.getMinutes();
                       var timeString = hours  + ":" + (minutes<10 ? '0' : '')+ minutes + ":" + dt.getSeconds();
                       var H = +timeString.substr(0, 2);
                      var h = (hours<10 ? '0' : '')+(H % 12) || 12;
                      var ampm = H < 12 ? "AM" : "PM";
                      postTime = h + timeString.substr(2, 3) + ampm;
        if(RsenderId==senderId){
                var data =  '<li class="left clearfix admin_chat"><span class="chat-img1 pull-right"><img src="'+senderImg+'" class="img-circle"></span><div class="chat-body1 clearfix"><p class="'+d+'">'+msg+'</p><div class="chat_time pull-right">'+output+" "+postTime+'</div></div</li>';
                $("#chatMsg").append(data);
                $(".scrollDown").stop().animate({ scrollTop: $(".scrollDown")[0].scrollHeight}, 0);

        }else{
              $(".scrollDown").stop().animate({ scrollTop: $(".scrollDown")[0].scrollHeight}, 0);
               var data =  '<li class="left clearfix"><span class="chat-img1 pull-left"><img src="'+reciverImg+'" alt="User Avatar" class="img-circle"></span><div class="chat-body1 clearfix"><p class="'+d+'">'+msg+'</p><div class="chat_time pull-right">'+output+" "+postTime+'</div></div</li>';
               $("#chatMsg").append(data);
        }

         
      }


    }

$("#messageForm").click(function(e) {
  var room = $("#room").val();
    var time = $.now();
  var message = $("#status_message").val();
        $("#status_message").val('');
        $(".emoji-wysiwyg-editor").text('');

  if(message!=""){

            
             newPostKey  = firebase.database().ref().child(chat).child(room).push().key;
              if(newPostKey ){

              var postData = {"message": message, "opponentName": receiverName, "productId": productId,"productImage":productImage,"productName": productName,"receiverId" : receiverId,"senderId" : senderId,"time": time,"timeForDelete" : newPostKey};

               var updates = {};
              updates[newPostKey] = postData;
              firebase.database().ref().child(chat).child(room).update(updates);

              var postData1 = {"message": message, "opponentName": receiverName, "opponentId": ropponentId, "productId": productId,"productImage":productImage,"productName": productName,"receiverId" : receiverId,"senderId" : senderId,"time": time,"timeForDelete" : newPostKey};

             historyRoom1 = productId+"+"+receiverId;
             console.log(historyRoom1);
              historyRoom1Key  = firebase.database().ref().child(chatHistory).child(senderId).child(historyRoom1).key;
              if(historyRoom1Key ){
                     
                   var updates = {};
                  updates[historyRoom1Key] = postData1;
                  firebase.database().ref().child(chatHistory).child(senderId).update(updates);

              }

              var postData2 = {"message": message, "opponentName": receiverName, "opponentId": sopponentId, "productId": productId,"productImage":productImage,"productName": productName,"receiverId" : receiverId,"senderId" : senderId,"time": time,"timeForDelete" : newPostKey};

              historyRoom2 = productId+"+"+senderId;
              console.log(historyRoom2);
              historyRoom12Key  = firebase.database().ref().child(chatHistory).child(receiverId).child(historyRoom2).key;
              if(historyRoom12Key ){
                     
                   var updates = {};
                  updates[historyRoom12Key] = postData2;
                  firebase.database().ref().child(chatHistory).child(receiverId).update(updates);

              }

              $(".scrollDown").stop().animate({ scrollTop: $(".scrollDown")[0].scrollHeight}, 0);

                  var sendMessage = productName+" : "+message;     
                  $.ajax({
                        url:base_url+'products/SendNotifcation',
                        type:'post',
                       data: {'receiverToken':receiverToken,'msg':sendMessage,'title':senderName,'senderId':senderId,'senderToken':senderToken,'productId':productId,'productName':productName,'productImage':productImage,'chatRoomId':room}, 
                        success:function(resp){
                        
                        }
                  });
             }
       
      }
   
});

var fileButton = document.getElementById("image");

$("#image").change(function(e){
    var room = $("#room").val();
    var time = $.now();
    var file = e.target.files[0];
    var storageRef = firebase.storage().ref('website_ava/'+file.name);
    var uploadTask =   storageRef.put(file);
    var sendMessage = productName+" : Send image";     
    $.ajax({
          url:base_url+'products/SendNotifcation',
          type:'post',
         data: {'receiverToken':receiverToken,'msg':sendMessage,'title':senderName,'senderId':senderId,'senderToken':senderToken,'productId':productId,'productName':productName,'productImage':productImage,'chatRoomId':room}, 
          success:function(resp){
          
          }
    });
   $(".scrollDown").stop().animate({ scrollTop: $(".scrollDown")[0].scrollHeight}, 0);

  uploadTask.on('state_changed', function(snapshot){

        }, function(error) {

        }, function() {
        
          var downloadURL = uploadTask.snapshot.downloadURL;

                 newPostKey  = firebase.database().ref().child(chat).child(room).push().key;
                  if(newPostKey ){

                       var postData = {"message": downloadURL, "opponentName": receiverName, "productId": productId,"productImage":productImage,"productName": productName,"receiverId" : receiverId,"senderId" : senderId,"time": time,"timeForDelete" : newPostKey};
                       var updates = {};
                      updates[newPostKey] = postData;
                      firebase.database().ref().child(chat).child(room).update(updates);
                      var postData1 = {"message": downloadURL, "opponentName": receiverName, "opponentId": ropponentId, "productId": productId,"productImage":productImage,"productName": productName,"receiverId" : receiverId,"senderId" : senderId,"time": time,"timeForDelete" : newPostKey};
                       historyRoom1 = productId+"+"+receiverId;
                      historyRoom1Key  = firebase.database().ref().child(chatHistory).child(senderId).child(historyRoom1).key;
                      if(historyRoom1Key ){
                             
                           var updates = {};
                          updates[historyRoom1Key] = postData1;
                          firebase.database().ref().child(chatHistory).child(senderId).update(updates);

                      }

                     var postData2 = {"message": downloadURL, "opponentName": receiverName, "opponentId": sopponentId, "productId": productId,"productImage":productImage,"productName": productName,"receiverId" : receiverId,"senderId" : senderId,"time": time,"timeForDelete" : newPostKey};
                      historyRoom2 = productId+"+"+senderId;
                      historyRoom12Key  = firebase.database().ref().child(chatHistory).child(receiverId).child(historyRoom2).key;
                      if(historyRoom12Key ){
                             
                           var updates = {};
                          updates[historyRoom12Key] = postData2;
                          firebase.database().ref().child(chatHistory).child(receiverId).update(updates);

                      }
                      $(".scrollDown").stop().animate({ scrollTop: $(".scrollDown")[0].scrollHeight}, 0);
                 }

        });


});
   
 </script>
<script>
var path = base_url+"../../<?php echo FRONT_THEME.'js/lib/img/';?>";
      $(function() {
        // Initializes and creates emoji set from sprite sheet
        window.emojiPicker = new EmojiPicker({
          emojiable_selector: '[data-emojiable=true]',
          assetsPath: path,
          popupButtonClasses: 'fa fa-smile-o'
        });
        // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
        // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
        // It can be called as many times as necessary; previously converted input fields will not be converted again
        window.emojiPicker.discover();
      });
    </script>
    <script>
      // Google Analytics
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-49610253-3', 'auto');
      ga('send', 'pageview');
    </script>