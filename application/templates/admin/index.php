<?php
$my = $this->uri->segment('1');
if(!empty($this->uri->segment('2'))){

  $my = $this->uri->segment(2);
} 
$title = $product = $category = $user = $ownerActive = $customerActive = $categoryActive  = $productActive = $addCategoryActive = $dashboard = $adminFee = $adminFeeActive = $transaction = $transactionActive = $faqActive = $faq = $addfaqActive = $help = $helpActive =  '';

switch ($my) {
  case 'dashboard':
       $dashboard = "open active";
       $title = "Dashboard";

    break;
  case 'allOwners':
       $user = "open active";
       $title = "Owner List";
       $ownerActive = "active";
    break;
  case 'allCustomers':
       $user = "open active";
       $title = "Customer List";
       $customerActive = "active";
    break;
   case 'allCategory':
       $category = "open active";
       $title = "Category List";
       $categoryActive = "active";
    break; 
    case 'updateCategory':
       $category = "open active";
       $title = "Category Update";
       $categoryActive = "active";
    break;
     case 'addCategory':
        $category = "open active";
        $title = "Category Add";
        $addCategoryActive = "active";
    break;
    case 'allProduct':
       $product = "open active";
       $title = "Product List";
       $productActive = "active";
    break;  
   case 'productDetail':
       $product = "open active";
       $title = "Product Detail";
       $productActive = "active";
    break; 
    case 'adminFee':
       $adminFee = "open active";
       $title = "Admin Fee";
       $adminFeeActive = "active";
    break;
    case 'transaction':
       $transaction = "open active";
       $title = "Transaction List";
       $transactionActive = "active";
    break; 
    case 'allFaq':
       $faq = "open active";
       $title = "FAQ List";
       $faqActive = "active";
    break; 
    case 'faq':
       $faq = "open active";
       $title = "Add FAQ";
       $addfaqActive = "active";
    break;   
    case 'help':
       $help = "open active";
       $title = "Help and support";
       $helpActive = "active";
    break; 
    case 'helpList':
       $help = "open active";
       $title = "Help and support";
       $helpActive = "active";
    break;   
  
  default:
    $dashboard = "open active";
    break;
}
?>
<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="description" content="bootstrap admin template">
        <meta name="author" content="">
        <title>Admin | <?php echo $title;?></title>
        <link rel="apple-touch-icon" href="<?php echo base_url().ADMIN_THEME;?>assets/images/apple-touch-icon.png">
        <link rel="shortcut icon" href="<?php echo base_url().ADMIN_THEME;?>assets/images/favicon.png">
        <!-- Stylesheets -->
        <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/css/bootstrap-extend.min.css">
        <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>assets/css/site.min.css">        
        <!-- Plugins -->
       <!--  <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/vendor/filament-tablesaw/tablesaw.css"> -->
        <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/vendor/animsition/animsition.css">
        <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/vendor/asscrollable/asScrollable.css">
        <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/vendor/switchery/switchery.css">
        <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/vendor/intro-js/introjs.css">
        <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/vendor/slidepanel/slidePanel.css">
        <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/vendor/flag-icon-css/flag-icon.css">
        <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/vendor/waves/waves.css">
        <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/vendor/magnific-popup/magnific-popup.css">
          <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>assets/examples/css/advanced/lightbox.css">
        <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>assets/examples/css/pages/profile.css">
        <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/vendor/chartist-js/chartist.css">
        <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/vendor/jvectormap/jquery-jvectormap.css">
        <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css">
        <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>assets/examples/css/dashboard/v1.css">
        <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/vendor/bootstrap-datepicker/bootstrap-datepicker.css">
        <link rel="stylesheet" href="   <?php echo base_url().ADMIN_THEME;?>assets/examples/css/structure/chat.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">

        <?php if(isset($addCss)) { 
            for($i = 0; $i < count($addCss); $i++){  ?>
                <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME.$addCss[$i];?>">      
        <?php } 
        }  ?>

          <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/vendor/owl-carousel/owl.carousel.css">
          <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/vendor/slick-carousel/slick.css">
          <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>assets/examples/css/uikit/carousel.css">

        <!-- Fonts -->
        <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/fonts/material-design/material-design.min.css">
        <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/fonts/brand-icons/brand-icons.min.css">
        <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>global/fonts/font-awesome/font-awesome.min.css">
        <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
        <link rel="stylesheet" href="<?php echo base_url().ADMIN_THEME;?>assets/examples/css/pages/gallery.css">
        <!--[if lt IE 9]>
        <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/html5shiv/html5shiv.min.js"></script>
        <![endif]-->
        <!--[if lt IE 10]>
        <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/media-match/media.match.min.js"></script>
        <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/respond/respond.min.js"></script>
        <![endif]-->
        <!-- Scripts -->
        <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/modernizr/modernizr.js"></script>
        <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/breakpoints/breakpoints.js"></script>
        <script>
            Breakpoints();
        </script>

        <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/jquery/jquery.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/additional-methods.js"></script>




    </head>
<body class="dashboard page-profile">
    <!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <nav class="site-navbar navbar navbar-inverse navbar-fixed-top navbar-mega" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle hamburger hamburger-close navbar-toggle-left hided"
                data-toggle="menubar">
                <span class="sr-only">Toggle navigation</span>
                <span class="hamburger-bar"></span>
            </button>
            <button type="button" class="navbar-toggle collapsed" data-target="#site-navbar-collapse"
                data-toggle="collapse">
                <i class="icon md-more" aria-hidden="true"></i>
            </button>
            <div class="navbar-brand navbar-brand-center">
                <img class="navbar-brand-logo" src="<?php echo base_url().ADMIN_THEME;?>assets/images/adminlogo2.png" title="">
                <span class="navbar-brand-text hidden-xs"> Admin</span>
            </div>
            <button type="button" class="navbar-toggle collapsed" data-target="#site-navbar-search"
                data-toggle="collapse">
                <span class="sr-only">Toggle Search</span>
                <i class="icon md-search" aria-hidden="true"></i>
            </button>
        </div>
        <div class="navbar-container container-fluid">
            <!-- Navbar Collapse -->
            <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
                <!-- Navbar Toolbar -->
                <ul class="nav navbar-toolbar">
                    <li class="hidden-float" id="toggleMenubar">
                        <a data-toggle="menubar" href="#" role="button">
                            <i class="icon hamburger hamburger-arrow-left">
                                <span class="sr-only">Toggle menubar</span>
                                <span class="hamburger-bar"></span>
                            </i>
                        </a>
                    </li>
                    <li class="hidden-xs" id="toggleFullscreen">
                        <a class="icon icon-fullscreen" data-toggle="fullscreen" href="#" role="button">
                            <span class="sr-only">Toggle fullscreen</span>
                        </a>
                    </li>
                </ul>
                <!-- End Navbar Toolbar -->
                <!-- Navbar Toolbar Right -->
                <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
                    <li class="dropdown">
                        <a class="navbar-avatar dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false"
                            data-animation="scale-up" role="button">
                            <span class="avatar avatar-online">
                                <img src="<?php echo base_url().ADMIN_THEME;?>global/portraits/5.jpg" alt="...">
                                <i></i>
                            </span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li role="presentation">
                                <a href="<?php echo site_url();?>dashboard/adminProfile/<?php echo $this->session->userdata('id');?>" role="menuitem"><i class="icon md-account" aria-hidden="true"></i> Profile</a>
                            </li>

                            <li role="presentation">
                                <a href="<?php echo site_url();?>dashboard/changePassword/<?php echo $this->session->userdata('id');?>" role="menuitem"><i class="icon md-card" aria-hidden="true"></i> Change Password</a>
                            </li>
                            <!-- <li role="presentation">
                                <a href="javascript:void(0)" role="menuitem"><i class="icon md-settings" aria-hidden="true"></i> Settings</a>
                            </li> -->
                            <li class="divider" role="presentation"></li>
                            <li role="presentation">
                                <a href="<?php echo base_url();?>dashboard/logout" role="menuitem"><i class="icon md-power" aria-hidden="true"></i> Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- End Navbar Toolbar Right -->
            </div>
            <!-- End Navbar Collapse -->
        </div>
    </nav>
    <div class="site-menubar">

       <div class="site-menubar-body">
            <div>
                <div>
                    <ul class="site-menu">
<!--                         <li class="site-menu-category">General</li>
 -->                        <li class="site-menu-item <?php echo $dashboard; ?>">
                            <a class="animsition-link" href="<?php echo base_url();?>dashboard">
                                <i class="site-menu-icon md-view-dashboard" aria-hidden="true"></i>
                                <span class="site-menu-title">Dashboard</span>
                            </a>
                        </li>
                        <li class="site-menu-item has-sub <?php echo $user; ?>">
                            <a href="javascript:void(0)">
                                <i class="site-menu-icon icon md-account" aria-hidden="true"></i>
                                    <span class="site-menu-title">Users</span>
                                <span class="site-menu-arrow"></span>
                            </a>
                            <ul class="site-menu-sub">
                                <li class="site-menu-item has-sub <?php echo $ownerActive;?>">
                                    <a href="<?php echo base_url();?>user/allOwners">
                                        <span class="site-menu-title">All Owner</span>
                                        <span class="site-menu-arrow"></span>
                                    </a>
                                </li>
                                <li class="site-menu-item has-sub <?php echo $customerActive;?>">
                                    <a href="<?php echo base_url();?>user/allCustomers">
                                        <span class="site-menu-title">All Customer</span>
                                        <span class="site-menu-arrow"></span>
                                    </a>
                                </li>             
                            </ul>
                        </li>
                        <li class="site-menu-item has-sub <?php echo $category; ?>">
                            <a href="javascript:void(0)">
                                <i class="site-menu-icon icon md-account" aria-hidden="true"></i>
                                    <span class="site-menu-title">Category</span>
                                <span class="site-menu-arrow"></span>
                            </a>
                            <ul class="site-menu-sub">
                                <li class="site-menu-item has-sub <?php echo $categoryActive;?>">
                                    <a href="<?php echo base_url();?>user/allCategory">
                                        <span class="site-menu-title">All Category</span>
                                        <span class="site-menu-arrow"></span>
                                    </a>
                                </li>     
                                <li class="site-menu-item has-sub <?php echo $addCategoryActive;?>">
                                    <a href="<?php echo base_url();?>user/addCategory">
                                        <span class="site-menu-title">Add New Category</span>
                                        <span class="site-menu-arrow"></span>
                                    </a>
                                </li>             
                            </ul>
                        </li>
                        <li class="site-menu-item has-sub <?php echo $adminFee; ?>">
                            <a href="javascript:void(0)">
                                <i class="site-menu-icon md-google-pages" aria-hidden="true"></i>
                                    <span class="site-menu-title">Admin Fee</span>
                                <span class="site-menu-arrow"></span>
                            </a>
                            <ul class="site-menu-sub">
                                <li class="site-menu-item has-sub <?php echo $adminFeeActive;?>">
                                    <a href="<?php echo base_url();?>adminFee">
                                        <span class="site-menu-title">Admin Fee</span>
                                        <span class="site-menu-arrow"></span>
                                    </a>
                                </li>
                                                            
                            </ul>
                        </li>

                           <li class="site-menu-item has-sub <?php echo $help; ?>">
                            <a href="javascript:void(0)">
                                <i class="site-menu-icon icon md-account" aria-hidden="true"></i>
                                    <span class="site-menu-title">Help and support</span>
                                <span class="site-menu-arrow"></span>
                            </a>
                            <ul class="site-menu-sub">
                                <li class="site-menu-item has-sub <?php echo $helpActive;?>">
                                    <a href="<?php echo base_url('help');?>">
                                        <span class="site-menu-title">Help and support</span>
                                        <span class="site-menu-arrow"></span>
                                    </a>
                                </li>     
                                         
                            </ul>
                        </li>
                        <li class="site-menu-item has-sub <?php echo $product; ?>">
                            <a href="javascript:void(0)">
                                <i class="site-menu-icon md-google-pages" aria-hidden="true"></i>
                                    <span class="site-menu-title">Products</span>
                                <span class="site-menu-arrow"></span>
                            </a>
                            <ul class="site-menu-sub">
                                <li class="site-menu-item has-sub <?php echo $productActive;?>">
                                    <a href="<?php echo base_url();?>user/allProduct">
                                        <span class="site-menu-title">All Product</span>
                                        <span class="site-menu-arrow"></span>
                                    </a>
                                </li>                               
                            </ul>
                        </li>

                        <li class="site-menu-item has-sub <?php echo $faq; ?>">
                            <a href="javascript:void(0)">
                                <i class="site-menu-icon icon md-account" aria-hidden="true"></i>
                                    <span class="site-menu-title">FAQ</span>
                                <span class="site-menu-arrow"></span>
                            </a>
                            <ul class="site-menu-sub">
                                <li class="site-menu-item has-sub <?php echo $faqActive;?>">
                                    <a href="<?php echo base_url();?>faq/allFaq">
                                        <span class="site-menu-title">All FAQ</span>
                                        <span class="site-menu-arrow"></span>
                                    </a>
                                </li>     
                                <li class="site-menu-item has-sub <?php echo $addfaqActive;?>">
                                    <a href="<?php echo base_url();?>faq">
                                        <span class="site-menu-title">Add New FAQ</span>
                                        <span class="site-menu-arrow"></span>
                                    </a>
                                </li>             
                            </ul>
                        </li>
                       
                        <li class="site-menu-item has-sub <?php echo $transaction; ?>">
                            <a href="javascript:void(0)">
                                <i class="site-menu-icon md-google-pages" aria-hidden="true"></i>
                                    <span class="site-menu-title">Transaction</span>
                                <span class="site-menu-arrow"></span>
                            </a>
                            <ul class="site-menu-sub">
                                <li class="site-menu-item has-sub <?php echo $transactionActive;?>">
                                    <a href="<?php echo base_url();?>transaction">
                                        <span class="site-menu-title">All Transaction</span>
                                        <span class="site-menu-arrow"></span>
                                    </a>
                                </li>                               
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="site-gridmenu">
        <div><div>
        </div></div>
    </div>
    <?php echo $template['body']; ?>
    <!-- Footer -->
    <footer class="site-footer">
        <div class="site-footer-legal">© <?php echo date('Y');?> <a href="<?php echo base_url();?>dashboard">Ava</a></div>
        <!-- <div class="site-footer-right">
            <i class="red-600 icon md-favorite"></i>
        </div> -->
    </footer>
    <!-- Core  -->
    
    <!-- Plugins -->
    <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/chartist-js/chartist.min.js"></script>
    <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.min.js"></script>
    <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/jvectormap/maps/jquery-jvectormap-world-mill-en.js"></script>
    <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/matchheight/jquery.matchHeight-min.js"></script>
    <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/peity/jquery.peity.min.js"></script>
    <!-- Scripts -->
    <!--<script src="<?php echo base_url().ADMIN_THEME;?>global/js/components/matchheight.js"></script>-->
    <script src="<?php echo base_url().ADMIN_THEME;?>global/js/components/jvectormap.js"></script>
    <script src="<?php echo base_url().ADMIN_THEME;?>global/js/components/peity.js"></script>
    <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/filament-tablesaw/tablesaw.js"></script>
    <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/filament-tablesaw/tablesaw-init.js"></script>
    

    <script src="<?php echo base_url().ADMIN_THEME;?>assets/examples/js/dashboard/v1.js"></script>
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
  <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/isotope/isotope.min.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
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
  <script src="<?php echo base_url().ADMIN_THEME;?>global/js/components/filterable.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>assets/examples/js/pages/gallery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/js/plugins/responsive-tabs.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/js/components/bootstrap-datepicker.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>assets/examples/js/advanced/lightbox.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/owl-carousel/owl.carousel.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>global/vendor/slick-carousel/slick.js"></script>
    <script src="<?php echo base_url().ADMIN_THEME;?>global/js/components/owl-carousel.js"></script>
  <script src="<?php echo base_url().ADMIN_THEME;?>assets/examples/js/uikit/carousel.js"></script>

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
</body>
</html>
