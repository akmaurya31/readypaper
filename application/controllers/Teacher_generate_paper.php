<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher_generate_paper extends MY_Controller {

    protected $access = array('admin','teacher');
    private $table = "tbl_user";

    public function __construct() {
        parent::__construct();
        $this->load->model('Pepar_model', 'pepar');
        $this->load->model('School_model', 'school');
        $this->load->model('Instruction_model', 'instruction');
        $this->load->model('Capter_question_model', 'capter_question');
        $this->load->model('Pepar_question_type_model', 'pepar_question_type');
        
    }

    


	public function index()
	{
	    $empId = $this->session->userdata('id');
        $pepar_id =  base64_decode($_GET['pepar_id']);
        $data['title'] = "Teacher Generate Paper";
        $data['getPepar'] = $this->pepar->get_active_teacher_pepar($empId,$pepar_id);
        $data['getSchool'] = $this->school->get_active_schoolTeacher($empId);
        $data['getInstruction'] = $this->instruction->get_all_instruction($pepar_id,$empId);
        $data['question'] = $this->capter_question->view_by_question($empId,$pepar_id);
        $data['pepar_question_type'] = $this->pepar_question_type->get_by_pepar_question_empid($empId,$pepar_id);
		$data['include'] = 'teacher/generate_paper';
        $this->load->view("admin/layout/main", $data);
	}
	
	
	 
	public function question_pdf()
	{
	    $empId = $this->session->userdata('id');
        $pepar_id =  base64_decode($_GET['pepar_id']);
        $data['title'] = "Teacher Generate Paper";
        $data['getPepar'] = $this->pepar->get_active_teacher_pepar($empId,$pepar_id);
        $data['getSchool'] = $this->school->get_active_schoolTeacher($empId);
        $data['getInstruction'] = $this->instruction->get_all_instruction($pepar_id,$empId);
        $data['question'] = $this->capter_question->view_by_question($empId,$pepar_id);
        $data['pepar_question_type'] = $this->pepar_question_type->get_by_pepar_question_empid($empId,$pepar_id);
       
		$data['include'] = 'teacher/generate_paper_pdf';
        $this->load->view("admin/layout/main", $data);
	}

  public function preview_question_pdf()
    {
        $empId = $this->session->userdata('id');
        $pepar_id = $_POST['pepar_id'];

        $title = "Teacher Generate Paper";
        $getPepar = $this->pepar->get_active_teacher_pepar($empId, $pepar_id);
        $getSchool = $this->school->get_active_schoolTeacher($empId);
        $getInstruction = $this->instruction->get_all_instruction($pepar_id, $empId);
        $question = $this->capter_question->view_by_question($empId, $pepar_id);
        $pepar_question_type = $this->pepar_question_type->get_by_pepar_question_empid($empId, $pepar_id);

?>
        <div class="table-responsive">
            <table class="table table-responsive-md">

                <h1 style="text-align: center;font-size: 18pt;margin-block-start: 0.3em;margin-block-end: 0.3em;font-family: math"><?= @$getSchool->school_name ?></h1>
                <h2 style="text-align: center;font-size: 18pt;margin-block-start: 0.3em;margin-block-end: 0.3em;font-family: math"><?= @$getSchool->address ?></h2>
                <h2 style="text-align: center;font-size: 18pt;margin-block-start: 0.3em;margin-block-end: 0.3em;font-family: math"><?= $getPepar->exam_name ?></h2>



                <table style="width: 81%;position: relative;left: 10%">
                    <tr>
                        <th>
                            <h2 style="text-align: center;font-size: 18pt;margin-block-start: 0.3em;margin-block-end: 0.3em;font-family: math">Class:- <?= className($getPepar->class_id) ?></h2>
                        </th>
                        <th>
                            <h2 style="text-align: center;font-size: 18pt;margin-block-start: 0.3em;margin-block-end: 0.3em;font-family: math">Maximum Marks:- <?= ($question) ? $question->totalMarks : '' ?></h2>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <h2 style="text-align: center;font-size: 18pt;margin-block-start: 0.3em;margin-block-end: 0.3em;font-family: math">Subject:- <?= subjectName($getPepar->subject_id) ?></h2>
                        </th>
                        <th>
                            <h2 style="text-align: center;font-size: 18pt;margin-block-start: 0.3em;margin-block-end: 0.3em;font-family: math">TIME ALLOWED:-<?= ($question) ? $question->paperTime : '' ?></h2>
                        </th>
                    </tr>



                </table>

<?php if($getPepar->instruction_id==1){?>

                <h2 style="font-size: 19pt;margin-block-start: 0.3em;margin-block-end: 0.3em;font-family: math">General instruction</h2>
                <?php if ($getInstruction) {
                    $i = 1;
                    foreach ($getInstruction as $val) { ?>
                        <p style="font-size: 14pt;margin-block-start: 0.3em;margin-block-end: 0.3em;font-family: math"><?= $i ?>. <?= $val->instruction_name ?></p>

                    <?php $i++;
                    }
                } else { 
                    $i = 2;
                    if ($pepar_question_type) {
                        $total_sections = count($pepar_question_type);
                    ?>
                        <p style="font-size: 14pt;margin-block-start: 0.3em;margin-block-end: 0.3em;font-family: math">
                            1 This question paper contains- <?= @$total_sections; ?> sections . Each section is compulsory.
                            However, there are internal choices in some questions.</p>

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
                            <p style="font-size: 14pt;margin-block-start: 0.3em;margin-block-end: 0.3em;font-family: math">
                                <?= $i ?>. Section <?= $section ?> has <?= $value->question_mark ?> <?= $value->question_type_name . " question of " . $value->default_no ?> mark each. </p>
                <?php $i++;
                        }
                    }
                } 
                
                }// end instruction?>



                <div class="table-responsive">
                    <table class="table" style="border-bottom: 1px solid #333">



                        <tr>
                            <th style="text-align: center;font-size: 18px;border">Q.No.</th>
                            <th style="padding: 10px;text-align: center;font-size: 18px"></th>
                            <th style="text-align: center;font-size: 18px;border">Marks</th>
                        </tr>

                        <?php
                        if ($question) {
                            $questionTeacherAll = json_decode($question->questions, true);
                            $i = 1;
                            $prevSection = "";

                            // print_r($questionTeacherAll);
                            if (!empty($questionTeacherAll)) {
                                foreach ($questionTeacherAll as $row) {
                                    if ($row['selfQues'] == 1) {
                                        $questionAll = teacherSelfQuestion($row['questionId'], $row['marks']);
                                    } else {
                                        $questionAll = teacherQuestion($row['questionId'], $row['marks']);
                                    }

                                    foreach ($questionAll as $val) {
                                        //print_r($val);
                                        $questionType = question_type_Group($val->question_type);
                                        $pepar_questionType = $this->pepar_question_type->pepar_questionType($empId, $pepar_id,$val->question_type);
                                        //echo $this->db->last_query();
                                        

                                        if ($val->question_type == $pepar_questionType->check_question_id) {
                                            $section = $pepar_questionType->question_type_name;
                                        } 
                                        
                                        
                                       
                                        if ($prevSection !== $section) {
                                            echo '<tr >
                                                <th style="text-align: center;font-size: 18px;border"></th>
                                                <th style="padding: 10px;text-align: center;font-size: 18px">SECTION <br>' . $section . '</th>
                                                <th style="text-align: center;font-size: 18px;border""></th>
                                              </tr>';
                                            // Update the previous section
                                            $prevSection = $section;
                                        } ?>




                                        <tr>
                                            <td style="">
                                                <h5 style=" font-size: 18px;text-align: center"><?= $i ?></h5>
                                            </td>
                                            <td style="padding: 12px">
                                                <table style="width: 79%">
                                                    <tr><span style=" font-size: 18px">

                                                            <?php $questionText =  $val->question_name; ?>
                                                            <?= preg_replace('/<p>/', '<p style="margin-block-start: 0;margin-block-end: 0">',  $questionText) ?></span></tr>

                                                    <tr>
                                                        <?php if ($val->pic) { ?>
                                                            <img src="<?= base_url() ?>upload/question/<?= $val->pic ?>" style="max-width: 100%;height: auto">
                                                    </tr>
                                                <?php } ?>

                                                <?php if (@$val->question_type == 5) { ?>
                                                    <tr class="my_display_inline" style="text-align:left">
                                                        <td style="width: 5%"><span style=" font-size: 19px;  display:inline">(a)</span> </td>
                                                        <td style="display: inline-flex;font-size: 19px;width: 100%">
                                                            <?= preg_replace('/<p>/', '<p style="margin-block-start: 0; margin-block-end: 0">',  $val->answer1) ?></td>

                                                        <td style="width: 5%"><span style=" font-size: 18px;  display:inline; ">(b)</span></td>
                                                        <td style="display: inline-flex;font-size: 19px;width: 100%">
                                                            <?= preg_replace('/<p>/', '<p style="margin-block-start: 0; margin-block-end: 0">',  $val->answer2) ?> </td>
                                                    </tr>
                                                    <tr class="my_display_inline" style="text-align:left">
                                                        <td style="width: 5%"><span style=" font-size: 18px">(c)</span></td>
                                                        <td style="display: inline-flex;font-size: 19px;width: 100%">
                                                            <?= preg_replace('/<p>/', '<p style="margin-block-start: 0; margin-block-end: 0">',  $val->answer3) ?>
                                                        </td>
                                                        <td style="width: 5%"> <span style=" font-size: 18px; ">(d)</span></td>
                                                        <td style="display: inline-flex;font-size: 19px;width: 100%">
                                                            <?= preg_replace('/<p>/', '<p style="margin-block-start: 0; margin-block-end: 0">',  $val->answer4) ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>

                                                </table>
                                            </td>
                                            <td style="">
                                                <h5 style=" font-size: 18px;text-align: center"><?= $row['marks'] ?></h5>

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
                                           
                                                if ($prevSection !== $section) {
                                                    echo '<tr >
                                                <th style="text-align: center;font-size: 18px;border"></th>
                                                <th style="padding: 10px;text-align: center;font-size: 18px">SECTION <br>' . $section . '</th>
                                                <th style="text-align: center;font-size: 18px;border""></th>
                                              </tr>';
                                                    // Update the previous section
                                                    $prevSection = $section;
                                                } ?>




                                                <tr>
                                                    <td style=""></td>
                                                    <td style="padding: 12px">
                                                        <table style="width: 79%">
                                                            <tr>
                                                                <center><b>OR</b></center>
                                                            </tr>
                                                            <tr><span style=" font-size: 18px">
                                                                    <?= preg_replace('/<p>/', '<p style="margin-block-start: 0; margin-block-end: 0">',  $val->question_name) ?></span></tr>
                                                            <tr>
                                                                <?php if ($val->pic) { ?>
                                                                    <img src="<?= base_url() ?>upload/question/<?= $val->pic ?>" style="max-width: 100%;height: auto">
                                                            </tr>
                                                        <?php } ?>

                                                        <?php if (@$val->question_type == 5) { ?>
                                                            <tr class="my_display_inline" style="text-align:left">
                                                                <td style="width: 5%"><span style=" font-size: 19px;  display:inline">(a)</span> </td>
                                                                <td style="display: inline-flex;font-size: 19px;width: 100%">
                                                                    <?= preg_replace('/<p>/', '<p style="margin-block-start: 0; margin-block-end: 0">',  $val->answer1) ?></td>

                                                                <td style="width: 5%"><span style=" font-size: 18px;  display:inline; ">(b)</span></td>
                                                                <td style="display: inline-flex;font-size: 19px;width: 100%">
                                                                    <?= preg_replace('/<p>/', '<p style="margin-block-start: 0; margin-block-end: 0">',  $val->answer2) ?> </td>
                                                            </tr>
                                                            <tr class="my_display_inline" style="text-align:left">
                                                                <td style="width: 5%"><span style=" font-size: 18px">(c)</span></td>
                                                                <td style="display: inline-flex;font-size: 19px;width: 100%">
                                                                    <?= preg_replace('/<p>/', '<p style="margin-block-start: 0; margin-block-end: 0">',  $val->answer3) ?>
                                                                </td>
                                                                <td style="width: 5%"> <span style=" font-size: 18px; ">(d)</span></td>
                                                                <td style="display: inline-flex;font-size: 19px;width: 100%">
                                                                    <?= preg_replace('/<p>/', '<p style="margin-block-start: 0; margin-block-end: 0">',  $val->answer4) ?>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>

                                                        </table>
                                                    </td>
                                                    <td style="">
                                                        <h5 style=" font-size: 18px;text-align: center"><?= $row['marks'] ?></h5>

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

        </div> <?php
            }
	
	
	
		public function answersheet_question()
	{
	    $empId = $this->session->userdata('id');
        $pepar_id =  base64_decode($_GET['pepar_id']);
        $data['title'] = "Answer Sheet";
        $data['getPepar'] = $this->pepar->get_active_teacher_pepar($empId,$pepar_id);
        $data['getSchool'] = $this->school->get_active_schoolTeacher($empId);
        $data['getInstruction'] = $this->instruction->get_all_instruction($pepar_id,$empId);
        $data['question'] = $this->capter_question->view_by_question($empId,$pepar_id);
        $data['pepar_question_type'] = $this->pepar_question_type->get_by_pepar_question_empid($empId,$pepar_id);
		$data['include'] = 'teacher/answersheet';
        $this->load->view("admin/layout/main", $data);
	}
	
	
	
		public function answersheet_pdf()
	{
	    $empId = $this->session->userdata('id');
        $pepar_id =  base64_decode($_GET['pepar_id']);
        $data['title'] = "Answer Sheet";
        $data['getPepar'] = $this->pepar->get_active_teacher_pepar($empId,$pepar_id);
         $data['getSchool'] = $this->school->get_active_schoolTeacher($empId);
        $data['getInstruction'] = $this->instruction->get_all_instruction($pepar_id,$empId);
        $data['question'] = $this->capter_question->view_by_question($empId,$pepar_id);
       
		$data['include'] = 'teacher/answersheet_pdf';
        $this->load->view("admin/layout/main", $data);
	}
	
	
	

    
    
public function deleteRecords() {
    try {
        $question_ids = $this->input->post('question_id'); // Change to plural 'ids'
        $jsonString = $this->input->post('json_data');
        $jsonData = json_decode($jsonString, true);

        if ($jsonData === null) {
            throw new Exception('Invalid JSON data.');
        }

         $questionIds = array_column($jsonData, 'questionId');
         $questionIds[] = $question_ids; // If you need to include the question_id from the AJAX request
         $this->capter_question->deleteRecords($questionIds); // Perform your delete operation using $questionIds

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}


	
	
	
}

