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

           <div class="col-lg-12 paika-card" id="print">
                 <div class="card">
                    <!--<div class="card-header">
                                <h4 class="card-title">Recent Payments Queue</h4>
                            </div>-->
                    <div class="card-body">
                        <div class="table-responsive">
                           
 <h1 style="text-align: center;font-size: 18pt;margin-block-start: 0.3em;margin-block-end: 0.3em;font-family: math;"><?= @$getSchool->school_name ?></h1>
                        <h2 style="text-align: center;font-size: 16pt;margin-block-start: 0.3em;margin-block-end: 0.3em;font-family: math;"><?= @$getSchool->address ?></h2> 
                        <h2 style="text-align: center;font-size: 16pt;margin-block-start: 0.3em;margin-block-end: 0.3em;font-family: math;"><?= $getPepar->exam_name ?></h2>
                               
                     <h2 style="text-align: center;font-size: 15pt;margin-block-start: 0.3em;margin-block-end: 0.3em;font-family: math;">Class:- <?= className($getPepar->class_id) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Subject:- <?= subjectName($getPepar->subject_id) ?></h2>
                       
                     <h2 style="text-align: center;font-size: 15pt;margin-block-start: 0.3em;margin-block-end: 0.3em;font-family: math;">Maximum Marks:- <?= $question->totalMarks ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  TIME ALLOWED:-</h2>
                       
                       
                      

                         
                            <table class="table table-responsive-md">

                                               <tr style="p">
                                                <th >Q.No.</th>
                                                <th style='padding: 1.9375rem 0.625rem;'></th>
                                                <th >Marks</th>
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
                <td><h5><?= $i ?> </h5></td>
                <td>
                   
                    <?php if (@$val->question_type == 5) { ?>
                        <div class="row">
                            <div class="col-xl-6">
                                <span style="position: relative;top: -12px;"> 
                                <?php if($val->currect_ans==1){ 
                                 echo  '<p>(a)'.preg_replace('/<p>/', '<p style="margin-block-start: -34px;margin-block-end: 0px;position: relative;left: 21px;">',  $val->answer1);
                                  
                                  }else if($val->currect_ans==2){ 
                                   echo  '<p>(b)'.preg_replace('/<p>/', '<p style="margin-block-start: -34px;margin-block-end: 0px;position: relative;left: 21px;">',  $val->answer2);
                                  
                                  }else if($val->currect_ans==3){ 
                                    echo  '<p>(c)'.preg_replace('/<p>/', '<p style="margin-block-start: -34px;margin-block-end: 0px;position: relative;left: 21px;">',  $val->answer3);
                                  
                                  }else { 
                                  echo  '<p>(d)'.preg_replace('/<p>/', '<p style="margin-block-start: -34px;margin-block-end: 0px;position: relative;left: 21px;">',  $val->answer4);
                                  
                                  }?></span>
                            </div>
                        </div>
               
                    <?php }else{?>
                    <div class="row">
                            <div class="col-xl-6">
                                <span class="me-2"> <?= $val->description_answer ?></span>
                            </div>
                          
                        </div>
                    
                    <?php }?>
                  
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
          
                <td></td>
                
                
                <td>
                                                
                                                
                    <?php if (@$val->question_type == 5) { ?>
                        <div class="row">
                            <div class="col-xl-6">
                                <span style="position: relative;top: -12px;"> 
                                <?php if($val->currect_ans==1){ 
                                 echo  '<p>(a)'.preg_replace('/<p>/', '<p style="margin-block-start: -34px;margin-block-end: 0px;position: relative;left: 21px;">',  $val->answer1);
                                  
                                  }else if($val->currect_ans==2){ 
                                   echo  '<p>(b)'.preg_replace('/<p>/', '<p style="margin-block-start: -34px;margin-block-end: 0px;position: relative;left: 21px;">',  $val->answer2);
                                  
                                  }else if($val->currect_ans==3){ 
                                    echo  '<p>(c)'.preg_replace('/<p>/', '<p style="margin-block-start: -34px;margin-block-end: 0px;position: relative;left: 21px;">',  $val->answer3);
                                  
                                  }else { 
                                  echo  '<p>(d)'.preg_replace('/<p>/', '<p style="margin-block-start: -34px;margin-block-end: 0px;position: relative;left: 21px;">',  $val->answer4);
                                  
                                  }?></span>
                            </div>
                          
                        </div>
                    <?php }else{?>
                    <div class="row">
                            <div class="col-xl-6">
                                <h4 style="    text-align: center;   padding-top: 16px;">OR </h4>
                                <span class="me-2"> <?= $val->description_answer ?></span>
                            </div>
                          
                        </div>
                    
                    <?php }?>
                  
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
                    }?>


                </table>
    
                        </div>
                    </div>
                </div>
            </div>
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            

         <script>
	function PrintDiv() {
		var divToPrint = document.getElementById('print');
		var popupWin = window.open('');
		popupWin.document.open();
		popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
		popupWin.document.close();
	}
</script>
            <div class="paika-fixed-left" style="background: #f5f5f5;">
                <div class="row">
                    <div class="col-xl-8"></div>
                    <div class="col-xl-4">
                       <button class="btn  btn-success pull-right" onclick="PrintDiv()" id="btnPrint"><i class="fa fa-print fa-sm text-white-50"></i> Print PDF</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>