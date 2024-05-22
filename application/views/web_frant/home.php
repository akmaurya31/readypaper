<!--<div class="slider-area mt-100">
    <div id="carouselExample" class="carousel slide">
        <div class="carousel-inner">
            <?php $i=1;foreach($getSlider as $val){?>
            <div class="carousel-item active">
                <img src="<?= base_url()?>upload/slider/<?= $val->slider_image?>" class="d-block w-100 paika-hight" alt="..." >
            </div>
            <?php $i++;}?>
        </div>

    </div>
</div>-->

<div class="blog-image mt-100 slider-area">
            <div class="swiper-container swiper-container-auto" data-slidesPerView="1" data-mobile-slidesPerView="1" data-tablet-slidesPerView="2" data-spaceBetween="20" data-loop="true" data-autoplay="true" data-auto-speed="2000" data-disable-on-touch="false" data-dots="true" data-auto-height="false" data-pagination="true" data-navigation="true">
            <div class="swiper-wrapper">
           
              
               <?php $i=1;foreach($getSlider as $val){?>
           <div class="swiper-slide">
                <img src="<?= base_url()?>upload/slider/<?= $val->slider_image?>" class="img-fluid rounded paika-hight" alt="..." >
            </div>
            <?php $i++;}?>
            
            </div>
          </div>
          </div>

<div class="categories-area pb-20">
    <div class="container-fluid">

        <div class="home2-category-wrapper- mt-0 over-hidden">
           <div class="row justify-content-center">

        <div class="swiper-container swiper-container-auto" data-slidesPerView="7" data-mobile-slidesPerView="2"
          data-tablet-slidesPerView="2" data-spaceBetween="20" data-loop="true" data-autoplay="true"
          data-auto-speed="2500" data-disable-on-touch="false" data-dots="true" data-auto-height="false"
          data-pagination="true" data-navigation="true">
          <div class="swiper-wrapper">
                <?php foreach($getSchoolAds as $val){?>
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
        </div><!-- /container -->
    </div>
</div>




<div class="facts-area home3  pt-45 pb-35">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-9 col-md-10 col-sm-11 col-12">
                <div class="title text-center mb-30">
                    <h1 class="mb-20 "><span class="f-700 text-danger">Online </span> Exam & Pepar <span class="f-700 text-danger">Software
                        </span></h1>

                </div><!-- /title -->
            </div>
        </div><!-- /row -->



        <div class="row single-intro-service-wrapper  justify-content-center">

            <?php $i=1;
       foreach($getProduct as $val){?>
      
            <div class="col-xl-7  col-lg-7  col-md-7  col-sm-12 col-12">
                <div class="single-intro-content  white-bg transition5 mb-30 tilt">
               
                    <div class="intro-service-text">
                        <h3 class="mb-10 text-center">
                            <?= $val->heading?>
                        </h3>
                        <?= $val->content?>
                        <div class="my-btn d-inline-block">
                            <a href="<?= base_url()?>contact-us" class="btn transparent-bg">View Details</a>
                        </div>
                    </div>
                </div><!-- <?//= base_url().'product/'.preg_replace('/\s+/', '-', str_replace('%', ' ',@$val->heading));?>/single-service-content -->
            </div>
            
                 <div class="col-xl-5  col-lg-5  col-md-5">
                        <img src="<?= base_url()?>upload/<?= $val->bg_images?>" alt="">
                    </div>
       
           
            
            <?php $i++; } ?>
        </div>

    </div>
</div>


 

<?php if($getSchool){?>
<div class="categories-area pt-60 ">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-11 col-12">
                <div class="title text-center">
                    <h2 class="mb-30">ReadyPaper is Trusted by 450+ Schools Of India</h2>
                </div>
            </div>
        </div><!-- /row -->
    </div><!-- /container -->

    <div class="home2-category-wrapper- mt-25 over-hidden">
        <div class="row home2-category-active align-items-end pb-65">
            <?php foreach($getSchool as $value){?>
            <div class="col-xl-3  col-lg-3  col-md-12  col-sm-12 col-12 home2-category-height-paika">
                <div
                    class="single-categories hm2-single-course-category hm2-single-cat-bg1 text-center w-100 position-relative">
                    <img class="w-100" src="<?= base_url()?>upload/<?= $value->pic?>" alt="category-image01">
                    <div class="single-hm2-cate-content position-absolute bottom-0 left-0 right-0 z-index1 ">
                        <h3>
                            <a class="text-white text-uppercase" href="">
                                <?= $value->heading?>
                            </a>
                        </h3>
                        <!--<span class="text-white mb-2 d-block text-uppercase">22 Course</span>
                                <p class="text-white mb-0">Dolor sit amet, consectetur adip isicing nsect</p>-->
                    </div>
                </div><!-- /single-category -->
            </div>
            <?php } ?>


        </div><!-- /row -->
    </div><!-- /container -->
</div>
<?php } ?>


        <!--<div class="about-page2-fact-bg position-absolute w-100 h-100 z-index-1 " style="background: #eae3b5;"></div>-->
        
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-xl-7 col-lg-9 col-md-10 col-sm-12 col-12">
                            <div class="title text-center mb-30">
                                <h2 class="mt-30 mb-20"><span class="f-700">Select a Packages</span></h2>
                                   </div><!-- /title -->
                        </div><!-- /col -->
                    </div><!-- /row -->

                      <div class="row package-wrapper justify-content-center ">
                      <?php $i=1;foreach($getPlan as $val){
                      if($i==1){ $color="danger";}elseif($i==2){ $color="info"; }else{ $color="success";}
                      ?>
                        <div class="col-xl-4  col-lg-4  col-md-6  col-sm-10 col-12"> 
                            <div class="single-packages white-bg transition5 text-center pt-35 pb-35 mb-30">
                                <div class="price-header mb-20">
                                    <h2 class="mb-2 text-<?= $color?>"><?= $val->heading?></h2>
                                    
                                </div>
                                <div class="price mb-20 primary-border-bottom primary-border-top pl-30 pr-30 bg-<?= $color?>">
                                    <div class="  price-bg<?//= $i?> pt-15- pb-10-">
                                        <h4 class="mb-0 text-white ">₹<?= $val->price?><span style="font-size: 18px;"> (<?= $val->validity?> Month)</span></h4>
                                  
                                    </div>
                                </div>
                                <div class="price-list-wrapper pl-30 pr-30">
                                    <ul class="price-item-list text-left w-100 pb-3">
                                       <?php $list = subject_list_teacher($val->heading);
                                       foreach($list as $value){?>
                                        <li class="d-inline-block d-flex align-items-center">
                                            <span class="primary-color d-block pr-15">
                                                <span class="d-inline-block"><i class="fa fa-check-circle text-<?= $color?>"></i></span>
                                            </span>
                                            <p class="main-color mb-0"><?= subjectName($value->subject_id)?></p>
                                        </li>
                                        <?php } ?>
                                        <li class="d-inline-block d-flex align-items-center">
                                            <span class="primary-color d-block pr-15">
                                                <span class="d-inline-block"><i class="fa fa-check-circle text-<?= $color?>"></i></span>
                                            </span>
                                            <p class="main-color mb-0">Paper Quantity <?= $val->pepar_qty?></p>
                                        </li>
                                        <li class="d-inline-block d-flex align-items-center">
                                            <span class="primary-color d-block pr-15">
                                                <span class="d-inline-block"><i class="fa fa-check-circle text-<?= $color?>"></i></span>
                                            </span>
                                            <p class="main-color mb-0">Validity  <?= $val->validity?> Month</p>
                                        </li>
                                        <li class="d-inline-block d-flex align-items-center">
                                            <span class="primary-color d-block pr-15">
                                                <span class="d-inline-block"><i class="fa fa-check-circle text-<?= $color?>"></i></span>
                                            </span>
                                            <p class="main-color mb-0">Plan Expired   <?= date('d M, Y',strtotime($val->end_date))?></p>
                                        </li>
                                    </ul>
            
                                    <div class="my-btn d-block bg-<?= $color?>">
                                        <?php $role = $this->session->userdata('role');
                                        if($role=='teacher'){?>
                                            <?php $attributes = array('class' => 'default-form', 'id' => 'myform');
                                   echo form_open_multipart("buynow", $attributes);?>
                                   
                                           <input name="plangst" id="plangst" type="hidden" value="<?= $val->gst?>" >
                                            <input name="planprice" id="planprice" type="hidden" value="<?= $val->plan_price?>" >
                                            
                                          <input name="amount" id="amount" type="hidden" value="<?= $val->price?>" >
                                          <input name="plan_name" id="plan_name" type="hidden" value="<?= $val->heading?>" >
                                          <input name="plan_id" id="plan_id" type="hidden" value="<?= $val->id?>" >
                                          
                                          <input name="plan_start_date" id="plan_start_date" type="hidden" value="<?= $val->start_date?>" >
                                          <input name="plan_end_date" id="plan_end_date" type="hidden" value="<?= $val->end_date?>" >
                                          <input name="plan_validity" id="plan_validity" type="hidden" value="<?= $val->validity?>" >
                                          <input name="plan_pepar_qty" id="plan_pepar_qty" type="hidden" value="<?= $val->pepar_qty?>" >
                                          
                                       <!-- <input type="button" class="btn btn-success" onclick="getpayment()" value="Buy">-->
                                       <input type="submit" class="btn btn-info btn-fill btn-wd"  name="submit_button" id="submit_button" value="BUY NOW"></input>
                                         </form>
                                        <?php } else{?>
                                        <a href="<?= base_url()?>teacherlogin" class="btn w-100 text-uppercase">Shop Now</a>
                                        <?php }?>
                                    </div><!-- /my-btn -->
                                </div>
                            </div><!-- /price-box -->
                        </div>
                        <?php $i++;} ?>
                        
                       <script>
                       function getpayment(){
                           alert();
                       }
                       </script>
                        
                         <div class="col-sm-4 mb-30"></div>
                        <div class=" col-sm-8 bg-warning pt-10 pb-10" style="border-radius: 24px; mb-30">
                            <h5>Get 10% off <span class="text-white"> 3 Months Contact</span> Get 20% off  <span class="text-white"> 6 Months Contact</span></h5>
                        </div>
                        <h1  class="mb-30"></h1>
                    </div>
                   
                </div>
         




<?php if($getTestimonialsresult){?>

<div class="testimonial-area home4-testimonial-area home4-testimonial-margin-top home4 position-relative over-hidden">
    <div class="home4-testimonial-bg pb-50 bg-no-repeat bg-cover mx-auto"
        data-background="<?= base_url()?>assets/frantweb/images/bg/hm4-testimonial-dotted-.png">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-8 col-md-10 col-sm-12 col-12">
                    <div class="title text-center">
                        <h2 class="mb-10"> Our <span class="f-700">School & Teacher</span> Say</h2>
                    </div><!-- /title -->
                </div>
            </div><!-- /row -->

            <div class="testimonial-wrapper testimonial-wrapper4 pt-25">
                <div class="row testimonial-active4">

                    <?php foreach($getTestimonialsresult as $val){?>
                    <div class="col-xl-4 col-lg-4 col-md-6  col-sm-12 col-12">
                        <div class="single-testimonial bg-white text-center pt-60 pb-60 pl-50 pr-50 mb-20 transition5">
                           
                            <p>
                                <?= $val->description?>
                            </p>

                            <ul class="review-ratting mt-25">
                                <li>
                                    <span><i class="fa fa-star"></i></span><span><i
                                            class="fa fa-star"></i></span><span><i
                                            class="fa fa-star"></i></span><span><i
                                            class="fa fa-star"></i></span><span><i class="fa fa-star"></i></span>
                                </li>
                            </ul>

                            <div class="testi-info mt-30 d-flex align-items-center justify-content-center">
                                <div class="d-flex">
                                    <!--<div class="testi-avatar pr-20 rounded-circle">
                                        <img class="rounded-circle" src="<?= base_url()?>upload/banner/<?= $val->logo?>"
                                            alt="image">
                                    </div> -->
                                    <div class="avatar-info text-left">
                                        <h6 class="f-500 text-uppercase mb-0">
                                            <?= $val->name?>
                                        </h6>
                                       <!-- <p class="mb-0">
                                            <?= @$val->profile?>
                                        </p>-->
                                    </div>
                                </div><!-- /testi-info -->
                            </div>
                        </div><!-- /single-testimonial -->
                    </div>

                    <?php }?>


                </div><!-- /row -->
            </div><!-- /testimonial-wrapper -->
        </div><!-- /container -->
    </div><!-- /testimonial bg -->

</div>
<?php } ?>


  

<div class="slider-area mt-0">
    <div id="carouselExample" class="carousel slide">
        <div class="carousel-inner">
            <?php $i=1;foreach($getSliderInactive as $val){?>
            <div class="carousel-item active">
                <img src="<?= base_url()?>upload/slider/<?= $val->slider_image?>" class="d-block w-100" alt="..." style="height: 400px;">
            </div>
            <?php $i++;}?>
        </div>

    </div>
</div>

