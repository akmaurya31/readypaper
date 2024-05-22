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
                                    <th>Maximum Marks:- <?= $question->totalMarks ?></th>
                                </tr>

                                <tr>
                                    <th>Subject:- <?= subjectName($getPepar->subject_id) ?></th>
                                    <th>TIME ALLOWED</th>
                                </tr>
                            </table>




                            <table class="table table-responsive-md">

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
                                            <td>

                                                <?php if (@$val->question_type == 5) { ?>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <span class="me-2">
                                                                <?php if ($val->currect_ans == 1) {
                                                                    echo  '(a)' . $val->answer1;
                                                                } else if ($val->currect_ans == 2) {
                                                                    echo '(b) ' . $val->answer2;
                                                                } else if ($val->currect_ans == 3) {
                                                                    echo '(c) ' . $val->answer3;
                                                                } else {
                                                                    echo '(d) ' . $val->answer4;
                                                                } ?></span>
                                                        </div>

                                                    </div>
                                                <?php } else { ?>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <span class="me-2"> <?= $val->description_answer ?></span>
                                                        </div>

                                                    </div>

                                                <?php } ?>

                                            </td>
                                            <td>
                                                <h5><?= $row['marks'] ?> </h5>

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
                                                        <h5 class='text-danger'><? //= $i 
                                                                                ?>OR </h5>
                                                    </td>


                                                    <td>

                                                        <?php if (@$val->question_type == 5) { ?>
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <span class="me-2">
                                                                        <?php if ($val->currect_ans == 1) {
                                                                            echo  '(a)' . $val->answer1;
                                                                        } else if ($val->currect_ans == 2) {
                                                                            echo '(b) ' . $val->answer2;
                                                                        } else if ($val->currect_ans == 3) {
                                                                            echo '(c) ' . $val->answer3;
                                                                        } else {
                                                                            echo '(d) ' . $val->answer4;
                                                                        } ?></span>
                                                                </div>

                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <span class="me-2"> <?= $val->description_answer ?></span>
                                                                </div>

                                                            </div>

                                                        <?php } ?>

                                                    </td>
                                                    <td>
                                                        <h5><?= $row['marks'] ?> </h5>

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

            <div class="paika-fixed-left" style="background: #f5f5f5;">
                <div class="row">
                    <div class="col-xl-7"></div>
                    <div class="col-xl-4">
                        <a href="<?= base_url() ?>pdf-answersheet?pepar_id=<?= $_GET['pepar_id'] ?>" id="saveQuestionsBtn" class="btn btn-success btn-lg " style="padding: 10px 2.1rem;"><i class="far fa-check-circle me-2"></i> Open in PDF </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>