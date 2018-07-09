<?php
$activeTabs = $this->uri->segment('1');
if(!empty($this->uri->segment('2'))){

  $activeTabs = $this->uri->segment(2);
} 
$title = $home = $category = $aboutUs  = $myProduct = $addProduct = $myProfile = $signup = $login ='';

switch ($activeTabs) {
    case 'home':
       $home = "active";
       $title = "Home";

    break;
    case 'category':
       $category = "active";
       $title = "Category List";
    break; 
    case 'aboutUs':
       $aboutUs = "active";
       $title = "About Us";
    break;

    case 'myProduct':
        $myProduct = "active";
        $title = "My Product";
    break;

    case 'addProduct':
       $addProduct = "active";
       $title = "Add Product";
    break;  

   	case 'myProfile':
       $myProfile = "active";
       $title = "My Profile";
    break;

    case 'signup':
       $signup = "active";
       $title = "SignUp";
    break; 

    case 'login':
       $login = "active";
       $title = "Login";
    break; 
  
  	default:
    	$home = "active";
    	$title = "Home";
    break;
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="google-site-verification" content="CSaf9i0d7c9-LlZ8ta5fBHMlrUFw80fWArFblz3JGIg" />
		<title> Ava Rents | <?php echo $title;?></title>
		<link href="<?php echo base_url().FRONT_THEME;?>css/roboto_font.css" rel="stylesheet"> 
		<link rel="shortcut icon" href="<?php echo base_url().FRONT_THEME;?>images/favicon.png" type="image/png">
		<link rel="icon" href="<?php echo base_url().FRONT_THEME;?>images/favicon.png" type="image/png">
		<link rel="stylesheet" href="<?php echo base_url().FRONT_THEME;?>css/bootstrap.min.css" />
		<link href="<?php echo base_url().FRONT_THEME;?>css/animate.css" rel="stylesheet" />
		<link rel="stylesheet" href="<?php echo base_url().FRONT_THEME;?>css/owl.carousel.min.css">
		<link rel="stylesheet" href="<?php echo base_url().FRONT_THEME;?>css/jquery.fancybox.css"  />
		<link href="<?php echo base_url().FRONT_THEME;?>css/font-awesome.min.css" rel="stylesheet">
 		<link rel="stylesheet" href="<?php echo base_url().FRONT_THEME;?>css/jquery-ui.css">
		<link rel="stylesheet" href="<?php echo base_url().FRONT_THEME;?>css/bootstrap-datepicker.min.css">		
		<link rel="stylesheet" href="<?php echo base_url().FRONT_THEME;?>css/flexslider.css" type="text/css"/>
		<link rel="stylesheet" href="<?php echo base_url().FRONT_THEME;?>css/wickedpicker.min.css">
		<link href="<?php echo base_url().FRONT_THEME;?>css/style.css" rel="stylesheet" />
		<link href="<?php echo base_url().FRONT_THEME;?>css/developer.css" rel="stylesheet" />
		<link href="<?php echo base_url().FRONT_THEME;?>css/media.css" rel="stylesheet" />
		<link href="<?php echo base_url().FRONT_THEME;?>css/form_wizard.css" rel="stylesheet" />
        <?php if(isset($addCss)) { 
            for($i = 0; $i < count($addCss); $i++){  ?>
                <link rel="stylesheet" href="<?php echo base_url().FRONT_THEME.$addCss[$i];?>">      
        <?php } 
        }  ?>
		<script type="text/javascript">
			var base_url = "<?php echo site_url();?>";
		</script>
		<!-- Jquery Js -->	
		<script src="<?php echo base_url().FRONT_THEME;?>js/jquery.min.js" type = "text/javascript"></script>
		<!-- Latest compiled and minified Bootstrap JavaScript -->
		<script src="<?php echo base_url().FRONT_THEME;?>js/bootstrap.min.js" type = "text/javascript"></script>
		<script src="https://apis.google.com/js/api:client.js"></script>
		<script src="<?php echo base_url().FRONT_THEME;?>js/google-login.js" type = "text/javascript"></script>
		<script>startApp();</script>

	</head>
	<body id="mainBox">
		<div id="site-main"> <!-- div started -->
            <?php
            if($this->uri->segment('1')=='home' && $this->uri->segment('2') == ''){

            	if(!empty($this->session->userdata('latitude')) && !empty($this->session->userdata('longitude'))){

            		$this->session->unset_userdata('latitude');
            		$this->session->unset_userdata('longitude');
            	}

            	if(!empty($this->session->userdata('categoryId'))){

            		$this->session->unset_userdata('categoryId');
            	}
            }

            $owner = 'none';
			$user = 'show';
			if($this->session->userdata('front_login') == true){ 

				if($this->session->userdata('userType') == 1){ 
					$user = 'none';
					$owner = 'show';
				}else{
				 	$user = 'show';
					$owner = 'none';
				}
			}
            ?>
				<!-- Header Section Begins -->			
				<div class="adjust_cntainer">			
					<header id="header" class="float-panel" data-top="0" data-scroll="100">
						<div class="container-fluid">
							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-4 col-xs-8">
									<div class="logo">
										<?php if($this->session->userdata('front_login') == true && $this->session->userdata('userType') == 1){ ?>
											<a href="<?php echo base_url();?>products/myProduct"><img src="<?php echo base_url().FRONT_THEME;?>images/logo.png" alt="logo" /></a>
										<?php } else{ ?>
											<a href="<?php echo base_url();?>"><img src="<?php echo base_url().FRONT_THEME;?>images/logo.png" alt="logo" /></a>
										<?php } ?>
									</div>
								</div>
								<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 main-menu">
									<div class="menuBar">
										<nav class="navbar navbar-default">
											<div class="navbar-header">
												<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
													<span class="sr-only">Toggle navigation</span>
													<span class="icon-bar"></span>
													<span class="icon-bar"></span>
													<span class="icon-bar"></span>
												</button>
											</div>
											<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
												<ul class="nav navbar-nav navbar-right">
													<li class="<?php echo $home; ?>" style="display:<?php echo $user;?>"><a href="<?php echo base_url();?>home">Home</a></li>

													<?php if($this->session->userdata('front_login')){ ?>
											         	<?php if($this->session->userdata('userType') == 2 && $this->session->userdata('id')){
											        	?>

											        	<li class="" style="display:<?php echo $user;?>"><a href="javascript:void();" class="-mu-readmore-btn">Transaction</a></li>
											        <?php } }?>

													<li class="<?php echo $category; ?>" style="display:<?php echo $user;?>"><a href="<?php echo base_url();?>products/category">Category</a></li>

													<li class="<?php echo $aboutUs; ?>" style="display:<?php echo $user;?>"><a href="<?php echo base_url();?>aboutUs">About Us</a></li>
													
													<?php
													if($this->session->userdata('front_login')){ ?>
											         	<?php if($this->session->userdata('userType') == 1 && $this->session->userdata('id')){
											        	?>

											        	<li class="<?php echo $myProduct; ?>" style="display:<?php echo $owner;?>"><a href="<?php echo base_url();?>products/myProduct">My Product</a></li>

											        	<li class="<?php echo $addProduct; ?>" style="display:<?php echo $owner;?>"><a href="<?php echo base_url();?>products/addProduct">Add Product</a></li>

											        	<li class="" style="display:<?php echo $owner;?>"><a href="javascript:void();" class="-mu-readmore-btn">Transaction</a></li>

											        	<?php } ?>										        	

											        	<li class="<?php echo $aboutUs; ?>" style="display:<?php echo $owner;?>"><a href="<?php echo base_url();?>aboutUs">About Us</a></li>

											        	<li class="<?php echo $myProfile; ?>"><a href="<?php echo base_url().'user/myProfile';  ?>" class="-mu-readmore-btn">My Profile</a></li>
											          	
											        <?php } else {?>
														<li class="<?php echo $signup; ?>"><a href="<?php echo base_url();?>signup">Create Account</a></li>

														<li class="<?php echo $login; ?>"><a href="<?php echo base_url();?>signup/login">Login</a></li>

											        <?php } ?>	
												</ul>
											</div>
										</nav>
									</div>
								</div>
							</div>
						</div>
					</header>
					<!-- Header Section Ends -->
				</div>			
				<div class="main">		
					<!-- Page -->
				  	<?php echo $template['body']; ?>   		
				  	<!-- End Page -->
					<!-- Footer Section Begins -->
					<footer id="footer" class="">
					    <div class="container">
						    <div class="row footer-body">
						        <!-- Footer Brand Column -->
						        <div class="col-md-4 col-sm-3 footer-column">
							        <a href="#" id="footer-brand" class="footer-brand"><img src="<?php echo base_url().FRONT_THEME;?>images/logo.png" alt="Av"a></a>
							        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec consequat aliquam orci, venenatis aliquet ex placerat sit amet. Nam blandit pharetra pellentesque.</p>
						        </div>

						        <!-- Usefull Link Column -->
						        <div class="col-md-3 col-sm-3 footer-column">
							        <h3 class="footer-title">Products</h3>
							        <ul class="footer-menu">
							            <li><a href="#">Tools</a></li>
							            <li><a href="#">Listing</a></li>
							            <li><a href="#">Property Listing</a></li>
							            <li><a href="#">Property Search</a></li>
							            <li><a href="#">Special Tabs</a></li>
							        </ul>
						        </div>
						        <!-- Information Column -->
						        <div class="col-md-3 col-sm-3 footer-column">
							        <h3 class="footer-title">Information</h3>
							        <ul class="footer-menu">
							            <li><a href="#">Our Team</a></li>
							            <li><a href="#">Payment Options</a></li>
							            <li><a href="#">Informations</a></li>
							            <li><a href="#">FAQ</a></li>
							        </ul>
						        </div>
						        <!-- Instagram Column -->
						        <div class="col-md-2 col-sm-3 footer-column">
						        <h3 class="footer-title">Company</h3>
						        <ul class="footer-menu">
						            <li><a href="#">About Company</a></li>
						            <li><a href="#">Our Team</a></li>
						            <li><a href="#">Contact Us</a></li>
						            <li><a href="#">Registration</a></li>
						            <li><a href="#">Sign In</a></li>
						        </ul>
						        </div>
					    	</div>
				    	</div>
					    <!-- Copyright -->
					    <div class="copyright">
					      	<div class="container clearfix">
					        	<p>Copyright &copy; 2017 - All Rights Reserved By Avarents</p>
					      	</div>
					    </div>
					</footer>
					<!-- Footer Section Ends -->
				</div>	
			</div>
		<!-- Back to Top -->
		<a href="javascript:void(0);" class="back-to-top"><i class="fa fa-long-arrow-up" aria-hidden="true"></i></a>
		<script src="<?php echo base_url().FRONT_THEME;?>js/jquery.validate.min.js"></script>
		<script src="<?php echo base_url().FRONT_THEME;?>js/additional-methods.js"></script>
		<script src="<?php echo base_url().FRONT_THEME;?>js/owl.carousel.js" type = "text/javascript"></script>
		<!-- wow -->
		<script src="<?php echo base_url().FRONT_THEME;?>js/wow.min.js" type = "text/javascript"></script>
		
		<!-- Fancybox  -->
		<script src="<?php echo base_url().FRONT_THEME;?>js/jquery.fancybox.js" type = "text/javascript"></script>
		<!-- 3D Slider -->
		<script src="<?php echo base_url().FRONT_THEME;?>js/modernizr.js" type = "text/javascript"></script>
		<!-- Map -->
		<script src="<?php echo base_url().FRONT_THEME;?>js/jquery-ui-1.11.1.js"></script>
		<script src="<?php echo base_url().FRONT_THEME;?>js/classie.js"></script>
	    <script src="<?php echo base_url().FRONT_THEME;?>js/jquery.flexslider.js"></script>
	    <script src="<?php echo base_url().FRONT_THEME;?>js/imagezoom.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url().FRONT_THEME;?>js/velocity.min.js"></script>
		<script src="<?php echo base_url().FRONT_THEME;?>js/element.js" type = "text/javascript"></script>
		<script src="<?php echo base_url().FRONT_THEME;?>js/facebook-login.js" type = "text/javascript"></script>
		<script src="<?php echo base_url().FRONT_THEME;?>js/register-login.js" type = "text/javascript"></script>
		<script src="https://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=AIzaSyBCKpfnLn74Hi2GBmTdmsZMJORZ5xyL1as" type = "text/javascript"></script> 
			<?php  if(isset($addJs) && !empty($addJs)):

			 		for($i = 0; count($addJs) > $i; $i++) :
			?>

					<script src="<?php echo base_url().FRONT_THEME.$addJs[$i];?>"></script>

			<?php 	endfor; 
				 endif;
			?>
			<?php if($this->session->flashdata('success') != null) :
			$msg = $this->session->flashdata('success'); ?>
				<script type="text/javascript">
				var msg = "<?php  echo $msg;?>";
					window.onload = function () {
	                 messageSession(msg);
	                };
				</script>
			<?php
			$this->session->set_flashdata('success', '');
			 endif; ?>

		<script type = "text/javascript">

			function initialize() {
				var input = document.getElementById('chooseCity');
				var autocomplete = new google.maps.places.Autocomplete(input);
				var input = document.getElementById('zip_cde');
				var autocomplete = new google.maps.places.Autocomplete(input);
			}
			google.maps.event.addDomListener(window, 'load', initialize);
		</script>
		<script>
		   	setTimeout(function() {
		      	$('.alert-danger').fadeOut('fast');
		      	$('.alert-success').fadeOut('fast');
		      	$('.alert-warning').fadeOut('fast');
			}, 500);
			$(".hideDiv").hide();

	function messageSession(msg){

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
	</script>
	</body>
</html>
