 <div class="content-body">
 	<div class="container-fluid">
 		<style>
 			.form-group p {
 				color: #ff0000;
 			}

 			b,
 			strong {
 				font-weight: 400;
 				font-family: 'poppins', sans-serif;
 			}

 			p math {
 				ont-size: 14px;
 				font-weight: 100;
 				font-family: 'poppins', sans-serif;
 			}

 			span p {
 				display: -webkit-inline-box;
 			}

 			.btn {
 				padding: 1rem 1.1rem;
 			}

 			p {
 				display: -webkit-box;
 			}

 			.fa-2x {
 				font-size: 1.3em;
 			}

 			.me-2 {
 				margin-right: 0.1rem !important;
 			}
 		</style>
 		<div class="row page-titles">
 			<ol class="breadcrumb">
 				<li class="breadcrumb-item active"><a href="<?= base_url() ?>admin_classsub_chapter">Chapter Subjects</a></li>
 				<li class="breadcrumb-item"><a class="text-warning" href="<?= base_url() ?>admin_chapter?clas_sub_id=<?= $_GET['clas_sub_id'] ?>"><?php class_subName($_GET['clas_sub_id']) ?></a></li>
 				<li class="breadcrumb-item"><a href="javascript:void(0)"><?php chapterName($_GET['chapter_id']) ?></a></li>
 			</ol>
 		</div>
 		<div class="row">
 			<div class="col-lg-12">
 				<!-- DataTales Example -->
 				<div class="card shadow mb-4">
 					<div class="card-body" style="">
 					    
 					     <?php 
                                if(@$this->session->flashdata('error')){?>
                                  <div class="alert alert-danger"><?= $this->session->flashdata('error')?></div>
                                <?php }?>

 						<?php $attributes = array('class' => '', 'id' => 'myform');
							echo form_open_multipart("admin_question/all_list?chapter_id={$_GET['chapter_id']}&clas_sub_id={$_GET['clas_sub_id']}", $attributes); ?>




 						<div class="row">
 							<div class="col-md-3 mb-3">
 								<div class="form-group  ">
 									<label class="form-label">Question Type*</label>
 									<select class="form-control form-control-use" name="question_type" onchange="getQuestion(this.value)">
 										<option value="">Select Type</option>
 										<?php
											foreach ($getquestiontype as $val) { ?>
 											<option value="<?= $val->question_type_id ?>"><?= question_typeName($val->question_type_id) ?></option>
 										<?php   } ?>
 									</select>
 									<?php echo form_error('question_type'); ?>
 								</div>
 							</div>

 							<div class="col-md-3 mb-3">
 								<div class="form-group  ">
 									<label class="form-label">Exercise*</label>
 									<select class="form-control form-control-use" name="exercise_id" o>
 										<option value="">Select Exercise</option>
 										<?php
											foreach ($getexercise as $val) { ?>
 											<option value="<?= $val->id ?>"><?= $val->exercise_name ?></option>
 										<?php   } ?>
 									</select>
 									<?php echo form_error('exercise_id'); ?>
 								</div>
 							</div>

 							<div class="col-md-3 mb-3">
 								<div class="form-group">
 									<label>Question Image </label>
 									<input type="file" name="pic" class="" value="">

 								</div>
 							</div>

 							<div class="col-md-3 mb-3">
 								<div class="form-group">
 									<label>Answer Image </label>
 									<input type="file" name="pic1" class="" value="">

 								</div>
 							</div>
 							<div class="col-md-2 mb-3" id="firstand">
 								<div class="form-group">
 									<label>Correct  Answer</label>
 									<select name="currect_ans" class="form-control">
 										<option value="">Select </option>
 										<?php foreach ($getcorrect_answer as $val) { ?>
 											<option value="<?= $val->id ?>"><?= $val->correct_answer ?></option>
 										<?php } ?>
 									</select>
 									<?php echo form_error('currect_ans'); ?>
 								</div>
 							</div>

 							<div class="col-md-2 mb-3" id="mutiques">
 								<div class="form-group">
 									<label>Correct  Answer 2</label>
 									<select name="currect_ans2" class="form-control">
 										<option value="">Select </option>
 										<?php foreach ($getcorrect_answer as $val) { ?>
 											<option value="<?= @$val->id ?>"><?= @$val->correct_answer ?></option>
 										<?php } ?>
 									</select>
 								</div>
 							</div>

 							<div class="col-md-3 mb-3" id="mutiques">
 								<div class="form-group">
 									<label>School List</label>
 									<select name="school_id" class="form-control">
 										<option value="">Select </option>
 										<?php foreach ($getSchool as $val) { ?>
 											<option value="<?= @$val->id ?>"><?= @$val->school_name ?></option>
 										<?php } ?>
 									</select>
 								</div>
 							</div>
 							
 							
 							<div class="col-md-3 mb-3" id="mutiques">
 								<div class="form-group">
 									<label>Important Questions</label>
 									<select name="importent_id" class="form-control">
 										<option value="">No Importent </option>
 										<option value="importent">Importent </option>
 									</select>
 								</div>
 							</div>



 							<div class="col-md-12 mb-3">
 								<div class="form-group">
 									<label>Question</label>
 									<textarea id="editor1" name="question_name" rows="10" cols="80"> <?php echo set_value('question_name') ?></textarea>
 									<?php echo form_error('question_name'); ?>
 								</div>
 							</div>
 						</div>



 						<div class="row" id="descid">

 							<div class="col-md-6 mb-3">
 								<div class="form-group">
 									<label>Option A </label>
 									<textarea id="editor2" name="answer1" rows="10" cols="80" style="height: 200px;"> <?php echo set_value('answer1') ?></textarea>
 									<?php echo form_error('answer1'); ?>
 								</div>

 							</div>

 							<div class="col-md-6 mb-3">
 								<div class="form-group">
 									<label>Option B </label>
 									<textarea id="editor3" name="answer2" rows="10" cols="80" style="height: 200px;"> <?php echo set_value('answer2') ?></textarea>
 									<?php echo form_error('answer2'); ?>
 								</div>

 							</div>

 							<div class="col-md-6 mb-3">
 								<div class="form-group">
 									<label>Option C </label>
 									<textarea id="editor4" name="answer3" rows="10" cols="80" style="height: 200px;"> <?php echo set_value('answer3') ?></textarea>

 									<?php echo form_error('answer3'); ?>
 								</div>

 							</div>

 							<div class="col-md-6 mb-3">
 								<div class="form-group">
 									<label>Option D </label>
 									<textarea id="editor5" name="answer4" rows="5" cols="40" style="height: 168px !important;"> <?php echo set_value('answer4') ?></textarea>

 									<?php echo form_error('answer4'); ?>
 								</div>

 							</div>




 						</div>
 						<div class="row">

 							<div class="col-md-12 mb-3">
 								<div class="form-group">
 									<label>Answer Description</label>
 									<textarea id="editor6" name="description_answer" rows="10" cols="80"> <?php echo set_value('description_answer') ?></textarea>
 									<?php echo form_error('description_answer'); ?>
 								</div>
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
 <script>
 	function getQuestion(id) {
 		if (id == 5) {
 			$("#mutiques").hide();
 			$("#descid").show();
 			$("#firstand").show();
 		} else {
 			$("#descid").hide();
 			$("#mutiques").hide();
 			$("#firstand").hide();
 		}
 		/*if(id==3){
 		                                   $("#descid").hide(); 
 		                                   $("#mutiques").hide();
 		                                   $("#firstand").hide();
 		                               }else if(id==2){
 		                               $("#mutiques").show();
 		                               $("#firstand").show();
 		                               $("#descid").show();
 		                               }*/
 	}
 </script>