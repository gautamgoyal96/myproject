<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="bootstrap admin template">
  <meta name="author" content="">
  <title>Admin | Login</title>
  <link rel="apple-touch-icon" href="<?php echo base_url().ADMIN_THEME;?>assets/images/apple-touch-icon.png">
  <link rel="shortcut icon" href="<?php echo base_url().ADMIN_THEME;?>assets/images/favicon.ico">
  <!-- Stylesheets -->
  <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/css/bootstrap-extend.min.css">
  <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>assets/css/site.min.css">
  <!-- Plugins -->
  <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/vendor/animsition/animsition.css">
  <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/vendor/asscrollable/asScrollable.css">
  <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/vendor/switchery/switchery.css">
  <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/vendor/intro-js/introjs.css">
  <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/vendor/slidepanel/slidePanel.css">
  <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/vendor/flag-icon-css/flag-icon.css">
  <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/vendor/waves/waves.css">
  <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>assets/examples/css/pages/login-v3.css">
  <!-- Fonts -->
  <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/fonts/material-design/material-design.min.css">
  <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/fonts/brand-icons/brand-icons.min.css">
  <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
  <!--[if lt IE 9]>
    <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
  <!--[if lt IE 10]>
    <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/media-match/media.match.min.js"></script>
    <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/respond/respond.min.js"></script>
    <![endif]-->
  <!-- Scripts -->
  <style type="text/css">
     input:-webkit-autofill,
input:-webkit-autofill:hover, 
input:-webkit-autofill:focus
input:-webkit-autofill, 
textarea:-webkit-autofill,
textarea:-webkit-autofill:hover
textarea:-webkit-autofill:focus,
select:-webkit-autofill,
select:-webkit-autofill:hover,
select:-webkit-autofill:focus {
  transition: background-color 5000s ease-in-out 0s !important;
  -webkit-text-fill-color: #0000 !important;
}

  </style>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/modernizr/modernizr.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/breakpoints/breakpoints.js"></script>
  <script>
  Breakpoints();
  </script>
</head>
<body class="page-login-v3 layout-full">
  <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
  <!-- Page -->
  <div class="page animsition vertical-align text-center" data-animsition-in="fade-in"
  data-animsition-out="fade-out">>
    <div class="page-content vertical-align-middle">
      <div class="panel">
        <div class="panel-body">
          <div class="brand">
            <img class="brand-img" src="<?php echo base_url().ADMIN_THEME;?>assets/images/adminlogo.png" alt="...">
<!--             <h2 class="brand-text font-size-18">Login</h2>
 -->            <?php if(!empty($error)):?>                            
              <div class="alert dark alert-icon alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <?php echo $error;?>
              </div>
            <?php endif;?>
          </div>
          <form method="post" action="" autocomplete="off">
            <div class="form-group form-material floating">
              <input type="email" class="form-control" name="email" value="<?php echo $this->input->cookie('email', TRUE); ?>" autcomplete="off" />
              <label class="floating-label">Email</label>
            </div>
            <div class="form-group form-material floating">
              <input type="password" class="form-control" name="password" value="<?php echo $this->input->cookie('password', TRUE); ?>" autcomplete="off"  />
              <label class="floating-label">Password</label>
            </div>
            <div class="form-group clearfix">
              <div class="checkbox-custom checkbox-inline checkbox-primary checkbox-lg pull-left">
                <input type="checkbox" id="inputCheckbox" name="rem" value="1" <?php if($this->input->cookie('email',true)){ ?>checked <?php } ?> >
                <label for="inputCheckbox">Remember me</label>
              </div>
              <!-- <a class="pull-right" href="forgot-password.html">Forgot password?</a> -->
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-lg margin-top-40">Sign in</button>
          </form>
          <!-- <p>Still no account? Please go to <a href="register-v3.html">Sign up</a></p> -->
        </div>
      </div>
      <footer class="page-copyright page-copyright-inverse">
        <!-- <p>WEBSITE BY amazingSurge</p> -->
        <p>© <?php echo date('Y');?> All RIGHT RESERVED.</p>
        <!-- <div class="social">
          <a class="btn btn-icon btn-pure" href="javascript:void(0)">
            <i class="icon bd-twitter" aria-hidden="true"></i>
          </a>
          <a class="btn btn-icon btn-pure" href="javascript:void(0)">
            <i class="icon bd-facebook" aria-hidden="true"></i>
          </a>
          <a class="btn btn-icon btn-pure" href="javascript:void(0)">
            <i class="icon bd-google-plus" aria-hidden="true"></i>
          </a>
        </div> -->
      </footer>
    </div>
  </div>
  <!-- End Page -->
  <!-- Core  -->
  <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/jquery/jquery.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/bootstrap/bootstrap.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/animsition/animsition.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/asscroll/jquery-asScroll.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/mousewheel/jquery.mousewheel.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/asscrollable/jquery.asScrollable.all.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/waves/waves.js"></script>
  <!-- Plugins -->
  <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/switchery/switchery.min.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/intro-js/intro.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/screenfull/screenfull.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/slidepanel/jquery-slidePanel.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/jquery-placeholder/jquery.placeholder.js"></script>
  <!-- Scripts -->
  <script src="<?php echo base_url().ADMIN_THEME;?>global/js/core.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>assets/js/site.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>assets/js/sections/menu.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>assets/js/sections/menubar.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>assets/js/sections/gridmenu.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>assets/js/sections/sidebar.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/js/configs/config-colors.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>assets/js/configs/config-tour.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/js/components/asscrollable.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/js/components/animsition.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/js/components/slidepanel.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/js/components/switchery.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/js/components/tabs.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/js/components/jquery-placeholder.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/js/components/material.js"></script>
  <script>
  (function(document, window, $) {
    'use strict';
    var Site = window.Site;
    $(document).ready(function() {
      Site.run();
    });
  })(document, window, jQuery);
  </script>
  <script>
    $(document).ready(function(){
        window.setTimeout(function() {
            $(".alert-danger").fadeTo(1500, 0).slideUp(500, function(){
                $(this).remove(); 
            });
        }, 5000);
    });
</script> 
</body>
</html>
