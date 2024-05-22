 <!-- ====== footer-area-start ============================================ -->
        <footer> 
            <div class="footer-area home4-footer-bg home2 pt-100 " >
                <div class="footer-top pb-75">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xl-4  col-lg-4  col-md-12  col-sm-12 col-12">
                                <div class="footer-widget f-about pb-30">
                                    <h6 class="text-uppercase f-500 mb-30">Contact Details</h6>
                                    
                               <ul class="footer-address">
                                   <?php footer_address()?>
                                    </ul>
                               </div>
                                <ul class="social-link">
                                        <li class="d-inline-block">
                                            <a class="text-center pr-15 d-inline-block transition-3 text-black"  target="_blank" href="https://www.facebook.com/profile.php?id=61554967197766"><i class="fab fa-facebook-f"></i></a>
                                        </li>
                                       
                                        <li class="d-inline-block">
                                            <a class="text-center pr-15 d-inline-block transition-3"  target="_blank" href="https://www.youtube.com/@Readypaper"><i class="fab fa-youtube"></i></a>
                                        </li>
                                        <li class="d-inline-block">
                                            <a class="text-center d-inline-block transition-3" target="_blank" href="https://www.instagram.com/readypaper?igsh=MmVlMjlkMTBhMg=="><i class="fab fa-instagram"></i></a>
                                        </li>
                                    </ul><!-- social-link -->
                            </div><!-- /col -->
                            <div class="col-xl-5 offset-lg-1  col-lg-5  col-md-7  col-sm-7 col-12">
                                <div class="footer-widget f-info pb-30 pr-20 mt-15 ">
                                    <h6 class="text-uppercase f-500 mb-30">Important links</h6>
                                    <div class="d-flex">
                                        <ul>
                                              <?php policy()?>
                                          
                                        </ul>
                                        <ul class="pl-65">
                                            <li>
                                                <a href="<?= base_url()?>about-us" class="position-relative d-inline-block mb-3">About Us</a>
                                            </li>
                                           
                                            <li>
                                                <a href="<?= base_url()?>price" class="position-relative d-inline-block mb-3">Price</a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url()?>contact-us" class="position-relative d-inline-block mb-3">Contcat Us</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div><!-- /col -->
                          
                        </div><!-- /row -->
                    </div><!-- /container -->
                </div>
                <div class="footer-bottom footer-top-border1">
                    <div class="container">
                        <div class="copyright-area mt-22">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-xl-6  col-lg-5  col-md-12  col-sm-12 col-12">
                                    <div class="copyright-text text-center text-lg-left mt-10 mb-20">
                                        <p class="mb-0">All rights reserved 
                                            <a href="javascript:;" class="c-theme f-500">Readypaper</a>  ©  <?= date('Y')?>
                                        </p>
                                    </div>
                                </div><!-- /col -->
                                
                            </div>
                        </div><!-- /copyright-area -->
                    </div><!-- /container -->
                </div>
            </div>
        </footer>

        <!-- back top -->
        <div id="scroll" class="scroll-up">
            <div class="top text-center"><span class="white-bg theme-color d-block"><i class="fa fa-arrow-alt-up"></i></span></div>
        </div>


<script src="<?= base_url() ?>assets/js/jquery-3.6.0.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/js/swiper.min.js"></script>
<script src="<?= base_url() ?>assets/js/functions.js"></script>
<!-- All js here -->
<script src="<?= base_url()?>assets/frantweb/js/vendor/modernizr-3.5.0.min.js"></script>
<script src="<?= base_url()?>assets/frantweb/js/vendor/jquery-1.12.4.min.js"></script>
<script src="<?= base_url()?>assets/frantweb/js/popper.min.js"></script>
<script src="<?= base_url()?>assets/frantweb/js/bootstrap.min.js"></script>

    <div id="fixed-icon">
<figure>
            <a href="https://api.whatsapp.com/send?phone=919408600001" target="_blank">
                <img src="<?= base_url()?>assets/whatsApp.png" alt="" style="width: 57%;"></a>
        </figure>
        
    </div>

<style>
#fixed-icon {
    position: fixed;
    bottom: 10px;
    right: 1px;
    z-index: 999;
}
</style>    
    
       
        <!--
        
              <script src="<?= base_url()?>assets/frantweb/js/jquery.inputarrow.js"></script>
        <script src="<?= base_url()?>assets/frantweb/js/jquery.nice-select.min.js"></script>
        <script src="<?= base_url()?>assets/frantweb/js/isotope.pkgd.min.js"></script>
        <script src="<?= base_url()?>assets/frantweb/js/image-loaded.min.js"></script>
        <script src="<?= base_url()?>assets/frantweb/js/jquery.fancybox.min.js"></script>
         <script src="<?= base_url()?>assets/frantweb/js/waypoint.js"></script>
        <script src="<?= base_url()?>assets/frantweb/js/counterup-min.js"></script>
           <script src="<?= base_url()?>assets/frantweb/js/tilt.jquery.min.js"></script>
        <script src="<?= base_url()?>assets/frantweb/js/plugins.js"></script>
        <script src="<?= base_url()?>assets/frantweb/js/aos.js"></script>-->
             
        <script src="<?= base_url()?>assets/frantweb/js/slick.min.js"></script>
        
        <script src="<?= base_url()?>assets/frantweb/js/jquery.meanmenu.min.js"></script>
        <script src="<?= base_url()?>assets/frantweb/js/main.js"></script>
    </body>
</html>