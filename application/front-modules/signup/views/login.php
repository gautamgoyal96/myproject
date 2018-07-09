<div class="adjust_cntainer">
	<div class="extra-margin"></div>
</div>
<section class="LoginSignup">
	<div class="container">
		<div class="lsInner">
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<div class="lsLeft">
						<img src="<?php echo base_url().FRONT_THEME;?>images/login_pop_whit_logo.png">
						<h2>Login</h2>
						<p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500stry's standard dummy text ever since the 1500s. try's standard dummy text ever since the 1500s Lorem industry. Lorem Ipsum has been the industry's standard dummy text ever Lorem Ips </p>
					</div>
				</div>
				<div class="col-md-6 col-sm-6">
					<div class="lsRight">
						<div style="display:none;" class="alert alert-warning hideDiv" role="alert" id="err-warnig">
						  	<strong>Warning!</strong>
						    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    	<span aria-hidden="true">&times;</span>
						  	</button>
						   <span id="error-waring"></span>
						</div>
						<div style="display:none;" class="alert alert-danger hideDiv" role="alert" id="err-log">
						  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    	<span aria-hidden="true">&times;</span>
						  	</button>
						  	<strong>Oh snap!</strong> <span id="error-log"></span>
						</div>
						<form class="lsform" action="JavaScript:Void(0)" onsubmit="userLogin();" autocomplete="off">
							<h3>Login Your Account</h3>
							<input type="hidden" id="getUserType" value="<?php if(!empty($this->session->userdata('userType'))) { echo $this->session->userdata('userType'); } ?>">
							<div class="form-group">
						      <input type="email" class="form-control email" placeholder="Email Id" id="emailLogin" name="Email" value="<?php if(!empty($this->session->userdata('memberEmail'))) { echo $this->session->userdata('memberEmail'); } ?>" >
						      <div  id="login-email-err" ></div>
						    </div>
						     
						    <div class="form-group">
						      <input type="password" class="form-control pwd" placeholder="Password" id="passwordLogin" value="<?php if(!empty($this->session->userdata('memberPassword'))) { echo $this->session->userdata('memberPassword'); } ?>" >
						      <div  id="login-password-err" ></div>
						    </div>
						     
						    <div class="input-field col s12 m12 l12  login-text">
								<input id="remember-me" name="remember" value="1" type="checkbox">
								<label for="remember-me" class="chck_bx_rem_me">Keep me logged in</label>
								<a href="javascript:void();" data-toggle="modal" data-target="#forgotPWD" class="fpwd">Forgot password ?</a>
							</div>
							<div class="form-group lsBtn">
						      <button class="btn btn-primary" type="submit">Login</button>
						    </div>
						</form>
						<div class="background-line" data-reactid="164">
							<span class="push-tiny--sides text--uppercase small" data-reactid="165">Or</span>
						</div>
						<p class="both_btn">

							<!-- <div id="customBtn" class="customGPlusSignIn">
							     <img src="https://camo.githubusercontent.com/da18dfde046310c33010757e0b1d2a1f6c95b5d7/68747470733a2f2f646576656c6f706572732e676f6f676c652e636f6d2f6163636f756e74732f696d616765732f7369676e2d696e2d776974682d676f6f676c652e706e67" alt="google"/>
							   </div> -->
								
							<a href="javascript:void(0);" id="customBtn" class="customGPlusSignIn">
								<button class="btn btn-primary google_btn pull-left">Login with Google</button>
							</a>
							  
							<a href="javascript:void(0);" onclick="fbLogin()" id="fbLink">
								<button class="fcbook_btn btn btn-primary pull-left">login with Facebook</button>
							</a>
						</p>						
						<div class="lsB">
							<p>Don't have an account? <a href="<?php echo base_url();?>signup">Create Account</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade bookModal" id="forgotPWD" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  	<div class="modal-dialog" role="document">
		    <div class="modal-content">
		      	<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        	<h4 class="modal-title" id="myModalLabel">Forgot password</h4>
		      	</div>
		      	<div class="modal-body">
			       	<form class="lsform" id="forgotForm" method="post" action="#">
			       		<p>To reset your password ,please enter your email address.</p>
			       		<div class="alert dark alert-icon alert-danger alert-dismissible" role="alert" id="errorDiv1" style="display:none;">
			                <center><span id="error1"></span></center>
			            </div>
						<div class="form-group">
					      <input type="text" class="form-control email" id="validMail" placeholder="Email Id" name="email" value="" autocomplete="off">
					    </div>
			       		<button type="submit" name="submit" value="Login" class="btn btn-primary cs-btn">Send</button>
			       </form>
		      	</div>
		    </div>
		</div>
	</div>
</section>
