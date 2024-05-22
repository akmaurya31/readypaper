<div class="content-body">
    <style>
    .profile-back img {
  
    height: 19rem;
}

    </style>
            <!-- row -->
			<div class="container-fluid">
				<div class="row">
					<div class="col-xl-12">
						<div class="profile-back">
							<img src="images/profile1.jpg" alt="">
							<div class="social-btn">
								<a href="<?= base_url()?>" class="btn btn-light social">Instruction</a>
								<a href="<?= base_url()?>teacher_school" class="btn btn-light social">School/Institute</a>
								<a href="<?= base_url()?>teacher_profile" class="btn btn-primary">Update Profile</a>
							</div>
						</div>
						<div class="profile-pic d-flex">
							<img src="<?= base_url() ?>upload/<?= $getTeacher->logo?>" alt="">
							<div class="profile-info2">
								<h2 class="mb-0"><?= ucwords($getTeacher->firstName)?></h2>
								<h4><?= ucwords($getTeacher->role)?></h4>
								<span class="d-block"><i class="fas fa-map-marker-alt me-2"></i><?= ucwords($getTeacher->address)?></span>
							</div>
						</div>
					</div>
					
					
					
					
					<div class="col-xl-6 col-xxl-6 col-lg-6 mt-5">
						<div class="row">
						    <div class="col-xl-8 col-xxl-7">
								<div class="card">
									<div class="card-header border-0 pb-0">
										<h4 class="fs-20 font-w600">School/Institute</h4>
									</div>
									<div class="card-body">
									    <h5 class="fs-18"><?= @$getSchool->school_name?></h5>
										<p class="fs-18"><?= @$getSchool->address?></p>
										
										
										<h4 class="fs-20 font-w600 my-4">Contact</h4>
										<div class="d-flex flex-wrap">	
											<div class="d-flex contacts-social align-items-center mb-3  me-sm-5 me-0">
												<span class="me-3">
													<i class="fas fa-phone-alt"></i>
												</span>
												<div>
													<span>Phone</span>
													<h5 class="mb-0 fs-18"><?= $getTeacher->mobile_no?></h5>
												</div>
											</div>
											<div class="d-flex contacts-social align-items-center mb-3">
												<span class="me-3">
													<i class="fas fa-envelope-open"></i>
												</span>
												<div>
													<span>Email</span>
													<h5 class="mb-0 fs-18"><?= $getTeacher->email?></h5>
												</div>
											</div>
										</div>	
									</div>
									
								</div>
							</div>
							<div class="col-xl-4 col-xxl-5">
								<div class="card">
									<div class="card-header border-0 pb-0">
										<h4 class="fs-20 font-w600">Socials</h4>
									</div>
									<div class="card-body">
										<div>
											<a href="<?= @$getSchool->fb?>" class="btn text-start d-block mb-3 bg-facebook light"><i class="fab fa-facebook-f scale5 me-4 text-facebook"></i>/facebook</a>
											<a href="<?= @$getSchool->lin?>" class="btn text-start d-block mb-3 bg-linkedin light"><i class="fab fa-linkedin-in scale5 me-4 text-linkedin"></i>/linkedin</a>
											<a href="<?= @$getSchool->teli?>" class="btn text-start d-block mb-3 bg-dribble light"><i class="fab fa-telegram scale5 me-4 text-telegram"></i>/telegram</a>
											<a href="<?= @$getSchool->you?>" class="btn text-start d-block mb-3 bg-youtube light"><i class="fab fa-youtube scale5 me-4 text-youtube"></i>/youtube</a>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-12">
								<div class="card">
									<div class="card-header border-0">
										<h4 class="fs-20">Subjects</h4>
									</div>
									<div class="card-body">
										<div id="pieChart2" class="mb-4-"></div>
										<?php if($getPlanSubject){
										   $getactive_Subject =  getPlan_Active_Subject($getPlanSubject->plan_name,$getPlanSubject->teacher_id);
										foreach($getactive_Subject as $value){?>
										<div class="progress default-progress">
											<div class="progress-bar bg-green progress-animated" style="width: 90%; height:13px;" role="progressbar">
												<span class="sr-only">99% Complete</span>
											</div>
										</div>
										<div class="d-flex align-items-end mt-2 pb-4 justify-content-between">
											<span class="fs-14 font-w500"><?php subjectName($value->subject_id)?></span>
											
										</div>
										
								<?php }}else{ "No Data Found";}?>
									</div>
									
										<div class="card-header border-0">
										<h4 class="fs-20"> Pepar Create:- <a class="text-primary" href="<?= base_url()?>test_exam_list">
										             <?php $id = $this->session->userdata('id');
										                   totalpepar_create($id)?></a></h4>
									</div>
								</div>
							</div>
							
							<!--<div class="col-xl-12">
								<div class="card bg-dark">
									<div class="card-body d-flex align-items-center">
										<div>
											<h4 class="fs-20 font-w600 mb-2 text-white">Upload your curriculum vitae</h4>
											<p class="text-white mb-0 op6">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut</p>
										</div>	
										<div class="upload">
											<a href="javascript:void(0);"><i class="fas fa-arrow-up"></i></a>
										</div>
									</div>
								</div>
							</div>-->
						</div>
					</div>
					
					
					
					<div class="col-xl-6 col-xxl-6 col-lg-6 mt-lg-5 mt-0">
					    
					    <div class="card">
									<div class="card-header border-0">
										<h4 class="fs-20 mb-3-">Payment List</h4>
									</div>
									<div class="card-body loadmore-content  recent-activity-wrapper" id="RecentActivityContent">
									    <?php foreach($getTodayTeacher as $val){?>
										<div class="d-flex recent-activity">
											<span class="me-3 activity">
												<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
												  <circle cx="8.5" cy="8.5" r="8.5" fill="#f93a0b"></circle>
												</svg>
											</span>
											<span>
												<svg xmlns="http://www.w3.org/2000/svg" width="71" height="71" viewBox="0 0 71 71">
												  <g transform="translate(-457 -443)">
													<rect width="71" height="71" rx="12" transform="translate(457 443)" fill="#c5c5c5"></rect>
													<g transform="translate(457 443)">
													  <rect data-name="placeholder" width="71" height="71" rx="12" fill="#2769ee"></rect>
													  <circle data-name="Ellipse 12" cx="18" cy="18" r="18" transform="translate(15 20)" fill="#fff"></circle>
													  <circle data-name="Ellipse 11" cx="11" cy="11" r="11" transform="translate(36 15)" fill="#ffe70c" style="mix-blend-mode: multiply;isolation: isolate"></circle>
													</g>
												  </g>
												</svg>
											</span>
											<div class="ms-3">
												<h5 class="mb-1"><?= $val->name?> / <?= $val->mobileNumber?> ( Rs <?= $val->total_amount?> )</h5>
												<span>Plan :- <?= $val->plan_name?><?php if($val->code==''){ echo " (NOT PAYMENT)";}else{?> (<?= $val->code?>)<?php }?></span>
											</div>
										</div>
										<?php } ?>
									</div>
									
									
									<div class="card-footer border-0 m-auto pt-0">
										<a href="<?= base_url()?>admin_order" class="btn btn-outline-primary btn-rounded m-auto dlab-load-more" id="RecentActivity" rel="ajax/recentactivity.html">View more</a>
									</div>
								</div>
						<div class="row">
							<div class="col-xl-12">
								<div class="card">
									<div class="card-header border-0 pb-0">
										<h4 class="fs-20 mb-1">Featured Schools</h4>
									</div>
									<div class="card-body pt-3 loadmore-content">
										<div class="row" id="FeaturedCompaniesContent">
										    <?php foreach($getSchoolAds as $val){?>
											<div class="col-xl-6 col-sm-6 mt-4 ">
												<div class="d-flex">
													<span>
														<img src="<?= base_url()?>upload/company/<?= $val->pic?>" class="img-fluid" style="    width: 95%;">
													</span>
													<!--<div class="ms-3 featured">
														<h4 class="fs-20 mb-1"><?= $val->heading?></h4>
														<span><?= $val->content?></span>
													</div>-->
												</div>
											</div>
											<?php } ?>
										</div>
									</div>
									<div class="card-footer border-0 m-auto pt-0">
										<a href="<?= base_url()?>" class="btn btn-outline-primary btn-rounded m-auto ">View more</a>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
            </div>
        </div>