<style>
.form-group p{
    color:#ff0000;
}
</style>
<div class="content-body">
	<div class="container-fluid">
	    		<div class="row">
			<div class="col-lg-12">
				<div class="card shadow ">
					<div class="card-body">
						<?php $created_by = $this->session->userdata('id');
						        $pepar_id =  base64_decode($_GET['pepar_id']);
						      $attributes = array('class' => '', 'id' => 'myform');
						      echo form_open_multipart("teacher_capter?pepar_id={$_GET['pepar_id']}", $attributes);
						      
						$getTeacherPepar = countChapterQuestion($getTeacher->class_id,$getTeacher->subject_id,$getTeacher->board_id);
						if($getTeacherPepar){?>
						<div class="row">
						    
	                    <div class="col-md-12 ">
								<div class="row">
								    <?php echo form_error('capter_id[]');?>
								    <h3 class='text-info'>CAPTER (<?php className($getTeacher->class_id)?> , <?php subjectName($getTeacher->subject_id)?>)</h3>
								   
								     <?php 
								     foreach ($getTeacherPepar as $val) {
								         $isChecked = capter_question_exists($val->id, $pepar_id, $created_by) ? 'checked' : '';?>
								       <div class="col-md-5">
								    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" id="capter_id" name="capter_id[]" value="<?= $val->id ?>" <?= $isChecked ?>>
                                      <label class="form-check-label" for="inlineCheckbox1"><?= $val->chapter_name?> (<?php questioncount($val->id)?>)</label>
                                      
                                    </div>
                                    
                                    </div>
                                    
                                    <?php }  ?>
                                    
                               
                                    
								</div>
							</div>
						
							
						</div>
 <hr>
								<div class="">
							<button type="submit" class="btn btn-warning btn-fill btn-wd">Save & Next </button>
						</div>
							
                             <?php }else{ 
                                    echo "<h3 class='text-center'>Data Not Found</h3>";?>
                                    
					
						<div class="clearfix"></div>
                                  <?php  } ?>
                                    

						</form>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
    function getGroupExam(id){
         $.ajax({
        url : "<?= base_url()?>teacher_create_pepar/getGroupExam",
        type: "post",
        data: {id:id},
        success: function(data)
        {
            $("#group_exam_id").html(data);
        }

    });
    }
    
    </script>