 <main>
       <style>
        .about-page-content.title2 p {
            font-size: 16px;
            text-align: justify;
        }
        .about-page-content ul li{
              padding-bottom: 20px;
    position: relative;
    left: 36px;
    list-style: inherit;
        }
       </style>
             
            
          <div class="other-page-area mt-100">
                <img src="<?= base_url()?>upload/banner/<?= $getmenuRow->bg_image?>" class="img-fluid"> 
            </div> 

            <div class="about-page2-area pt-50 pb-70 position-relative over-hidden bg-gray paika-hr">
                 <div class="container-fluid">
                    <?php if($getActiveteResult){?>
                    <div class="row justify-content-center flex-column-reverse- flex-lg-row-">
                           <?php foreach($getActiveteResult as $val){?>
                        <div class="col-md-12 col-sm-12 col-12"><!-- data-aos="fade-left" data-aos-duration="2000" data-aos-delay="150"--->
                            <div class="about-page-content title2 pb-20">
                                <h2 class="mb-25 text-cente"><?= $val->heading?></h2>
                                <?= $val->content?>
                            </div><!-- /about-content -->
                        </div><!-- /col -->
                    <?php } ?>
                       
                    </div><!-- /row -->
                    <?php } else{
        echo "<h2 class='text-center'>Comming Soon</h2>";
       }?> 
                </div><!-- /container -->

            </div>
           
  

            
        </main>