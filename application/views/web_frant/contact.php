        <style>
        .mb-30 p{
            color:#ff0000;
        }
        </style>
           <div class="other-page-area mt-100">
                <img src="<?= base_url()?>assets/frantweb/contact.jpeg" class="img-fluid"> 
            </div> 
            
            
            <div class="contact-area contact-page mb-65 mt-65">
                <div class="contact-wrapper position-relative">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-12  col-sm-12 col-12">
                                <div class="contact-wrapper">
                                    <ul class="contact-info-content d-md-flex justify-content-between d-lg-block mb-lg-0 mb-5">
                                        <li class="contact-location s-contact text-md-center text-lg-left mb-35 transition-3 d-lg-flex d-flex d-md-block">
                                            <div class="contact-icon contact-icon-bg-1 d-inline-block text-center mr-30">
                                                <span class="text-white d-inline-block"><i class="fas fa-map-marker-alt"></i></span>
                                            </div><!-- /contact-icon -->
                                            <div class="contact-text">
                                                <h4 class="mb-10">Address</h4>
                                                <p class="secondary-color mb-0"><?= $getadmin->address?></p>
                                            </div>
                                        </li><!-- /contact-location -->

                                        <li class="contact-phone s-contact text-md-center text-lg-left mb-40 transition-3 d-lg-flex d-flex d-md-block">
                                            <div class="contact-icon contact-icon-bg-2 d-inline-block text-center mr-30">
                                                <span class="text-white d-inline-block"><i class="fas fa-phone-alt"></i></span>
                                            </div><!-- /contact-icon -->
                                            <div class="contact-text">
                                                <h4 class="mb-10">Phone</h4>
                                                <p class="mb-0">
                                                    <a class="d-block secondary-color" href="tell:+91<?= $getadmin->mobile_no?>">+91 <?= $getadmin->mobile_no?></a>
                                                   
                                                </p>
                                            </div>
                                        </li><!-- /contact-phone -->

                                        <li class="contact-email s-contact text-md-center text-lg-left mb-35 transition-3 d-lg-flex d-flex d-md-block">
                                            <div class="contact-icon contact-icon-bg-3 d-inline-block text-center mr-30">
                                                <span class="text-white d-inline-block"><i class="fas fa-envelope"></i></span>
                                            </div><!-- /contact-icon -->
                                            <div class="contact-text">
                                                <h4 class="mb-10">Email</h4>
                                                <p class="mb-0">
                                                    <a class="secondary-color2 primary-hover d-block" href="#"><?= $getadmin->email?></a>
                                                </p>
                                            </div>
                                        </li><!-- /contact-email -->
                                        
                                        <li class="contact-email s-contact text-md-center text-lg-left mb-35 transition-3 d-lg-flex d-flex d-md-block">
                                            <div class="contact-icon contact-icon-bg-3 d-inline-block text-center mr-30">
                                                <span class="text-white d-inline-block"><i class="fas fa-envelope"></i></span>
                                            </div><!-- /contact-icon -->
                                            <div class="contact-text">
                                                <h4 class="mb-10">Email</h4>
                                                <p class="mb-0">
                                                    <a class="secondary-color2 primary-hover d-block" href="#">readypaperldh@gmail.com</a>
                                                </p>
                                            </div>
                                        </li><!-- /contact-email -->
                                        
                                    </ul><!-- /contact-info-content -->
                                    
                                    <div class="footer-widget f-adress mt-15 bg-gray" style="background: #00000080;padding: 24px;">
                                    <h6 class="text-uppercase f-500 mb-30">Connect with us</h6>
                                    <ul class="social-link mt-15">
                                        
                                        
                                        
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
                                </div>
                                </div><!-- /contact-wrapper -->
                            </div><!-- /col -->
                            <div class="col-xl-8 col-lg-8 col-md-12  col-sm-12 col-12">
                                <div class="contact-wrapper mt--5">
                                    <div class="contact-form">
                                        <div class="con-title px-md-5 px-lg-0 text-md-center text-lg-left">
                                            <h4 class="mb-10">Send us a message</h4>
                                            
                                        </div><!-- /title -->
                                        
                                             <?php 
                                if(@$this->session->flashdata('massege_contact')){?>
                                  <div class="alert alert-success"><?= $this->session->flashdata('massege_contact')?></div>
                                <?php }?>
                                
                                <?php $attributes = array('class' => 'default-form', 'id' => 'contact-form-');
                                   echo form_open_multipart("", $attributes);?>
			 
			 
                                       
                                            <div class="contact-info text-md-center text-lg-left pt-20">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-30" >
                                                              <input type="text" class=" w-100 primary-border2 pl-20 pt-15 pb-15 pr-10" name="username" placeholder="Your Name" value="<?= set_value('username')?>">
                                        	<?php echo form_error('username'); ?>
                                                    </div><!-- /col -->
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-30" >
                                                       <input type="text" class="w-100 primary-border2 pl-20 pt-15 pb-15 pr-10" name="mobile_no"  placeholder="Mobile Number"  value="<?= set_value('mobile_no')?>">
                                        	<?php echo form_error('mobile_no'); ?>
                                                    </div><!-- /col -->
                                                </div><!-- /row -->
                                                <div class="row ">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-30" >
                                                       <input type="email" class=" w-100 primary-border2 pl-20 pt-15 pb-15 pr-10" name="email" placeholder="Email Address"  value="<?= set_value('email')?>">
                                                  	<?php echo form_error('email'); ?>
                                                    </div><!-- /col -->
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-30" >
                                                       
                                                     <textarea name="description" class=" w-100 primary-border2 pl-20 pt-20" placeholder="Write Message"> <?= set_value('description')?></textarea>
                                                    </div><!-- /col -->
                                                </div><!-- /row -->
                                                <div class="my-btn">
                                                    <button class="btn theme-bg text-uppercase rounded-0 f-500" type="submit" name="submit" >Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                        <p class="form-message mt-20"></p>
                                    </div><!-- /contact-form -->
                                </div><!-- /contact-wrapper -->
                            </div><!-- /col -->
                        </div><!-- /row -->
                     
                    </div><!-- /container -->
                </div><!-- /contact-wrapper -->
            </div>
            <!-- contact-area-end  -->
        


        </main>