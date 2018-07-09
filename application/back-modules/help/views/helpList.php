 <!-- Page -->
<?php $page = $this->uri->segment(3);?>
<div class="page animsition">
    <div class="page-header">
        <h1 class="page-title">Help and suport</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>dashboard">Home</a></li>
            <!--   <li><a href="<?php echo base_url();?>user/addUser">Add Employee</a></li> -->        
        </ol>
      
    </div>
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-sm-12">
              
                <!-- Panel Floating Labels -->
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title"></h3>
                    </div>
                    <div class="panel-body container-fluid">

                      <div class="ProfileTab">
                      <?php
                      $userId       = $userDetail['id'];
                      $fullName       = $userDetail['firstName']." ".$userDetail['lastName'];

                   ?>
                   <input type="hidden" id="userId" value="<?php echo $userId; ?>">
                        <ul class="nav nav-tabs">

                          <li class="active"><a data-toggle="tab" href="#message" onclick="message_fun();" >Message</a></li>
                         
                        </ul>
                      </div>
                       
                        <div class="tab-content">
        
           <div class="tab-pane fade in active" id="message">
             <br>
              <section class="formDesign  app-message page-aside-scroll ">
                <div class="container">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="panel ">
                     <!-- Chat Box -->
<div class="app-message-chats" style="max-height:350px;overflow-y: scroll;">
      <input type="hidden" id="orderM" value="0">
       <!--  <button type="button" id="historyBtn" class="btn btn-round btn-outline btn-default">History Messages</button> -->
        <div id="ajaxDataM"></div>
      </div>
                <!-- End Chat Box -->
                      <!-- Message Input-->
      <form class="app-message-input"  id="msgForm"method="post" action="<?php echo base_url().'help/send' ?>">
       <div class="message-input" id="err_msgA" style=" color: red;"></div>
        <div class="message-input">
        <input type="hidden" name="userId"  value="<?php echo $userId; ?>" class="form-control"> 
          <p class="emoji-picker-container">
          <textarea name="message" id="msgText" class="form-control" data-emojiable="true" placeholder="Type your message here..."  rows="1"></textarea>
          </p>
        </div>
        
        <button type="submit" class="message-input-btn btn btn-primary" type="button">SEND</button>
        
        
      </form>
      <!-- End Message Input-->
                    </div>
                  </div>
                  </div>
                </div>
              </section>
            
            </div>
        
        
        </div>
                    </div>
                </div>
                <!-- End Panel Floating Labels -->
            </div>
        </div>
    </div>
</div>
<!-- End Page --> 
<script type="text/javascript">
message_funorder();
  function message_funorder(){
    $("#orderM").val(1);
    message_fun();
  }


function message_fun(){
  $.ajax({
                type:'GET',
                url: "<?php echo base_url().'help/messagelist'; ?>",
                data:{'userId':$("#userId").val(),'orderM':$("#orderM").val(),'fullName':'<?php echo $fullName; ?>'},
                cache:false,
                beforeSend: function() {
                  $("#err_msg").html('<i class="fa fa-spinner fa-spin" style="font-size:14;color:#C0262C"></i>');
                },     
                success:function(data){
                    console.log("success");
                      $("#orderM").val(0);
                    $("#ajaxDataM").html(data);
                    $(".app-message-chats").stop().animate({ scrollTop: $(".app-message-chats")[0].scrollHeight},300);
                    $("#err_msg").html('');
                }
            });
}
  $('#msgForm').on('submit',(function(e) {
        e.preventDefault();
        $('#err_msg').text('');
      
        var $form    = $(e.target);
        var formData = new FormData(this);
        params   = $form.serializeArray();
        var flag=0;
        var message           = $form.find('[name="message"]')[0].value;
       
        if(message == 0 &&  message==''){
            $('#err_msgA').text('Complete mandatory message.');
            $('#msgText').addClass('has-error');
        }else{
           flag=1;
            $('#err_msgA').text('');
            $('#msgText').removeClass('has-error');
        }
       if(flag){
            $.ajax({
                type:'POST',
                url: $(this).attr('action'),
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                  $("#err_msg").html('<i class="fa fa-spinner fa-spin" style="font-size:14;color:#CA3586"></i>');
                },     
                success:function(data){
                    console.log("success");
                    console.log(data);
                    $('.emoji-wysiwyg-editor').text('');
                    $("#msgForm").trigger('reset');
                  ;
                   /* $("#msgA").html("Location Updated successfully");
                    setTimeout(function() {  $("#msgA").html("");  location.reload(); },1000);*/
                    message_fun();
                    $("#err_msg").html('');
                },
                error: function(data){
                    console.log("error");
                    console.log(data);
                    $("#err_msg").html('');
                }
            });
        }
    }));

</script>