<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Teacher_question extends MY_Controller
{

    protected $access = array('admin', 'teacher');
    private $table = "tbl_teacher_capter";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Capter_question_model', 'capter_question');
        $this->load->model('Question_model', 'question');
        $this->load->model('Pepar_model', 'pepar');
        $this->load->model('person_model', 'person');
        $this->load->model('Question_type_model', 'question_type');
         $this->load->model('Pepar_question_type_model', 'pepar_question_type');
        $this->load->model('Order_model', 'order');
        $this->load->model('Class_model', 'class');
        $this->load->model('Subject_model', 'subject');
        $this->load->model('Board_type_model', 'board');
        $this->load->model('Class_subject_model', 'class_subject');
        $this->load->model('Correct_answer_model', 'correct_answer');
        $this->load->model('Chapter_model', 'chapter');
        $this->load->model('Employee_subject_model', 'employee_subject');
        $this->load->model('Exercise_model', 'exercise');
        $this->load->model('School_model', 'school');
    }




    public function index()
    {
        $data['title'] = "Suggested Question";
        $data['include'] = 'teacher/teacher_question_list';

        $empId = $this->session->userdata('id');
        $date = date('Y-m-d');
        $role = $this->session->userdata('role');
        $pepar_id =  base64_decode($_GET['pepar_id']);
        $check = $this->order->checkPlanTeacher($empId);
        $qty = subject_QTY_teacher($check->id) ?? 0;

        if ($check) {
            $type_id =  $_GET['type_id'];
            $data['getquestion_type'] = $this->pepar_question_type->get_by_pepar_question_empid($empId,$pepar_id);
            $clas_sub_id = $this->input->get('clas_sub_id');
            $data['getcorrect_answer'] = $this->correct_answer->get_active_correct();
            $data['getquestiontype'] = $this->question_type->get_active_section();
            $data['getexercise'] = $this->exercise->get_active_Quesexercise($clas_sub_id);
            $data['getTeacher'] = $this->pepar->get_active_teacher_pepar($empId, $pepar_id);
            $createTeacherPepar = $this->pepar->get_create_teacher_pepar($pepar_id);
            
            //$id = $this->session->userdata('id');
            //$data['getSchool'] = $this->school->get_by_school_Admin($id);
            // print_r($createTeacherPepar);die;
            // print_r($data['draftTeacherPepar']);die;
            //$data['getquestion_type'] = $this->question_type->get_active_section();
            // $data['getQuestion_by_EMP'] = $this->capter_question->getQuestion_by_Emp($empId,$pepar_id,$type_id,$offset);
            //echo $this->db->last_query();
            
            if ($createTeacherPepar) {
                $redirectUrl = base_url() . "teacher_generate_paper?pepar_id=" . $_GET['pepar_id'];
                header('Location:' . $redirectUrl);
            }
            
            $this->load->view("admin/layout/main", $data);
        } else {
            return redirect('teacher_plan');
        }
    }


    public function countAllRecord()
    {
        //echo "<pre>";
        // print_r($_GET);die;
        $this->capter_question->get_active_count_ajax($_GET);
    }


    public function fatchAllRecord()
    {
        $lastId = @$_GET['lastId'];
        $fatchAllQuestion = $this->capter_question->get_fatchAllQuestion($lastId, $_GET);
        $i = 1;
        ?>

        <?php

        foreach ($fatchAllQuestion as $val) { ?>
            <li class="list-group-item draggable">
                <input type="hidden" name="question_id" value="<?= $val->id ?>" id="question_id">
                <div class="question_wrapper">
                    <div class="q_head d-flex align-items-center">
                        <input type="hidden" name="selfQues" value="" id="selfQues" />
                        <label class="d-block">Question <span class="question-number"></span></label>
                        <div class="marks"><input name="qmark" class="form-control-use marks-input" value="<?php question_mark($val->question_type) ?>" id="qmark" />Marks</div>
                        <div class="actionTab d-flex">
                            <a class="itemMerge btn btn-sm btn-primary bi bi-sign-merge-right" onclick="setActiveParent(this)"></a>
                            <span class="add-button btn btn-primary bi bi-plus" onclick="moveItem(this)"></span>
                        </div>
                    </div>

                    <p><?= $val->question_name ?></p>
                    <?php if (@$val->question_type == 5) { ?>
                        <div class="row">
                            <div class="col-xl-6">
                                <span class="me-2">(a) <?= $val->answer1 ?></span>
                            </div>
                            <div class="col-xl-6">
                                <span class="me-2">(b) <?= $val->answer2 ?></span>
                            </div>
                            <div class="col-xl-6">
                                <span class="me-2">(c) <?= $val->answer3 ?></span>
                            </div>
                            <div class="col-xl-6">
                                <span class="me-2">(d) <?= $val->answer4 ?></span>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="listline-wrapper mb-4">
                        <span class="item"><?= $val->chapter_name ?></span>
                        <?php if($val->importent_id!=''){?>
                         <span class="item"><?= ucwords($val->importent_id) ?></span>
                         <?php } ?>
                        <?php mark_question($val->question_type) ?>
                    </div>

                </div>
            </li>

        <?php $i++;
        }   ?>



        <?php

    }

    public function save_question_list()
    {
        $empId = $this->session->userdata('id');
        $data = array(
            'empId' => $empId,
            'type_id' => $_POST['type_id'],
            'pepar_id' => base64_decode($_POST['pepar_id']),
            'questions' => $_POST['questions'],
            'totalMarks' => $_POST['totalMarks'],
            'paperTime' => $_POST['paperTime'],
            'finalSaveStatus' => $_POST['finalSaveStatus'],
            'saveAsDraft' => $_POST['saveAsDraft'],
            'questionTypesRecord' => $_POST['questionTypesRecord'],
        );
        // print_r($data);die;
        $checkExist = $this->capter_question->check_question_paper($empId, $_POST['type_id'], base64_decode($_POST['pepar_id']));

        if (count((array)$checkExist) == 0) {
            $this->capter_question->save_question_paper($data);
        } else {
            $this->capter_question->update_question_paper($empId, $_POST['type_id'], base64_decode($_POST['pepar_id']), $data);
        }
    }
    public function save_own_question()
    {

        if ($this->form_validation->run('questionval')) {



            $data = array(

                'pepar_id' => $this->input->post('pepar_id'),
                'question_type' => $this->input->post('question_type'),
                'question_name' => $this->input->post('question_name'),
                'answer1' => $this->input->post('answer1'),
                'answer2' => $this->input->post('answer2'),
                'answer3' => $this->input->post('answer3'),
                'answer4' => $this->input->post('answer4'),
                'currect_ans' => $this->input->post('currect_ans'),
                'currect_ans2' => $this->input->post('currect_ans2'),
                'description_answer' => $this->input->post('description_answer'),
                'type_id' => $this->input->post('type_id'),
                'created_by' => $this->session->userdata('id')

            );
            // print_r($data);die;

            $insert = $this->question->saveOwnQues($data);
            // print_r($insert);die;
            if ($insert) { ?>

                <li class="list-group-item draggable">
                    <input type="hidden" name="question_id" value="<?= $insert ?>" id="question_id">
                    <div class="question_wrapper">
                        <div class="q_head d-flex align-items-center">
                            <input type="hidden" name="selfQues" value="1" id="selfQues" />
                            <label class="d-block">Question <span class="question-number"></span></label>
                            <div class="marks"><input name="qmark" class="form-control-use marks-input" value="" id="qmark" />Marks</div>
                            <div class="actionTab d-flex">
                                <a class="itemMerge btn btn-sm btn-primary bi bi-sign-merge-right" onclick="setActiveParent(this)"></a>
                                <span class="add-button btn btn-primary bi bi-x" onclick="moveItem(this)"></span>
                            </div>
                        </div>


                        <p><?= $data['question_name'] ?></p>
                        <?php if (@$data['question_type'] == 5) { ?>
                            <div class="row">
                                <div class="col-xl-6">
                                    <span class="me-2">(a) <?= $data['answer1'] ?></span>
                                </div>
                                <div class="col-xl-6">
                                    <span class="me-2">(b) <?= $data['answer2'] ?></span>
                                </div>
                                <div class="col-xl-6">
                                    <span class="me-2">(c) <?= $data['answer3'] ?></span>
                                </div>
                                <div class="col-xl-6">
                                    <span class="me-2">(d) <?= $data['answer4'] ?></span>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="listline-wrapper mb-4">
                            <span class="item"></span>
                        </div>

                    </div>
                </li>
                <?php
            }
        }
    }
    public function get_draft_question()
    {
        $empId = $this->session->userdata('id');
        $peparId = $_POST['pepar_id'];
        $draftTeacherPepar = $this->pepar->get_draft_teacher_pepar($empId, $peparId);
        // print_r(json_decode($draftTeacherPepar[0]->questions)[0]->isComplementary);die;

        if ($draftTeacherPepar) {
            $questionList = json_decode($draftTeacherPepar[0]->questions);
            if (!empty($questionList)) {
                foreach ($questionList as $key => $questionRec) {
                    if ($questionRec->selfQues == 1) {
                        $questionAll = teacherSelfQuestion($questionRec->questionId, $questionRec->marks);
                    } else {
                        $questionAll = teacherQuestion($questionRec->questionId, $questionRec->marks);
                    }
                    foreach ($questionAll as $k => $val) {
                        if ($questionRec->isComplementary) {
                            //for showing complementry questions
                ?>
                            <li class="list-group-item draggable setActive setMerge removeActiveMerge" data-index="<?= $k + 1 ?>">
                                <input type="hidden" name="question_id" value="<?= $val->id ?>" id="question_id">
                                <div class="question_wrapper">
                                    <div class="q_head d-flex align-items-center">
                                        <input type="hidden" name="selfQues" value="<?= $questionRec->selfQues ?>" id="selfQues">
                                        <label class="d-block">Question <span class="question-number"><?= $k + 1 ?></span></label>
                                        <div class="marks"><input name="qmark" class="form-control-use marks-input" value="<?= $questionRec->marks ?>" id="qmark">Marks
                                        </div>
                                        <div class="actionTab d-flex">
                                            <a class="itemMerge btn btn-sm btn-primary bi bi-sign-merge-right" onclick="setActiveParent(this)"></a>
                                            <span class="add-button btn btn-primary bi bi-x" onclick="moveItem(this)"></span>
                                        </div>
                                    </div>

                                    <p><?= $val->question_name ?></p>
                                    <?php if (@$val->question_type == 5) { ?>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <span class="me-2">(a) <?= $val->answer1 ?></span>
                                            </div>
                                            <div class="col-xl-6">
                                                <span class="me-2">(b) <?= $val->answer2 ?></span>
                                            </div>
                                            <div class="col-xl-6">
                                                <span class="me-2">(c) <?= $val->answer3 ?></span>
                                            </div>
                                            <div class="col-xl-6">
                                                <span class="me-2">(d) <?= $val->answer4 ?></span>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="listline-wrapper mb-4">
                                         
                                        <?php if(isset($val->chapter)){ ?>
                                            <span class="item"><?= chapterName($val->chapter) ?></span>
                                        <?php } ?> 
                                        <?php mark_question($val->question_type) ?>

                                    </div>

                                </div>
                                <?php
                                if ($questionRec->isComplementary->selfQues == 1) {
                                    $compQuestionAll = teacherSelfQuestion($questionRec->isComplementary->questionId, $questionRec->isComplementary->marks);
                                } else {
                                    $compQuestionAll = teacherQuestion($questionRec->isComplementary->questionId, $questionRec->isComplementary->marks);
                                }
                                foreach ($compQuestionAll as $compVal) {

                                ?>

                                    <ul>
                                        <li class="list-group-item draggable" data-index="<?= $k + 1 ?>">
                                            <input type="hidden" name="question_id" value="<?= $compVal->id ?>" id="question_id">
                                            <div class="question_wrapper">
                                                <div class="q_head d-flex align-items-center">
                                                    <input type="hidden" name="selfQues" value="<?= $questionRec->isComplementary->selfQues ?>" id="selfQues">
                                                    <label class="d-block">Question <span class="question-number"><?= $k + 1 ?></span></label>
                                                    <div class="marks"><input name="qmark" class="form-control-use marks-input" value="<?= $questionRec->isComplementary->marks ?>" id="qmark">Marks
                                                    </div>
                                                    <div class="actionTab d-flex">
                                                        <a class="itemMerge btn btn-sm btn-primary bi bi-sign-merge-right" onclick="setActiveParent(this)"></a>
                                                        <span class="add-button btn btn-primary bi bi-x" onclick="moveItem(this)"></span>
                                                    </div>
                                                </div>


                                                <p><?= $compVal->question_name ?></p>
                                                <?php if (@$compVal->question_type == 5) { ?>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <span class="me-2">(a) <?= $compVal->answer1 ?></span>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <span class="me-2">(b) <?= $compVal->answer2 ?></span>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <span class="me-2">(c) <?= $compVal->answer3 ?></span>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <span class="me-2">(d) <?= $compVal->answer4 ?></span>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="listline-wrapper mb-4">
                                                    <?php if(isset($compVal->chapter)){ ?>
                                                        <span class="item"><?= chapterName($compVal->chapter) ?></span>
                                                    <?php } ?> 
                                                    <?php mark_question($compVal->question_type) ?>

                                                </div>

                                            </div>
                                        </li>
                                    </ul>
                                     
                                <?php }  ?>
                            </li>



                        <?php
                        }
                        if ($questionRec->isComplementary == null) {
                            //for showing without complementry
                        ?>
                            <li class="list-group-item draggable" data-index="<?= $k + 1 ?>">
                                <input type="hidden" name="question_id" value="<?= $val->id ?>" id="question_id">
                                <div class="question_wrapper">
                                    <div class="q_head d-flex align-items-center">
                                        <input type="hidden" name="selfQues" value="<?= $questionRec->selfQues ?>" id="selfQues">
                                        <label class="d-block">Question <span class="question-number"><?= $k + 1 ?></span></label>
                                        <div class="marks"><input name="qmark" class="form-control-use marks-input" value="<?= $questionRec->marks ?>" id="qmark">Marks
                                        </div>
                                        <div class="actionTab d-flex">
                                            <a class="itemMerge btn btn-sm btn-primary bi bi-sign-merge-right" onclick="setActiveParent(this)"></a>
                                            <span class="add-button btn btn-primary bi bi-x" onclick="moveItem(this)"></span>
                                        </div>
                                    </div>

                                    <p><?= $val->question_name ?></p>
                                    <?php if (@$val->question_type == 5) { ?>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <span class="me-2">(a) <?= $val->answer1 ?></span>
                                            </div>
                                            <div class="col-xl-6">
                                                <span class="me-2">(b) <?= $val->answer2 ?></span>
                                            </div>
                                            <div class="col-xl-6">
                                                <span class="me-2">(c) <?= $val->answer3 ?></span>
                                            </div>
                                            <div class="col-xl-6">
                                                <span class="me-2">(d) <?= $val->answer4 ?></span>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="listline-wrapper mb-4">
                                        <?php if(isset($val->chapter)){ ?>
                                            <span class="item"><?= chapterName($val->chapter) ?></span>
                                       <?php } ?>
                                        
                                        <?php mark_question($val->question_type) ?>

                                    </div>

                                </div>
                            </li>
<?php
                        }
                    }
                }
            }
 
        } else {
            $a = '';
        }
    }
}
