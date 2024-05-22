
          <div class="other-page-area mt-100">
                <img src="<?= base_url()?>upload/banner/<?= $getmenuRow->bg_image?>" class="img-fluid"> 
            </div> 
            
            <div class="about-feature-area position-relative over-hidden pt-60 pb-65" style="background-color: #fafafa;">

                <div class="container-fluid">
                    <?php $i=1;
                    foreach($getAbout as $val){
                    if($i==1){?>
                    <div class="row about-feature1 mb-75 align-items-center justify-content-center">
                        <div class="col-md-12 col-sm-12 col-12">
                            <div class="about-feature-content title2">
                                  <h2 class=""><?= $val->heading?></h2>
                                <?= $val->content?>
                            </div><!-- /home4-feature-content -->
                        </div><!-- /col -->
                    </div><!-- /row about-feature1 -->
                     <?php }else{?>
                    <div class="row about-feature1 mb-65 align-items-center justify-content-center">
                        <div class="col-xl-2 col-lg-2  col-md-8  col-sm-12 col-12 aos-init aos-animate" data-aos="fade-right" data-aos-duration="1000">
                            <div class="about-feature-img-wrapper text-center position-relative">
                                <div class="about-feature-img position-relative d-inline-block pl-25-">
                                    <img class="rounded-circle" src="<?= base_url()?>upload/<?= $val->pic?>" alt="feature-image1">
                                </div><!-- /about-feature-img -->
                            </div><!-- /about-feature-img-wrapper -->
                        </div><!-- /col -->

                        <div class="col-xl-10 offset-xl-1- col-lg-8 col-md-12 col-sm-12 col-12">
                            <div class="about-feature-content title2">
                               <h5><?= $val->heading?></h5>
                                <?= $val->content?>
                            </div><!-- /home4-feature-content -->
                        </div><!-- /col -->
                    </div><!-- /row about-feature1 -->
                     <?php } $i++;  }?>
                </div><!-- /container -->

            </div>
       


            
        </main>