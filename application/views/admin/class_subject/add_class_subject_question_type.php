 <?php $role = $this->session->userdata('role');
	if ($role == 'admin') { ?>


 	<div class="content-body">
 		<div class="container-fluid">


 			<div class="row">
 				<div class="col-lg-12">
 					<div class="card shadow ">
 						<div class="card-body">
 							<?php
								$sub = @$_GET['sub'];
								$class = @$_GET['class_id'];
								$attributes = array('class' => '', 'id' => 'myform');
								echo form_open_multipart("admin_class_subject_question_type/class_subject_add", $attributes); ?>

 							<div class="row">
 								<h4>Class Name :- </h4>
 								<div class="form-group mb-3">
 									<?php foreach ($getClass as $val) { ?>

 										<div class="form-check form-check-inline">
 											<input class="form-check-input" type="checkbox" id="class_id" name="class_id[]" value="<?= $val->id ?>">
 											<label class="form-check-label" for="inlineCheckbox1"><?= $val->class_name ?></label>
 										</div>
 									<?php } ?>
 								</div>


 								<h4>Subject Name :- </h4>
 								<div class="form-group mb-3">
 									<?php foreach ($getSubject as $val) { ?>

 										<div class="form-check form-check-inline">
 											<input class="form-check-input" type="radio" id="subject_id" name="subject_id" value="<?= $val->id ?>">
 											<label class="form-check-label" for="inlineCheckbox1"><?= $val->subject_name ?></label>
 										</div>

 									<?php } ?>


 								</div>





 								<h4>Question Type:- </h4>
 								<div class="form-group mb-3">

 									<?php
										$count = 0;
										foreach ($getQuestion_type as $val) { ?>

 										<div class="form-check form-check-inline">
 											<input class="form-check-input" type="checkbox" id="question_type_id" name="question_type_id[]" value="<?= $val->id ?>">
 											<label class="form-check-label" for="inlineCheckbox1"><?= $val->question_type_name ?></label>
 										</div>

 									<?php } ?>

 									<span class="help-block"></span>
 								</div>
 							</div>

 							<div class="">
 								<button type="submit" class="btn btn-info btn-fill btn-wd">Submit</button>
 							</div>

 							<div class="clearfix"></div>
 							</form>

 						</div>
 					</div>
 				</div>
 			</div>
 		</div>
 	</div>
 	
 
 <?php } ?>