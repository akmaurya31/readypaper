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
						<?php $attributes = array('class' => '', 'id' => 'myform');
						echo form_open_multipart("", $attributes); ?>

						<div class="row">
						    <input type="hidden" name="orderId" value="<?= $orderId?>" id="orderId">
	                  
							<div class="col-md-3">
								<div class="form-group">
									<label>Class</label>
									  <select name="class_id" id="class_id" class="form-control"   onchange="getClass(this.value)">
                        <option value="">Select Class</option>
                        <?php foreach ($getClass as $val) { ?>
                            <option value="<?= $val->id ?>" <?php if(@$_GET['class_id']==$val->id){ echo "selected";}?> ><?= $val->class_name ?></option>
                        <?php } ?>
                    </select>
                    <span class="text-danger classerror"></span>
                   
								</div>
							</div>
							
								
							
							<div class="col-md-3">
								<div class="form-group">
									<label>Subject</label>
									  <select name="subject_id" id="subject_id" class="form-control"  onchange="getQuestionType(this.value,<?= $_GET['class_id']?>)">
                        <option value="">Select Subject</option>
                        <?php foreach ($check as $val) { ?>
                            <option value="<?= $val->subject_id ?>"><?= subjectName($val->subject_id) ?></option>
                        <?php } ?>
                    </select>
                    <span class="text-danger subjecterror"></span>
								
								</div>

							</div>
							  <div class="col-md-3">
								<div class="form-group">
									<label>Board</label>
									  <select name="board_id" id="board_id" class="form-control"   >
                        <option value="">Select Board</option>
                        <?php foreach ($getBoard as $val) { ?>
                            <option value="<?= $val->id ?>" ><?= $val->board_type_name ?></option>
                        <?php } ?>
                    </select>
                    <span class="text-danger boarderror"></span>
                    <?php //echo form_error('board_id'); ?>
								</div>
							</div>
							
								<div class="col-md-3">
								<div class="form-group">
									<label>School/Institute Name</label>
									  <select name="school_id" id="school_id" class="form-control" readonly >
                      
                        <?php //foreach ($getschool as $val) { ?>
                            <option value="<?= @$getschool->id ?>"><?= @$getschool->school_name ?></option>
                        <?php //} ?>
                    </select>
								<span class="text-danger schoolerror"></span>
								
								</div>

							</div>
							

							
						</div>

						<div class="row pt-2 pb-3">
						    <div class="col-md-3">
								<div class="form-group">
									<label>Pepar Type</label>
								<select name="exam_id" id="exam_id" class="form-control" onclick="getGroupExam(this.value)">
                        <option value="">Select Pepar Type</option>
                        <?php foreach ($getPepartype as $val) { ?>
                            <option value="<?= $val->id ?>"><?= $val->exam_name ?></option>
                        <?php } ?>
                    </select>
                    <span class="text-danger peparerror"></span>
									<?php //echo form_error('exam_id'); ?>
								</div>
								
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<label>Exam</label>
								    <select name="group_exam_id" id="group_exam_id" class="form-control">
								        
								    </select>
									<?php echo form_error('group_exam_id'); ?>
								</div>
								
							</div>
							<div class="col-md-5 mb-3">
								<div class="form-group ">
									<label>Exam/Test Name</label>
									<input id="exam_name" name="exam_name" value="<?php echo set_value('exam_name') ?>" class="form-control">
								<?php //echo form_error('exam_name'); ?>
								 <span class="text-danger examerror"></span>
								</div>
							</div>
								<div class="col-md-2">
								<div class="form-group">
							        <label>Instruction</label>
									<select name="instruction_id" id="instruction_id" class="form-control">
                                        <option value="1">Instruction Show</option>
                                         <option value="0">Instruction Hide</option>
                                    </select>
								</div>
							</div>
				            <hr>
                             <div class="question_type_id row"></div>
                             </div>
						<div class="">
							<button type="button" class="btn btn-info btn-fill btn-wd" onclick="getInsertPepar()">Save & Next </button>
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
    function showInput(checkbox) {
        var textInput = checkbox.parentElement.querySelector('.question-type-input');
        var errorSpan = checkbox.parentElement.querySelector('.errormark');
        if (checkbox.checked) {
            textInput.style.display = 'inline-block';
            textInput.setAttribute('required', 'required');
            errorSpan.style.display = 'inline-block';
        } else {
            textInput.style.display = 'none';
            textInput.removeAttribute('required');
            errorSpan.style.display = 'none';
        }
    }
</script>





<script>
function getInsertPepar() {
    // Extract form data
    var formData = $('#myform').serialize();
    var classname = $("#class_id").val();
    var subjectname = $("#subject_id").val();
    var boardname = $("#board_id").val();
    var schoollname = $("#school_id").val();
    var exam_id = $("#exam_id").val();
    var examname = $("#exam_name").val();
   
    // Error handling
    if (classname === '') {
        $('.classerror').text(" Plz Fill Class Name");
    } else if (subjectname === '') {
        $('.subjecterror').text(" Plz Fill Subject Name");
    } else if (boardname === '') {
        $('.boarderror').text("Plz Fill Board Name");
    } else if (schoollname === '') {
        $('.schoolerror').text("Plz Fill School/Institute Name");
    } else if (exam_id === '') {
        $('.peparerror').text("Plz Fill Pepar Type");
    } else if (examname === '') {
        $('.examerror').text("Plz Fill Exam/Test Name");
    } else {
        // Send AJAX request
        $.ajax({
            url: '<?php echo site_url('teacher_create_pepar/insertpepar'); ?>', // Replace with your controller and method
            type: 'POST',
            dataType: 'json',
            data: formData,
            success: function(response) {
               console.log(response); // Log the response to inspect its contents
            if (response) {
                window.location.href = '<?= base_url()?>teacher_capter?pepar_id=' + response;
            } else {
                alert('Error occurred while submitting the form. Please try again later.');
            }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Please click on Categories and fill in the  number of questions.');
            }
        });
    }
}





function getClass(id)
{
    window.location.href = '<?= base_url()?>teacher_create_pepar?class_id='+id;
}


function getQuestionType(subid, classid) {
    $.ajax({
        url: "<?= base_url()?>teacher_create_pepar/getQuestionType",
        type: "post",
        data: {
            subid: subid,
            classid: classid
        },
        success: function(data) {
            //alert(data);
            $(".question_type_id").html(data);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}



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