<!DOCTYPE html>

<html lang="en" class="h-100">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="keywords" content="" />
  <meta name="author" content="" />
  <meta name="robots" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="" />
  <meta property="og:title" content="" />
  <meta property="og:description" content="" />
  <meta property="og:image" content="" />
  <meta name="format-detection" content="telephone=no">

  <!-- PAGE TITLE HERE -->
  <title>
    <?php echo $this->config->item('site_name'); ?> | Login
  </title>

  <!-- FAVICONS ICON -->
  <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>assets/images/favicon.png" />
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/swiper.min.css">
  <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">

</head>


<body class="vh-100">
  <div class="authincation h-100" style="background: #fff">
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
                  <div class="text-center mb-3">
                    <a href="<?= base_url() ?>">
                      <img src="<?= base_url() ?>assets/images/logo.png"
                        alt="<?php echo $this->config->item('site_name'); ?>" style=""></a>
                  </div>
                  <h4 class="text-center mb-4">Sign in to continue to
                    <?= $this->config->item('site_name'); ?>
                  </h4>
                  
                   

                  <?php $error = $this->session->flashdata("error"); ?>
                  <div class="alert- alert-<?php echo $error ? 'danger' : 'info' ?> ">
                    <?php echo $error ? $error : '' ?>
                  </div>
<?php $uri = $this->uri->segment('1');?>
<!--<div class="mb-3 mb-0">
                                            <label class="radio-inline me-3"><input type="radio" name="optradio" <?php if($uri == 'teacherlogin'){ echo "selected";}?>> Teacher</label>
                                            <label class="radio-inline me-3"><input type="radio" name="optradio" <?php if($uri == 'studentlogin'){ echo "selected";}?> Student</label>
                                            <label class="radio-inline me-3"><input type="radio" name="optradio" <?php if($uri == 'employeelogin'){ echo "selected";}?> Employee</label>
                                        </div>-->
                  <?= form_open(); ?>

                  <?php $error = form_error("username", "<p class='text-danger'>", '</p>'); ?>
                  <div class="mb-3 <?php echo $error ? 'text-danger' : '' ?>">
                    <label class="mb-1"><strong>Email Id</strong></label>
                    <input id="email" type="email" class="form-control" name="username" value="<?= set_value("
                      username") ?>" autofocus>
                    <?= $error; ?>
                  </div>

                  <?php $error = form_error("password", "<p class='text-danger'>", '</p>'); ?>
                  <div class="mb-3 <?php echo $error ? 'text-danger' : '' ?>">
                    <label class="mb-1"><strong>Password</strong></label>
                    <input id="password" type="password" class="form-control " name="password">
                    <?= $error; ?>
                  </div>
                  <div class="mb-3">
                    <p>Forgot Password? <a class="text-primary" href="<?= base_url() ?>forgotpassword"> Reset </a></p>

                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-danger btn-block" style="background: #000;">Submit</button>
                  </div>
                  <?php echo form_close(); ?>


                  <div class="new-account mt-3">
                    <p>Don't have an account? <a class="text-danger" href="<?= base_url() ?>signup">Sign up</a></p>
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