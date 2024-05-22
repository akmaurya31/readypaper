<div class="content-body">
            <!-- row -->
			<div class="container-fluid">
				<div class="row">
					<div class="col-xl-12 mt-4">
						<div class="row">
							<div class="col-xl-12">
								<div class="card">
									<div class="card-body">
										<div class="row shapreter-row">
												<div class="col-xl-2 col-lg-2 col-sm-4 col-6">
												<div class="static-icon">
													<span>
														<i class="fas fa-users"></i>
													</span>
															<h3 class="count"><a href="<?= base_url()?>teacher_management"><?= $totalteacher?></a></h3>
													<span class="fs-14">Total Teacher</span>
												</div>
											</div>
											
											
											<div class="col-xl-2 col-lg-2 col-sm-4 col-6">
												<div class="static-icon">
													<span>
														<i class="fas fa-user"></i>
													</span>
														<h3 class="count"><a href=""><a href="<?= base_url()?>admin_employee"><?= $totalemployee?></a></h3>
													<span class="fs-14">Employee</span>
												</div>
											</div>
												<div class="col-xl-2 col-lg-2 col-sm-4 col-6">
												<div class="static-icon">
													<span>
														<i class="fas fa-child"></i>
													</span>
													<h3 class="count"><?= $totalsuper_employee?></h3>
													<span class="fs-14">Super Employee</span>
												</div>
											</div>
											
										
										
												<div class="col-xl-2 col-lg-2 col-sm-4 col-6">
												<div class="static-icon">
													<span>
														<i class="fas fa-phone"></i>
													</span>
													<h3 class="count"><a href="<?= base_url()?>admin_contact"><?= $totalQuery?></a></h3>
													<span class="fs-14">Contact Query </span>
												</div>
											</div>
											
											<div class="col-xl-2 col-lg-2 col-sm-4 col-6">
												<div class="static-icon">
													<span>
														<i class="fas fa-eye"></i>
													</span>
													<h3 class="count"><a href="<?= base_url()?>admin_service_plan"><?= $totalPlan?></a></h3>
													
													<span class="fs-14">Total Plan</span>
												</div>
											</div>
											<div class="col-xl-2 col-lg-2 col-sm-4 col-6">
												<div class="static-icon">
													<span>
														<i class="far fa-comments"></i>
													</span>
													<h3 class="count"><a href="<?= base_url()?>admin_question_list"><?= $totalQuestion?></a></h3>
													<span class="fs-14">Total Question</span>
												</div>
											</div>
										
										</div>
									</div>
								</div>
							</div>
							
							
							
			


							<div class="col-xl-6">
								<div class="card">
								
									<div class="card-body">
									    <div class="row ">
											<div class="col-xl-8 col-xxl-7 col-sm-7">
												<div class="update-profile d-flex">
													<img src="<?= base_url() ?>assets/images/logo.png" alt="">
													<div class="ms-4">
														<h3 class="fs-24 font-w600 mb-0"><?= $this->session->userdata('firstName')?></h3>
														<span class="text-primary d-block mb-4"><?= $this->session->userdata('role')?></span>
														<span><i class="fas fa-map-marker-alt me-1"></i><?= $this->session->userdata('address')?></span>
													</div>
												</div>
											</div>
											<div class="col-xl-4 col-xxl-5 col-sm-5 sm-mt-auto mt-3">
												<a href="<?= base_url()?>admin_profile" class="btn btn-primary btn-rounded">Update Profile</a>
											</div>
										</div>
										<div class="row align-items-center">
											<div class="col-xl-6 col-sm-6">
											    
												<div class="progress default-progress">
													<div class="progress-bar bg-vigit progress-animated" style="width: <?= $totalPlan?>%; height:13px;" role="progressbar">
														<span class="sr-only"><?= $totalPlan?>% Complete</span>
													</div>
												</div>
												<div class="d-flex align-items-end mt-2 pb-4 justify-content-between">
													<span class="fs-14 font-w500">Plan</span>
													<span class="fs-16"><span class="text-black pe-2"></span><?= $totalPlan?>%</span>
												</div>
												
												
												<div class="progress default-progress">
													<div class="progress-bar bg-contact progress-animated" style="width: <?= $totalemployee?>%; height:13px;" role="progressbar">
														<span class="sr-only"><?= $totalemployee?>% Complete</span>
													</div>
												</div>
												<div class="d-flex align-items-end mt-2 pb-4 justify-content-between">
													<span class="fs-14 font-w500">Employee</span>
													<span class="fs-16"><span class="text-black pe-2"></span><?= $totalemployee?>%</span>
												</div>
												
												
												<div class="progress default-progress">
													<div class="progress-bar bg-follow progress-animated" style="width: <?= $totalQuery?>%; height:13px;" role="progressbar">
														<span class="sr-only"><?= $totalQuery?>% Complete</span>
													</div>
												</div>
												<div class="d-flex align-items-end mt-2 pb-4 justify-content-between">
													<span class="fs-14 font-w500">Teacher</span>
													<span class="fs-16"><span class="text-black pe-2"></span><?= $totalQuery?>%</span>
												</div>
												
											</div>
											<div class="col-xl-6 col-sm-6">
												<div id="pieChart3"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-6">
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
							</div>


							
						</div>
					</div>
				</div>	
            </div>
        </div>