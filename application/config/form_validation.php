<?php 
$config = array(     
    
    'peparV' => array(
        
        array(
        'field' => 'board_id',
        'label' => 'Board name',
        'rules' => 'required'
        ),
         array(
        'field' => 'class_id',
        'label' => 'Class name',
        'rules' => 'required'
        ),
         array(
        'field' => 'subject_id',
        'label' => 'Subject name',
        'rules' => 'required'
        ),
        
        array(
        'field' => 'exam_id',
        'label' => 'Pepar Type',
        'rules' => 'required'
        ),
         array(
        'field' => 'group_exam_id',
        'label' => 'Group Exam',
        'rules' => 'required'
        ),
        array(
        'field' => 'exam_name',
        'label' => 'Exam Name',
        'rules' => 'required'
        ),
         array(
        'field' => 'school_id',
        'label' => 'School Name',
        'rules' => 'required'
        ),
        
        
         array(
        'field' => 'mcq',
        'label' => 'MCQ',
        'rules' => 'required'
        ),
         array(
        'field' => 'case_study',
        'label' => 'CASE STUDY',
        'rules' => 'required'
        ),
         array(
        'field' => 'long_question',
        'label' => 'LONG QUESTION',
        'rules' => 'required'
        ),
         array(
        'field' => 'shot_question',
        'label' => 'SHOT QUESTION',
        'rules' => 'required'
        ),
         array(
        'field' => 'vshot_question',
        'label' => 'VERY SHOT QUESTION',
        'rules' => 'required'
        ),
       
        ),

'questionval' => array(
        array(
        'field' => 'question_type',
        'label' => 'Question Type',
        'rules' => 'required'
        ),
        /*array(
        'field' => 'currect_ans',
        'label' => 'Currect answer',
        'rules' => 'required'
        ),*/
        array(
        'field' => 'question_name',
        'label' => 'Question',
        'rules' => 'required'
        ),
        
        ),

        'about' => array(
            array(
                  'field' => 'heading',
                  'label' => 'Heading',
                  'rules' => 'required'
                  ),
            ),
            
            
            
           'chapterQuestion'=> array(
array(
      'field' => 'capter_id[]',
      'label' => 'Capter',
      'rules' => 'required|trim'
      ),
    
),
'subjectmap'=> array(
array(
      'field' => 'subject_id[]',
      'label' => 'Subject',
      'rules' => 'required|trim'
      ),
    
),

'teachername'=> array(
array(
      'field' => 'teacher_id[]',
      'label' => 'Teacher',
      'rules' => 'required|trim'
      ),
    
),


'studentsmark'=> array(
array(
      'field' => 'marks[]',
      'label' => 'Mark',
      'rules' => 'required|trim'
      ),
    
),

'profile'=> array(
array(
      'field' => 'firstName',
      'label' => 'Name',
      'rules' => 'required|trim'
      ),
    
),

'contact_us'=> array(
array(
      'field' => 'username',
      'label' => 'Name',
      'rules' => 'required|trim'
      ),
      array(
      'field' => 'mobile_no',
      'label' => 'Mobile no',
      'rules' => 'required|trim'
      ),
),



        'signup'=> array(
                array(
                'field' => 'email',
                'label' => 'Email Id',
                'rules' => 'required|trim'),
                array(
                'field' => 'mob',
                'label' => 'Mobile no',
                'rules' => 'required|trim|regex_match[/^[0-9]{10}$/]'),
                array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|trim'),
        
        ),

);
