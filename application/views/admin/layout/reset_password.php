<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1">


	
	<!-- PAGE TITLE HERE -->
	<title> <?= $title ?></title>
	
<link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>assets/images/favicon.png" />
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/swiper.min.css">
  <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">

</head>

<body class="vh-100">
    <div class="authincation h-100"  style="background: #f3f3f3">
        <div class="container h-100">
            
              <div class="row justify-content-center pt-30">

        <div class="swiper-container swiper-container-auto" data-slidesPerView="7" data-mobile-slidesPerView="2"
          data-tablet-slidesPerView="2" data-spaceBetween="20" data-loop="true" data-autoplay="true"
          data-auto-speed="2500" data-disable-on-touch="false" data-dots="true" data-auto-height="false"
          data-pagination="true" data-navigation="true">
          <div class="swiper-wrapper">
            <?php $leftas = leftsAds();

                        foreach ($leftas as $val) { ?>
            <div class="swiper-slide">

              <div class="client-item-02">

                <img src="<?= base_url() ?>upload/company/<?= $val->pic ?>" class="img-fluid img-fluid px-6">
                <!--<h6>
                  <?= $val->heading ?>
                </h6>-->
              </div>

            </div>
            <?php  } ?>
          </div>
        </div>
      </div>
      
            <div class="row justify-content-center h-100- align-items-center" style="height: 80%;">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
									<div class="text-center mb-3">
										<a href="<?= base_url()?>"><img src="<?= base_url()?>assets/images/logo.png" alt="careerxpert"></a>
									</div>
                                   

                              

                                <h4 class="text-center mb-4">Reset Password</h4>

                                
 
                          <?php 
                            $id =  $_GET['token'];
                         
                          $attributes = array('class' => '', 'id' => 'myform');
                         echo form_open_multipart("reset_password?token={$id}", $attributes);?>
             
  
              <?php $error = form_error("password", "<p class='text-danger'>", '</p>'); ?>
         <div class="mb-3 <?php echo $error ? 'text-danger' : '' ?>">
                   <div class="d-block">
                     <label for="password" class="control-label"><strong>Password *</strong></label>
                   </div>
                   <input id="password" type="password" class="form-control" name="password" placeholder="">
                  
                   <?= $error; ?>
                 
                 </div>
 
                 <?php $error = form_error("confirm_password", "<p class='text-danger'>", '</p>'); ?>
         <div class="mb-3 <?php echo $error ? 'text-danger' : '' ?>">
                   <div class="d-block">
                     <label for="confirm_password" class="control-label"><strong>Confirm Password *</strong></label>
                   </div>
                   <input id="confirm_password" type="password" class="form-control" name="confirm_password" placeholder="">
                  
                   <?= $error; ?>
                 
                 </div>

                                       
                    
                    <div class="text-center">
                        <button type="submit" class="btn btn-secondary btn-block"> Forgot Password</button>
                    </div>

                    <?php echo form_close(); ?>                           
                           

                    <div class="new-account mt-3">
                         <p> Already have an account? <a href="<?= base_url()?>user">Login</a> </p>
                         
                        
                    </div>

                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-center">

        <div class="swiper-container swiper-container-auto" data-slidesPerView="7" data-mobile-slidesPerView="2"
          data-tablet-slidesPerView="2" data-spaceBetween="20" data-loop="true" data-autoplay="true"
          data-auto-speed="2500" data-disable-on-touch="false" data-dots="true" data-auto-height="false"
          data-pagination="true" data-navigation="true">
          <div class="swiper-wrapper">
            <?php $rightsads = rightAds();
                        foreach ($rightsads as $val) { ?>
            <div class="swiper-slide">

              <div class="client-item-02">

                <img src="<?= base_url() ?>upload/company/<?= $val->pic ?>" class="img-fluid img-fluid px-6">
                <!--<h6>
                  <?= $val->heading ?>
                </h6>-->
              </div>

            </div>
            <?php  } ?>
          </div>
        </div>
      </div>
        </div>
    </div>


  <script src="<?= base_url() ?>assets/js/jquery-3.6.0.min.js"></script>
  <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
  <script src="<?= base_url() ?>assets/js/swiper.min.js"></script>
  <script src="<?= base_url() ?>assets/js/functions.js"></script>


  <script src="<?= base_url() ?>assets/vendor/global/global.min.js"></script>
  <script src="<?= base_url() ?>assets/js/custom.min.js"></script>
  <script src="<?= base_url() ?>assets/js/dlabnav-init.js"></script>
	
</body>
</html>