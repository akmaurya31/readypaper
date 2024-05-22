
<div class="content-body">
	<div class="container-fluid">
	    <div class="row page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item active"><a href="<?= base_url()?>admin_classsub_chapter">Chapter Subjects</a></li>
						<li class="breadcrumb-item"><a class="text-warning"href="<?= base_url()?>admin_chapter?clas_sub_id=<?= $_GET['clas_sub_id']?>"><?php class_subName($_GET['clas_sub_id'])?></a></li>
							<li class="breadcrumb-item"><a href="javascript:void(0)"><?php chapterName($_GET['chapter_id'])?></a></li>
					</ol>
					</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="card shadow ">
					<div class="card-body">
					
	<?php $attributes = array('class' => '', 'id' => 'myform');
					echo form_open_multipart("admin_question/questionEdit?editId={$_GET['editId']}&chapter_id={$_GET['chapter_id']}&clas_sub_id={$_GET['clas_sub_id']}", $attributes); ?>

						    <div class="row">
						            <div class="col-md-3 mb-3">	
						             <div class="form-group  ">
                                            <label class="form-label">Question Type*</label>
									       	<select class="form-control form-control-use" name="question_type" onchange="getQuestion(this.value)">
										     <option value="">Select Type</option>
										
                                           
                                           <?php
											foreach ($getquestiontype as $val) { ?>
 		<option value="<?= $val->question_type_id ?>" <?php if (@$proResult->question_type == $val->question_type_id) {
																				echo "selected";
																			} ?>><?= question_typeName($val->question_type_id) ?></option>
 										<?php   } ?>
                                           
										</select> 
										<span class="help-block"></span>
										 </div>	 </div>
										 
								<div class="col-md-3 mb-3">		 
							 <div class="form-group  ">
                                            <label class="form-label">Exercise*</label>
									       	<select class="form-control form-control-use" name="exercise_id" o>
										     <option value="">Select Exercise</option>
											<?php
											foreach($getexercise as $val){?>
                                                <option value="<?= $val->id?>" <?php if (@$proResult->exercise_id == $val->id) {
																				echo "selected";
																			} ?>><?= $val->exercise_name?></option>
                                           <?php   } ?>
										</select>
										<span class="help-block"></span>
										 </div>
										 </div>

	<div class="col-md-3 mb-3">
								<div class="form-group">
									<label>Question Image </label>
										
							
									<input type="hidden" name="pichidden" value="<?php echo $proResult->pic; ?>" />
									<img style="width:20%" src="<?php echo base_url() ?>upload/question/<?php echo $proResult->pic; ?>">
									<input type="file" class="" name="pic">
							
								</div>
							</div>
							
							    <div class="col-md-3 mb-3">
								<div class="form-group">
									<label>Answer Image </label>
									<input type="hidden" name="pichidden1" value="<?php echo $proResult->pic1; ?>" />
									<img style="width:20%" src="<?php echo base_url() ?>upload/question/<?php echo $proResult->pic1; ?>">
									<input type="file" class="" name="pic1">
							
								</div>
							</div>
								<?php  if (!empty($proResult->currect_ans)){?>
						    	<div class="col-md-2 mb-3"  id="firstand">
								<div class="form-group">
									<label>Correct  Answer</label>
										<select name="currect_ans" class="form-control" >
										<option value="">Select </option>
									<?php foreach($getcorrect_answer as $val){?>
										<option value="<?= $val->id?>" <?php if (@$proResult->currect_ans == $val->id) {
																				echo "selected";
																			} ?>><?= $val->correct_answer?></option>
									<?php } ?>
									</select>
								</div>
							</div>
							
							
								<div class="col-md-2 mb-3" id="mutiques">
								<div class="form-group">
									<label>Correct  Answer 2</label>
										<select name="currect_ans2" class="form-control" >
										<option value="">Select </option>
									<?php foreach($getcorrect_answer as $val){?>
										<option value="<?= $val->id?>" <?php if (@$proResult->currect_ans2 == $val->id) {
																				echo "selected";
																			} ?>><?= $val->correct_answer?></option>
									<?php } ?>
									</select>
								</div>
							</div>
							<?php } ?>
							
							<div class="col-md-3 mb-3" >
								<div class="form-group">
									<label>School List</label>
										<select name="school_id" class="form-control" >
										<option value="">Select </option>
									<?php foreach($getSchool as $val){?>
										<option value="<?= @$val->id?>" <?php if (@$proResult->school_id == $val->id) {
																				echo "selected";
																			} ?>><?= @$val->school_name?></option>
									<?php } ?>
									</select>
								</div>
							</div>
							
							<div class="col-md-3 mb-3" id="mutiques">
 								<div class="form-group">
 									<label>Important Questions</label>
 									<select name="importent_id" class="form-control">
 										<option value="">No Importent </option>
 										<option value="importent"  <?php if (@$proResult->importent_id == 'importent') { echo "selected";	} ?>>Importent </option>
 									</select>
 								</div>
 							</div>

						        <div class="col-md-12 mb-3">
								<div class="form-group">
									<label>Question</label>
								   <textarea id="editor1" name="question_name" rows="10" cols="80"> <?php echo $proResult->question_name; ?></textarea>
									<?php echo form_error('question_name'); ?>
								</div>
							</div>
						    </div>
						
						<?php  if (!empty($proResult->currect_ans)){?>

							<div class="row" id="descid">
						   
						    	<div class="col-md-6 mb-3">
								<div class="form-group">
									<label>Option A </label>
									<textarea   id="editor2" name="answer1" class="form-control border-input" rows="10" cols="80" style="height: 200px;"><?php echo $proResult->answer1; ?></textarea>
									<?php echo form_error('answer1'); ?>
								</div>

							</div>

						     	<div class="col-md-6 mb-3">
								<div class="form-group">
									<label>Option B </label>
									<textarea  id="editor3" name="answer2" class="form-control border-input" rows="10" cols="80" style="height: 200px;"><?php echo $proResult->answer2; ?></textarea>
									<?php echo form_error('answer2'); ?>
								</div>

							</div>
						
								<div class="col-md-6 mb-3">
								<div class="form-group">
									<label>Option C </label>
									<textarea  id="editor4" name="answer3" class="form-control border-input" rows="10" cols="80" style="height: 200px;"><?php echo $proResult->answer3; ?></textarea>
									<?php echo form_error('answer3'); ?>
								</div>

							</div>
							
								<div class="col-md-6 mb-3">
								<div class="form-group">
									<label>Option D </label>
									<textarea  id="editor5" name="answer4" class="form-control border-input"  rows="10" cols="80" style="height: 200px;"> <?php echo $proResult->answer4; ?></textarea>
									<?php echo form_error('answer4'); ?>
								</div>

							</div>
						</div>
						<?php } ?>
						
							<div class="row">	
				    <div class="col-md-12 mb-3">
								<div class="form-group">
									<label>Answer Description</label>
								   <textarea id="editor6" name="description_answer" rows="10" cols="80"> <?php echo $proResult->description_answer; ?></textarea>
									<?php echo form_error('description_answer'); ?>
								</div>
							</div>
							
						
						</div>



						<div class="">
							<button type="submit" class="btn btn-info btn-fill btn-wd">Update </button>
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
//$(document).ready(function() {
    function getQuestion(id){
       
        if(id==5){
        $("#mutiques").hide();
        $("#descid").show(); 
        $("#firstand").show();
        }else{
            $("#descid").hide(); 
            $("#mutiques").hide();
            $("#firstand").hide();
        } 
    }
//});
</script>
