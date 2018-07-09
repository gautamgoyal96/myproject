<?php if(!empty($chat)){ ?>
<button id="historyBtn" class="btn btn-round btn-outline btn-default" onclick="message_funorder()"; type="button">History Messages</button>

 <?php } ?>       
<div class="chats">
	<?php foreach ($chat as $K => $val) { ?>
          <div class="chat <?php echo ($val->senderType==1)?'chat-left':'chat-right'; ?>">
            <p class="time"><?php echo $val->createDate; ?></p>
            <div class="chat-avatar">
              <a class="avatar" data-toggle="tooltip" href="#" data-placement="right" title="">
              <?php 
              $msurl ="http://placehold.it/50/C0262C/fff&text=ME";
              if($val->senderType==1){ 
              	$msurl ="http://placehold.it/50/F96868/fff&text=U";
              }
              	?>
                <img src="<?php echo $msurl;?>" alt="..">
              </a>
            </div>
            <div class="chat-body">
              <div class="chat-content">
                <p>
                  <?php if($val->postType==0){ ?>
                 <?php echo $val->message; ?>
                 <?php }else{ ?>
                 <img src="<?php echo base_url()."../uploads/chat/".$val->message; ?>" style="width: 250px; height: 250px;">
                 <?php } ?>
                </p>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <?php } if(empty($chat)){ ?>
           <p class="time">No record available for Message.</p>       
          <?php } ?>       
</div>

