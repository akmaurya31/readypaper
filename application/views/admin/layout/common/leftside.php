<div class="dlabnav">
	<div class="dlabnav-scroll">
		<div class="dropdown header-profile2 ">
		 <?php
$role = @$this->session->userdata('role');
$dashboardUrl = '';

if ($role == 'employee') {
    $dashboardUrl = 'employee-dashboard';
} elseif ($role == 'super-employee') {
    $dashboardUrl = 'super_dashboard';
} elseif ($role == 'teacher') {
    $dashboardUrl = 'teacher_dashboard';
}else {
    $dashboardUrl = 'dashboard';
}
?>


			<a href="<?= base_url() . $dashboardUrl ?>"> <!--role="button" data-bs-toggle="dropdown"-->
				<div class="header-info2 d-flex align-items-center">
					<img src="<?= base_url() ?>assets/images/logo.icon.png">
					<div class="d-flex align-items-center sidebar-info">
						<div>
							<span class="font-w400 d-block"><?= @$this->session->userdata('firstName') ?></span>
							<small class="text-end font-w400"><?php if($this->session->userdata('role')=='employee'){ echo "Vendor";}
							elseif($this->session->userdata('role')=='super-employee'){ echo "Super Vendor";}else{
							echo $this->session->userdata('role');
							} ?></small>
						</div>
					</div>
				</div>
			</a>
		</div>

		<ul class="metismenu" id="menu">
			<?php $role = $this->session->userdata('role');
			if ($role == 'admin') { ?>
				<li><a href="<?= base_url() ?>dashboard" class="" aria-expanded="false">
						<i class="flaticon-025-dashboard"></i>
						<span class="nav-text">Dashboard</span>
					</a>
				</li>

				<li>
					<a class="has-arrow " href="javascript:void()" aria-expanded="false">
						<i class="flaticon-022-copy"></i>
						<span class="nav-text">Website</span>
					</a>
					<ul aria-expanded="false">
						<li><a href="<?= base_url() ?>admin_slider">Slider</a></li>
						<li><a href="<?= base_url() ?>admin_menu">Menu</a></li>
						<li><a href="<?= base_url() ?>admin_testimonials">Testimonial</a></li>
						<li><a href="<?= base_url() ?>admin_teacher_ad">Teacher Ads Show</a></li>
						<li><a href="<?= base_url() ?>admin_state">State</a></li>
						<li><a href="<?= base_url() ?>admin_state_quota">District</a></li>
					</ul>
				</li>


				<li>
					<a class="has-arrow " href="javascript:void()" aria-expanded="false">
						<i class="flaticon-043-menu"></i>
						<span class="nav-text">Master</span>
					</a>
					<ul aria-expanded="false">
						<li><a href="<?= base_url() ?>admin_board_type">Board Type</a></li>
						<li><a href="<?= base_url() ?>admin_class">Class</a></li>
						<li><a href="<?= base_url() ?>admin_subject">Subject</a></li>
						<li><a href="<?= base_url() ?>admin_school">School</a></li>
						<li><a href="<?= base_url() ?>admin_question_type">Question type</a></li>
						<li><a href="<?= base_url() ?>admin_chapter_type">Chapter Type</a></li>
						<li><a href="<?= base_url() ?>admin_correct_answer">Correct Answer</a></li>
						<li><a href="<?= base_url() ?>admin_service_plan">Service Plan</a></li>
						<li><a href="<?= base_url() ?>admin_exam">Exam</a></li>
						<li><a href="<?= base_url() ?>admin_group_exam">Group Exam</a></li>
					</ul>
				</li>



				<li>
					<a class="has-arrow " href="javascript:void()" aria-expanded="false">
						<i class="flaticon-093-waving"></i>
						<span class="nav-text">Manage</span>
					</a>
					<ul aria-expanded="false">
						<li><a href="<?= base_url() ?>admin_class_subject">Class Subjects Mapping</a></li>
						<li><a href="<?= base_url() ?>admin_class_subject_question_type">Class_Sub_QT_Mapping</a></li>
						<li><a href="<?= base_url() ?>admin_classsub_syllabus">Syllabus Subjects </a></li>
						<li><a href="<?= base_url() ?>admin_classsub_exercise">Exercise Subjects </a></li>
						<li><a href="<?= base_url() ?>admin_classsub_chapter">Chapter Subjects & Question</a></li>
						<li><a href="<?= base_url() ?>admin_question_image">Question URL Image</a></li>
					</ul>
				</li>


				<li>
					<a class="has-arrow " href="javascript:void()" aria-expanded="false">
						<i class="flaticon-381-user-7"></i>
						<span class="nav-text">Employee</span>
					</a>
					<ul aria-expanded="false">
						<li><a href="<?= base_url() ?>admin_employee">Employee</a></li>
						<li><a href="<?= base_url() ?>admin_employee_subject">Assign Employee Subjects</a></li>

					</ul>
				</li>
	          

				<li>
					<a class="has-arrow " href="javascript:void()" aria-expanded="false">
						<i class="flaticon-013-checkmark"></i>
						<span class="nav-text">Report</span>
					</a>
					<ul aria-expanded="false">
                        <li><a href="<?= base_url()?>active_teacher">Active Teacher</a></li>
                        <li><a href="<?= base_url()?>inactive_teacher">Inactive Teacher</a></li>
                         <li><a href="<?= base_url()?>admin_order/pending_order">Pending Payment </a></li>
                         <li><a href="<?= base_url()?>admin_order/success_order">Success Payment</a></li>
                        <li><a href="<?= base_url()?>admin_order">All Order Payment </a></li>
                        <li><a href="<?= base_url()?>admin_question_list/question_daliywise">Daliy Wise Questions  </a></li>
                         <li><a href="<?= base_url()?>admin_question_list/question_subject_chapter">All subjects & chapter Question </a></li>
                           <li><a href="<?= base_url()?>admin_question_list">All Question Report  </a></li>
                        <li><a href="<?= base_url()?>admin_capter_list">Capterwise Question Report  </a></li>
                        <li><a href="<?= base_url()?>attendanceRegister">Employee Attendence </a></li>
					</ul>
				</li>

 <li><a href="<?= base_url() ?>admin_contact" class="" aria-expanded="false">
						<i class="la la-phone"></i>
						<span class="nav-text">Contact Query </span>
					</a>
				</li>

				<li><a href="<?= base_url() ?>teacher_management" class="" aria-expanded="false">
						<i class="flaticon-381-user-7"></i>
						<span class="nav-text">Teacher</span>
					</a>
				</li>

               <?php 
$current_datetime = (new DateTime())->modify('-1 day')->format('Ymd'); 
if ($this->session->userdata('id') == 1) {
    ?>
    <li>
        <a href="<?= base_url()?>sqlbackup/readpaperdb<?= $current_datetime?>.txt" download>
            <i class="flaticon-072-printer"></i>
            <span class="nav-text">Backup Download</span>
        </a>
    </li>
    <?php 
} 
?>


				<li><a href="<?= base_url() ?>admin_profile" class="" aria-expanded="false">
						<i class="la la-users"></i>
						<span class="nav-text">Admin Profile</span>
					</a>
				</li>
				
						<li><a href="<?= base_url() ?>logout" class="" aria-expanded="false">
						<i class="la la-eye"></i>
						<span class="nav-text">Logout</span>
					</a>
				</li>
			<?php } elseif ($role == 'employee') { ?>

<li><a href="<?= base_url() ?>" class="" aria-expanded="false">
						<i class="flaticon-072-printer"></i>
						<span class="nav-text">Home page</span>
					</a>
				</li>

				<li><a href="<?= base_url() ?>admin_assign_subject" class="" aria-expanded="false">
						<i class="flaticon-072-printer"></i>
						<span class="nav-text">Vendor Activity</span>
					</a>
				</li>
				<?php
				$empid = $this->session->userdata('ip');
				if($empid==1){?>

				<li><a href="<?= base_url() ?>admin_teacher_ad" class="" aria-expanded="false">
						<i class="flaticon-041-graph"></i>
						<span class="nav-text">Teacher Ads Show</span>
					</a>
				</li>
				<?php } ?>
				
					<li><a href="<?= base_url() ?>admin_question_image" class="" aria-expanded="false">
						<i class="flaticon-072-printer"></i>
						<span class="nav-text">Question URL Image</span>
					</a>
				</li>
				
				
					<li><a href="<?= base_url() ?>attendanceRegister" class="" aria-expanded="false">
						<i class="flaticon-043-menu"></i>
						<span class="nav-text">Attendence</span>
					</a>
				</li>
				
				 

				<li><a href="<?= base_url() ?>admin_employee" class="" aria-expanded="false">
						<i class="flaticon-013-checkmark"></i>
						<span class="nav-text">Vendor Profile</span>
					</a>
				</li>

				<li><a href="<?= base_url() ?>logout" class="" aria-expanded="false">
						<i class="fas fa-eye"></i>
						<span class="nav-text">Logout</span>
					</a>
				</li>
			<?php } elseif ($role == 'super_employee') { ?>


				<li><a href="<?= base_url() ?>admin_assign_subject" class="" aria-expanded="false">
						<i class="flaticon-072-printer"></i>
						<span class="nav-text">Vendor Activity</span>
					</a>
				</li>
				
				<li><a href="<?= base_url() ?>employee_question" class="" aria-expanded="false">
						<i class="flaticon-072-printer"></i>
						<span class="nav-text">Vendor Question</span>
					</a>
				</li>
				
             	<li><a href="<?= base_url() ?>question_own_teacher" class="" aria-expanded="false">
						<i class="flaticon-072-printer"></i>
						<span class="nav-text">Teacher Question</span>
					</a>
				</li>
                

				<li><a href="<?= base_url() ?>admin_employee" class="" aria-expanded="false">
						<i class="flaticon-013-checkmark"></i>
						<span class="nav-text">Profile</span>
					</a>
				</li>

				<li><a href="<?= base_url() ?>logout" class="" aria-expanded="false">
						<i class="fas fa-eye"></i>
						<span class="nav-text">Logout</span>
					</a>
				</li>
				
				
				<!-----------------------------------------------------------Teacher-------------------------------------------------->
			<?php } elseif ($role == 'teacher') { ?>
			
				<li><a href="<?= base_url() ?>teacher_dashboard" class="" aria-expanded="false">
						<i class="flaticon-025-dashboard"></i>
						<span class="nav-text">Dashboard</span>
					</a>
				</li>
				
					<li><a href="<?= base_url() ?>teacher_school" class="" aria-expanded="false">
						<i class="flaticon-043-menu"></i>
						<span class="nav-text">School/Institute</span>
					</a>
				</li>

				<li><a href="<?= base_url() ?>teacher_create_pepar" class="" aria-expanded="false">
						<i class="flaticon-013-checkmark"></i>
						<span class="nav-text">Add Pepar</span>
					</a>
				</li>
				
				<li><a href="<?= base_url() ?>test_exam_list" class="" aria-expanded="false">
						<i class="flaticon-072-printer"></i>
						<span class="nav-text">Exam List</span>
					</a>
				</li>

				<li><a href="#" class="" aria-expanded="false">
						<i class="flaticon-022-copy"></i>
						<span class="nav-text">Mock Pepar</span>
					</a>
				</li>
				
				
				
				
					<li><a href="<?= base_url() ?>teacher_profile" class="" aria-expanded="false">
						<i class="flaticon-045-heart"></i>
						<span class="nav-text">Teacher Profile</span>
					</a>
				</li>
				
					

			


				<li><a href="<?= base_url() ?>logout" class="" aria-expanded="false">
						<i class="la la-eye"></i>
						<span class="nav-text">Logout</span>
					</a>
				</li>
			<?php } ?>



		</ul>

		<?php if ($role == 'super_employee' || $role == 'employee') { ?>
			<div class="copyright">
				<p><strong>For Support & Training</strong> Call:- +91 94086 00001</p>
				<p class="fs-12">Developed by <span class="heart"></span> <a href="" target="_blank"><?php echo $this->config->item('site_name'); ?></a> 2023</p>
			</div>
		<?php } else if ($role == 'teacher') { ?>
			<div class="plus-box">
				<p class="fs-14 font-w600 mb-2">Plan Expired On<br>10 December 2024<br></p>
				<p>Plan:- Unlimited Plan <a href="<?= base_url() ?>teacher_plan" class="text-warning">Update Plan</a></p>
			</div>
			<div class="copyright">
				<p><strong>For Support & </strong> Call:- +91 94086 00001</p>
				<p class="fs-12">Developed by <span class="heart"></span> <a href="" target="_blank"> <?php echo $this->config->item('site_name'); ?></a> 2023</p>
			</div>

		<?php } ?>


	</div>
</div>
<!--**********************************
            Sidebar end
        ***********************************-->