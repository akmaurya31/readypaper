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
	<title><?= $this->config->item('site_name'); ?> <?= $title ?></title>
	
<link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>assets/images/favicon.png" />
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/swiper.min.css">
  <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">

</head>

<body class="vh-100">
<div class="authincation h-100" style="background: #f3f3f3">
        <div class="container-fluid h-100">
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

         

                <div class="col-md-4">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
							<!--<div class="text-center mb-3">
										<a href="<?= base_url()?>">
										<img src="<?= base_url()?>assets/images/logo.jpg" alt="<?php echo $this->config->item('site_name'); ?>" style="width: 60%;"></a>
									</div>-->
                                <h1 class="text-center mb-2">OTP Verification</h1>

                                <?php $error_message = $this->session->flashdata("error_email_otp"); ?>
                                <div class="alert alert-<?php echo $error_message ? 'danger' : '' ?> ">
                                        <?php echo $error_message ? $error_message : '' ?>
                                </div>
                                
                                 

                            
                           <?php echo form_open(); ?> 
								<div class="row">
								 <h4 class="text-center- mb-4"><?= $getEmail->email?></h4>
									<div class="col-lg-12 col-md-12 col-12">
									<?php $error = form_error("otp", "<p class='text-danger'>", '</p>'); ?>  
                                    <div class="form-group mb-3 <?php echo $error ? 'has-error' : '' ?>">
										
                                            <input type="text" name="otp"  class="form-control" value="<?php echo set_value("otp") ?>" placeholder="Enter OTP" id="otp" class="form-control">
										</div>
                                        <?php echo $error; ?>
									</div>
									
									
									<div class="col-12">
										<div class="form-group button">
											<button type="submit" class="btn btn-secondary btn-block">Verify OTP </button>
										</div>
									</div>
								</div>
								<?php echo form_close(); ?>
                                 <div class="text-right pt-2">
                                        <a class="text-primary" href="<?= base_url()?>resend/<?= $this->uri->segment('2')?>">Resend Otp</a>
                                    </div>
                                 <br> 

                                    <div class="new-account">
                                        <p>Already have an account? <a class="text-primary" href="<?= base_url()?>administrator">Login</a></p>
                                   
                                        
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