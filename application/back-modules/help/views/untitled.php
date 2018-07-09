   <!-- Chat Box -->
      <div class="app-message-chats">
       <!--  <button type="button" id="historyBtn" class="btn btn-round btn-outline btn-default">History Messages</button> -->
        <div class="chats">
          <div class="chat">
            <div class="chat-avatar">
              <a class="avatar" data-toggle="tooltip" href="#" data-placement="right" title="">
                <img src="<?php echo base_url().ADMIN_THEME;?>global/portraits/4.jpg" alt="June Lane">
              </a>
            </div>
            <div class="chat-body">
              <div class="chat-content">
                <p>
                  Hello. What can I do for you?
                </p>
              </div>
            </div>
          </div>
          <div class="chat chat-left">
            <div class="chat-avatar">
              <a class="avatar" data-toggle="tooltip" href="#" data-placement="left" title="">
                <img src="<?php echo base_url().ADMIN_THEME;?>global/portraits/5.jpg" alt="Edward Fletcher">
              </a>
            </div>
            <div class="chat-body">
              <div class="chat-content">
                <p>
                  I'm just looking around.
                </p>
                <p>Will you tell me something about yourself? </p>
              </div>
              <div class="chat-content">
                <p>
                  Are you there? That time!
                </p>
              </div>
            </div>
          </div>
          
        </div>
      </div>
      <!-- End Chat Box -->
											<!-- Message Input-->
      <form class="app-message-input">
        <div class="message-input">
          <textarea class="form-control" rows="1"></textarea>
          <div class="message-input-actions btn-group">
            <button class="btn btn-pure btn-icon btn-default" type="button">
              <i class="icon wb-emoticon" aria-hidden="true"></i>
            </button>
            <button class="btn btn-pure btn-icon btn-default" type="button">
              <i class="icon wb-image" aria-hidden="true"></i>
            </button>
            <button class="btn btn-pure btn-icon btn-default" type="button">
              <i class="icon wb-paperclip" aria-hidden="true"></i>
            </button>
            <input id="messageImage" type="file" name="messageImage">
            <input id="messageFile" type="file" name="messageFile">
          </div>
        </div>
        <button class="message-input-btn btn btn-primary" type="button">SEND</button>
      </form>
      <!-- End Message Input-->