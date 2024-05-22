<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?= @$title ?></title>
        <meta name="description" content="<?= @$description ?>" />
        <meta name="keywords" content="<?= @$keyword ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Place favicon.ico in the root directory -->
        <link rel="shortcut icon" href="images/logo/favicon.png" type="image/x-icon">

        <!-- All css here -->
        <link rel="stylesheet" href="<?= base_url()?>assets/frantweb/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/frantweb/css/fontawesome-all.min.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/frantweb/css/nice-select.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/frantweb/css/aos.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/frantweb/css/animate.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/frantweb/css/slick.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/frantweb/css/jquery.fancybox.min.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/frantweb/css/meanmenu.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/frantweb/css/all-animations.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/frantweb/css/default.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/frantweb/css/style.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/frantweb/css/responsive.css">
          <link rel="stylesheet" href="<?= base_url(); ?>assets/css/swiper.min.css">
          <style>
          .main-menu ul li .mega-menu.mega-dropdown-menu {
    top: 100%;
}
          </style>
    </head>
    <body>
      
        <!--<div id="preloader">
            <div id="loading">
                <div id="loading-center">
                    <div id="loading-center-absolute">
                        <div class="object" id="object_one"></div>
                        <div class="object" id="object_two"></div>
                        <div class="object" id="object_three"></div>
                    </div>
                </div>
            </div>
        </div>-->
     
       
        <header>
            <div id="header-sticky" class="transparent-header header-area home2 home4 home5 white-color-header">
                <div class="header">
                    <div class="container-fluid">
                        <div class="row align-items-center justify-content-between position-relative">
                            <div class="col-xl-3 col-lg-2 col-md-3 col-sm-5 col-6">
                                <div class="logo">
                                    <?php logo()?>
                                   <!-- <a href="" class="d-block"><img src="<?= base_url()?>assets/baba.png"></a>-->
                                </div>
                            </div><!-- /col -->
                            <div class="col-xl-8 col-lg-8 col-md-1 col-sm-0 col-0 d-none d-lg-flex justify-content-end position-static">
                                <div class="main-menu">
                                    <nav id="mobile-menu">
                                        <ul class="d-block">
                                            <li><a class="active" href="<?= base_url()?>">Home</a></li>
                                            <li><a class="active-" href="<?= base_url()?>about-us">About Us</a></li>
                                            <li><a class="active" href="<?= base_url()?>price">Plan</a></li>
                                            
                                             
                                            <li><a class="active-" href="<?= base_url()?>contact-us">Contact Us</a></li>
                                            <li><a href="javascript:;">Demo Pepar</a>
                                                <ul class="mega-menu mega-dropdown-menu white-bg ml-0">
                                                    <li><a target="_blank" href="<?= base_url()?>assets/pdf/question_pepar.pdf">Question Pepar </a></li>
                                                    <li><a target="_blank" href="<?= base_url()?>assets/pdf/answer.pdf">Answer Pepar </a></li>
                                                </ul>
                                            </li>
                                             <?php 
                                      $name = $this->session->userdata('firstName');
                                      $role = $this->session->userdata('role');
                                      if($role=='teacher'){?>
                                      
                                      
                                            <li>
                                                <a class="d-inline-block main-color" href="<?= base_url()?>teacher_dashboard" data-toggle="tooltip" data-selector="true" data-placement="bottom" title="Dashboard">
                                                <?= $name?></a>
                                            </li>
                                     
                                        
                                        <?php }else if($role=='employee'){?>
                                        
                                       
                                            <li>
                                                <a class="d-inline-block main-color" href="<?= base_url()?>employee_dashboard" data-toggle="tooltip" data-selector="true" data-placement="bottom" title="Dashboard">
                                                <?= $name?></a>
                                            </li>
                                     
                                        <?php } else if($role=='super_employee'){?>
                                        
                                      
                                            <li>
                                                <a class="d-inline-block main-color" href="<?= base_url()?>super_dashboard" data-toggle="tooltip" data-selector="true" data-placement="bottom" title="Dashboard">
                                                <?= $name?></a>
                                            </li>
                                     
                                        
                                        <?php }  else if($role=='admin'){?>
                                        
                                       
                                            <li>
                                                <a class="d-inline-block main-color" href="<?= base_url()?>dashboard" data-toggle="tooltip" data-selector="true" data-placement="bottom" title="Dashboard">
                                                <?= $name?></a>
                                            </li>
                                      
                                        
                                        <?php }else{?>
                                           <li>
                                            <a href="<?= base_url()?>teacherlogin" class="btn transparent-bg" style="border: 1px solid;">Login</a>
                                        </li><!-- /Sign Up -->
                                        <?php } ?>

                                        </ul>
                                    </nav>
                                </div><!-- /main-menu -->
                            </div><!-- /col -->
                            
                            
                            <div class="col-xl-1 col-lg-1 col-md-8 col-sm-7 col-4">
                                <div class="header-right d-flex align-items-center justify-content-end">

                                        <div class="d-block d-lg-none pl-20">
                                            <a class="mobile-menubar theme-color" href="javascript:void(0);"><i class="far fa-bars"></i></a>
                                        </div><!-- /mobile-menubar -->
                                        
                                        
                                    <div class="col-xl-4  col-lg-9  col-md-5  col-sm-12 col-12 pl-0 d-none">
                                        <div class="header-right-right-content text-right d-flex align-items-center justify-content-end">
                                          
                                            <div class="d-block d-lg-none pl-3">
                                                <a class="mobile-menubar theme-color" href="javascript:void(0);"><i class="far fa-bars"></i></a>
                                            </div><!-- /mobile-menubar -->
                                        </div><!-- /header-right-left-content -->
                                    </div><!-- /col -->
                                </div><!-- /header-right -->
                            </div><!-- /col -->
                        </div><!-- /row -->
                    </div><!-- /container -->
                </div>
            </div><!-- /header-bottom -->
        </header>
        <!--  header-area-end  -->


        <div class="side-mobile-menu white-bg pt-10 pb-30 pl-35 pr-30 pb-100">
            <div class="d-fle justify-content-between w-100">
                <div class="close-icon d-inline-block float-right clear-both mt-15 mb-10">
                    <a href="javascript:void(0);"><span class="icon-clear theme-color"><i class="fa fa-times"></i></span></a>
                </div>
            </div>
          

            <div class="mobile-menu mt-50 w-100"></div>
            <ul class="social-link pt-85 clear-both">
                <li class="d-inline-block">
                    <a class="facebook-color text-center pr-15 d-inline-block transition-3" href="#"><i class="fab fa-facebook-f"></i></a>
                </li>
                <li class="d-inline-block">
                    <a class="twitter-color text-center pr-15 d-inline-block transition-3" href="#"><i class="fab fa-twitter"></i></a>
                </li>
                <li class="d-inline-block">
                    <a class="google-plus-color text-center pr-15 d-inline-block transition-3" href="#"><i class="fab fa-google-plus-g"></i></a>
                </li>
                <li class="d-inline-block">
                    <a class="linked-in-color text-center d-inline-block transition-3" href="#"><i class="fab fa-linkedin-in"></i></a>
                </li>
            </ul><!-- social-link -->

            <!-- mobile phone area -->
            <div class="mobile-phone-contact phone-contact mt-30 mb-30">
                <h6 class="f-500 mb-0 d-inline-block pr-2">Call Us</h6>
              <?php mobile()?>
            </div><!-- /mobile phone area -->
        </div><!-- /side-mobile-menu -->
        <div class="body-overlay"></div>