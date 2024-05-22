<style>
    .form-group p {
        color: #ff0000;
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


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Class</label>

                                    <select name="class_id" id="class_id" class="form-control" disabled onchange="getClass(this.value)">
                                        <option value="">Select Class</option>
                                        <?php foreach ($getClass as $val) { ?>
                                            <option value="<?= $val->id ?>" <?php if (@$fatchpRecord->class_id == $val->id) {
                                                                                echo "selected";
                                                                            } ?>><?= $val->class_name ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="text-danger classerror"></span>

                                </div>
                            </div>



                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Subject</label>
                                    <input id="subject_id" name="subject_id" value="<?php echo subjectName(@$fatchpRecord->subject_id) ?>" class="form-control" readonly>
                                    <span class="text-danger subjecterror"></span>

                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Board</label>
                                    <select name="board_id" id="board_id" class="form-control" disabled>
                                        <option value="">Select Board</option>
                                        <?php foreach ($getBoard as $val) { ?>
                                            <option value="<?= $val->id ?>" <?php if (@$fatchpRecord->board_id == $val->id) {
                                                                                echo "selected";
                                                                            } ?>><?= $val->board_type_name ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="text-danger boarderror"></span>
                                    <?php //echo form_error('board_id'); 
                                    ?>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>School/Institute Name</label>
                                    <select name="school_id" id="school_id" class="form-control" disabled>

                                        <?php //foreach ($getschool as $val) { 
                                        ?>
                                        <option value="<?= @$getschool->id ?>" <?php if (@$fatchpRecord->school_id == $val->id) {
                                                                                    echo "selected";
                                                                                } ?>><?= @$getschool->school_name ?></option>
                                        <?php //} 
                                        ?>
                                    </select>
                                    <span class="text-danger schoolerror"></span>

                                </div>

                            </div>



                        </div>

                        <div class="row pt-2 pb-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Pepar Type</label>
                                    <select name="exam_id" id="exam_id" class="form-control" onclick="getGroupExam(this.value)" disabled>
                                        <option value="">Select Pepar Type</option>
                                        <?php foreach ($getPepartype as $val) { ?>
                                            <option value="<?= $val->id ?>" <?php if (@$fatchpRecord->exam_id == $val->id) {
                                                                                echo "selected";
                                                                            } ?>><?= $val->exam_name ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="text-danger peparerror"></span>
                                    <?php //echo form_error('exam_id'); 
                                    ?>
                                </div>

                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Exam</label>
                                    <input id="group_exam_id" name="group_exam_id" value="<?php echo groupExmName($fatchpRecord->group_exam_id) ?>" class="form-control" readonly>

                                    <?php echo form_error('group_exam_id'); ?>
                                </div>

                            </div>
                            <div class="col-md-5 mb-3">
                                <div class="form-group ">
                                    <label>Exam/Test Name</label>
                                    <input id="exam_name" name="exam_name" value="<?php echo $fatchpRecord->exam_name ?>" class="form-control" readonly>
                                    <?php //echo form_error('exam_name'); 
                                    ?>
                                    <span class="text-danger examerror"></span>
                                </div>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Instruction</label>
                                    <select name="instruction_id" id="instruction_id" class="form-control">
                                        <option value="1" <?php if ($fatchpRecord->instruction_id == 1) {
                                                                echo "selected";
                                                            } ?>>Instruction Show</option>
                                        <option value="0" <?php if ($fatchpRecord->instruction_id == 0) {
                                                                echo "selected";
                                                            } ?>>Instruction Hide</option>
                                    </select>
                                    <?php echo form_error('instruction_id'); ?>
                                </div>

                            </div>


                           <h4>Categories:-</h4>

                           

                            <input type="hidden" id="paperId" value="<?= base64_decode($_GET['pepar_id']) ?>" name="paperId">


                            <div class="row">
                                <?php foreach ($question_type as $val) {
                                    // Initialize variables
                                    $isChecked = '';
                                    $isNOTChecked = '';
                                    $isValue = '';
                                    
                                    foreach ($pepar_question as $value) {
                                        $question_mark = explode(",", $value->question_mark);
                                        $check_question_id = explode(",", $value->check_question_id);
                                        //$isNOTChecked = 'display: none;';
                                        if (in_array($val->question_type_id, $check_question_id)) {
                                            $isChecked = 'checked="checked"';
                                            //$isNOTChecked = 'display: block';
                                            $isValue = $value->question_mark;
                                            break;  
                                        }
                                    }
                                ?>
                                    <div class="form-check col-sm-4">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="question_check_id[]" value="<?= $val->question_type_id ?>" <?= $isChecked ?> onclick="showInput(this)">
                                            <?= question_typeName($val->question_type_id) ?>
                                            <input type="text" class="form-control-" name="question_type_<?= $val->question_type_id ?>[]" value="<?= $isValue ?>" style="width: 34%;<?= $isNOTChecked?>">
                                        </label>
                                        <?= form_error('question_type'); ?>
                                    </div>
                                <?php } ?>

                            </div>
                            <hr>


                            <div class="">
                                <button type="button" class="btn btn-info btn-fill btn-wd" onclick="getEditPepar()">Update & Next </button>
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
        function getEditPepar() {
            var formData = $('#myform').serialize();
            $.ajax({
                url: '<?php echo site_url('teacher_create_pepar/editQuestion_typePepar'); ?>', // Replace with your controller and method
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(response) {
                    console.log(response); // Log the response to inspect its contents
                    if (response) {
                        window.location.href = '<?= base_url() ?>teacher_capter?pepar_id=' + response;
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

        function getClass(id) {
            window.location.href = '<?= base_url() ?>teacher_create_pepar?class_id=' + id;
        }


        function getQuestionType(subid, classid) {
            $.ajax({
                url: "<?= base_url() ?>teacher_create_pepar/getQuestionType",
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



        function getGroupExam(id) {
            $.ajax({
                url: "<?= base_url() ?>teacher_create_pepar/getGroupExam",
                type: "post",
                data: {
                    id: id
                },
                success: function(data) {
                    $("#group_exam_id").html(data);
                }

            });
        }
    </script>