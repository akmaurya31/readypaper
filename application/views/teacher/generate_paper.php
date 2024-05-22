<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <style>
                span p {
                    display: -webkit-inline-box;
                }

                .paika-card {
                    height: 1050px;
                    overflow-x: auto;
                    padding-bottom: 0px;
                }

                .paika-fixed-left {
                    position: fixed;
                    bottom: 0px;
                }

                .header {
                    height: 5.5rem;
                }

                .nav-header {
                    height: 5.5rem;
                }

                [data-header-position="fixed"] .content-body {
                    padding-top: 5.5rem;
                }

                .dlabnav {
                    width: 20.5rem;
                    padding-bottom: 0;
                    height: calc(100% - 7.5rem);
                    position: absolute;
                    top: 5.5rem;
                }
            </style>

            

            <div class="paika-fixed-left" style="background: #f5f5f5;">
                <div class="row">
                    <div class="col-xl-6"></div>
                    <div class="col-xl-4">
                        <a href="<?= base_url() ?>pdf-preview?pepar_id=<?= $_GET['pepar_id'] ?>" id="saveQuestionsBtn" class="btn btn-warning btn-lg " style="padding: 10px 2.1rem;"><i class="far fa-check-circle me-2"></i> Open in PDF </a>
                        <a href="<?= base_url() ?>answersheet?pepar_id=<?= $_GET['pepar_id'] ?>" class="btn btn-secondary btn-lg" style="padding: 10px 2.1rem;"><i class="far fa-check-circle me-2"></i>View Answers</a>
                    </div>

                </div>
            </div>
            
            <div class="col-lg-12 paika-card">
    <div class="card">
        <!--<div class="card-header">
                                <h4 class="card-title">Recent Payments Queue</h4>
                            </div>-->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-responsive-md">

                    <tr>
                        <th>School/Institute Name :-<?= @$getSchool->school_name ?></th>
                    </tr>
                    <tr>
                        <th>Address:-<?= @$getSchool->address ?> </th>
                    </tr>
                    <tr>
                        <th>Exam Name:- <?= $getPepar->exam_name ?></th>
                    </tr>

                    <tr>
                        <th>Class:- <?= className($getPepar->class_id) ?></th>
                        <th>Maximum Marks:- <?= ($question) ? $question->totalMarks : '' ?></th>
                    </tr>

                    <tr>
                        <th>Subject:- <?= subjectName($getPepar->subject_id) ?></th>
                        <th>TIME ALLOWED :-<?= ($question) ? $question->paperTime : '' ?> </th>
                    </tr>
                </table>


<?php if($getPepar->instruction_id==1){?>
                <table class="table table-responsive-md">

                    <tr>
                        <th><strong>General instruction</strong></th>
                    </tr>
                    <?php if ($getInstruction) {
                        $i = 1;
                        foreach ($getInstruction as $val) { ?>
                            <tr>
                                <td><?= $i ?>. <?= $val->instruction_name ?></td>
                            </tr>

                        <?php $i++;
                        }
                    } else {  $i = 2;
                    if ($pepar_question_type) {
                        $total_sections = count($pepar_question_type);
                    ?>
                    
                    <tr>
                            <td>1 This question paper contains- <?= @$total_sections; ?> sections . Each section is compulsory.
                            However, there are internal choices in some questions.</td>
                        </tr>
                       

                        <?php
                        foreach ($pepar_question_type as $value) {
                            if ($i == 2) {
                                $section = "A";
                            } elseif ($i == 3) {
                                $section = "B";
                            } elseif ($i == 4) {
                                $section = "C";
                            } elseif ($i == 5) {
                                $section = "D";
                            } elseif ($i == 6) {
                                $section = "E";
                            } else {
                                $section = "F";
                            } ?>

                        
                       
                        <tr>
                            <td><?= $i ?>. Section <?= $section ?> has <?= $value->question_mark ?> <?= $value->question_type_name . " question of " . $value->default_no ?> mark each. </td>
                        </tr>
                     <?php $i++;
                        }
                    }
                } ?>



                </table>
<?php } ?>

                <table class="table">
                    <tr>
                        <th>Q.No.</th>
                        <th class="text-center"></th>
                        <th>Marks</th>
                    </tr>

                    <?php
                      if ($question) {
                            $questionTeacherAll = json_decode($question->questions, true);
                            $i = 1;
                            $prevSection = "";
                            $empId = $this->session->userdata('id');
                            $pepar_id =  base64_decode($_GET['pepar_id']);
                            // print_r($questionTeacherAll);
                            if (!empty($questionTeacherAll)) {
                                foreach ($questionTeacherAll as $row) {
                                    if ($row['selfQues'] == 1) {
                                        $questionAll = teacherSelfQuestion($row['questionId'], $row['marks']);
                                    } else {
                                        $questionAll = teacherQuestion($row['questionId'], $row['marks']);
                                    }

                                    foreach ($questionAll as $val) {
                                        
                                        $questionType = question_type_Group($val->question_type);
                                        $pepar_questionType = pepar_questionType($empId, $pepar_id,$val->question_type);
                                        //print_r($val);
                                        if ($val->question_type == $pepar_questionType->check_question_id) {
                                            $section = $pepar_questionType->question_type_name;
                                        } 
                                        
                                        
                                    // Check if the section has changed
                                    if ($prevSection !== $section) {
                                        echo '<tr class="text-center">
                                                            <th ></th>
                                                            <th >SECTION <br>' . $section . '</th>
                                                            <th style=""></th>
                                                        </tr>';
                                        // Update the previous section
                                        $prevSection = $section;
                                    } ?>



                                    <tr>
                                        <td>
                                            <h5><?= $i ?> </h5>
                                        </td>
                                        <td style="">
                                            <table style="width: 79%;">
                                                <tr><span><?= $val->question_name ?></span>
                                                <tr>
                                                    <?php if ($val->pic) { ?>
                                                <tr>
                                                    <img src="<?= base_url() ?>upload/question/<?= $val->pic ?>" class="img-fluid">
                                                </tr>
                                            <?php } ?>

                                            <?php if (@$val->question_type == 5) { ?>
                                                <tr class="my_display_inline">
                                                    <td><span>(a)</span> </td>
                                                    <td> <?= $val->answer1 ?> </td>

                                                    <td><span>(b)</span></td>
                                                    <td><?= $val->answer2 ?> </td>
                                                </tr>
                                                <tr class="my_display_inline">
                                                    <td><span>(c)</span></td>
                                                    <td><?= $val->answer3 ?> </td>
                                                    <td> <span style=" font-size: 18px; ">(d)</span></td>
                                                    <td> <?= $val->answer4 ?></td>
                                                </tr>
                                            <?php } ?>

                                            </table>
                                        </td>
                                        <td style="">
                                            <h5 style=" font-size: 18px;text-align: center;"><?= $row['marks'] ?></h5>

                                        </td>
                                    </tr>


                                         <?php if ($row['isComplementary']) {
                                            // print_r($row['isComplementary']['questionId']);
                                            if ($row['isComplementary']['selfQues'] == 1) {
                                                $selfQuestionAll = teacherSelfQuestion($row['isComplementary']['questionId'], $row['isComplementary']['marks']);
                                            } else {

                                                $selfQuestionAll = teacherQuestion($row['isComplementary']['questionId'], $row['isComplementary']['marks']);
                                            }
                                            foreach ($selfQuestionAll as $val) {
                                                // print_r($val);
                                               // $section = "";

                                            if ($val->question_type == $pepar_questionType->check_question_id) {
                                                $section = $pepar_questionType->question_type_name;
                                            } 

                                            // Check if the section has changed
                                            if ($prevSection !== $section) {
                                                echo '<tr class="text-center">
                                                                <th ></th>
                                                                <th >SECTION ' . $section . '</th>
                                                                <th style=""></th>
                                                            </tr>';
                                                // Update the previous section
                                                $prevSection = $section;
                                            } ?>




                                            <tr>
                                                <td>
                                                    <h5><?= $i ?> </h5>
                                                </td>
                                                <td style="">
                                                    <table style="width: 79%;">
                                                        <tr>
                                                            <center><b>OR</b></center>
                                                        </tr>
                                                        <tr><span><?= $val->question_name ?></span>
                                                        <tr>
                                                            <?php if ($val->pic) { ?>
                                                        <tr>
                                                            <img src="<?= base_url() ?>upload/question/<?= $val->pic ?>" class="img-fluid">
                                                        </tr>
                                                    <?php } ?>

                                                    <?php if (@$val->question_type == 5) { ?>
                                                        <tr class="my_display_inline">
                                                            <td><span>(a)</span> </td>
                                                            <td> <?= $val->answer1 ?> </td>

                                                            <td><span>(b)</span></td>
                                                            <td><?= $val->answer2 ?> </td>
                                                        </tr>
                                                        <tr class="my_display_inline">
                                                            <td><span>(c)</span></td>
                                                            <td><?= $val->answer3 ?> </td>
                                                            <td> <span style=" font-size: 18px; ">(d)</span></td>
                                                            <td> <?= $val->answer4 ?></td>
                                                        </tr>
                                                    <?php } ?>

                                                    </table>
                                                </td>
                                                <td style="">
                                                    <h5 style=" font-size: 18px;text-align: center;"><?= $row['marks'] ?></h5>

                                                </td>
                                            </tr>
                    <?php   }
                                    }

                                    $i++;
                                }
                            }
                        }
                    }


                    ?>
                </table>


            </div>
        </div>
    </div>
</div>
            
        </div>
    </div>
</div>