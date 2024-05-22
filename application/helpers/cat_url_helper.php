<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*function userCheckPlan($createdDate,$plan_validity){
    $ci = &get_instance();
    $ci->load->database();
    $CurrentdateMonth = new DateTime(); // Current date
    $orderDate = new DateTime($createdDate); // Date from $createdDate variable
    
    $interval = $orderDate->diff($CurrentdateMonth);
    $months = $interval->format('%m');
    $sql = "SELECT plan_pepar_qty,plan_name FROM  tbl_order WHERE plan_validity > $months"; 
    $query = $ci->db->query($sql);
    return  $query->row();
}*/


function QuestionMark($questin_type_id){
    $ci = &get_instance();
    $ci->load->database();
    $sql = "SELECT question_type_name,default_no FROM  tbl_question_type WHERE id = $questin_type_id"; 
    $query = $ci->db->query($sql);
     $mark = $query->row();
     echo $mark->question_type_name." question of ".$mark->default_no;
}

function teacherSelfQuestion($questin_id,$mark){
    $ci = &get_instance();
    $ci->load->database();
    $sql = "SELECT * FROM  tbl_question_own_teacher WHERE id = $questin_id"; 
    $query = $ci->db->query($sql);
    return  $query->result();
}



	function pepar_questionType($empId, $pepar_id,$questionType_id)
{
     $ci = &get_instance();
    $ci->load->database();
    $ci->db->select('tbl_pepar_question_id.*, tbl_question_type.full_name,tbl_question_type.question_type_name,tbl_question_type.default_no');
    $ci->db->from('tbl_pepar_question_id');
    $ci->db->join('tbl_question_type', 'tbl_pepar_question_id.check_question_id = tbl_question_type.id');
    $ci->db->where('tbl_pepar_question_id.create_pepar_id', $pepar_id);
    $ci->db->where('tbl_pepar_question_id.created_by', $empId);
    $ci->db->where('tbl_pepar_question_id.check_question_id', $questionType_id);
    $ci->db->order_by('tbl_question_type.full_name');
    $query = $ci->db->get();
    return $query->row();
}



function teacherQuestion($questin_id,$mark){
    $ci = &get_instance();
    $ci->load->database();
    $sql = "SELECT * FROM  tbl_question WHERE id = $questin_id"; 
    $query = $ci->db->query($sql);
    return  $query->result();
}


function mailSend_Pdf($order_id,$empId){
    $ci = &get_instance();
    $ci->load->database();
    $sql = "SELECT * FROM tbl_order WHERE id = $order_id and teacher_id = $empId ORDER BY id DESC"; 
    $query = $ci->db->query($sql);
    $getlastId =   $query->row();
    $gstAmount = $getlastId->plangst;
    $planprice = $getlastId->planprice;
    $planAmount = $getlastId->total_amount; 
    
    $sqlUser = "SELECT state FROM user WHERE id = $empId "; 
    $queryUser = $ci->db->query($sqlUser);
    $lastId =   $queryUser->row();
    
   
    $to =  $getlastId->email;  // User email pass here
    $subject = "Customer Payment";
    $from = 'info@readypaper.in';   
   
    $date= @date('d/m/Y');
    $datebet = @date('Y').'-'. ((int)date('Y')+1);
    
    // Pass here your mail id
    $emailContent = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
    </head>
    <body>
        <table border="1" cellpadding="0" cellspacing="0" style="width:70%">
	<tbody>
		<tr>
			<td colspan="7" style="">
			<h1 align="center" >
            Invoice
            <br>
            <img src="' . base_url() . 'upload/ncs606.jpg" vspace=10 style="width: 40%;" /></h1>
		
			</td>
		</tr>
		<tr>
			<td colspan="7" style="">
			    
             
           <h2 align="center">M/s MICROPLUS SERVICES PRIVATE LIMITED </h2> 
            <p  align="center">Ludhiana, Punjab 141008 India<br> 
            Website: <a href="https://www.readypaper.in/">www.readypaper.in, </a>Mail ld: 
            <a href="mailto:info@readypaper.in">info@readypaper.in</a> </p>
            <h4 align="center">Ph: +919417467890 ,  GST No:- 03AAHCM7553L1Z6</span> </h4>
			</td>
        </tr>
        
		<tr>
			<td colspan="5">
			<h4>M/S,'.$getlastId->name.'</h4>
			<h4>Mobile No:'.$getlastId->mobileNumber.'</h4>
			</td>
			<td><strong>Receipt-No.</strong></td>
			<td><strong align="center">Date</strong></td>
        </tr>
        
		<tr>
			<td style="width:79px;height:19px;">
			<p style="margin-left:3.6pt;"></p>
			</td>
			<td colspan="2">
			<p>Transaction id:- '. $getlastId->providerReferenceId.'</p>
			</td>
			<td></td>
            <td align="center" ></td>
            
				<td rowspan="2" align="center" ><p></br> Red'. $getlastId->id.'</p></td>
			<td rowspan="2"><p> '. $date .'</p></td>
        </tr>
        
	
        
		<tr>
			<td align="center">S.No</td>
			<td colspan="2" align="center"><strong >Plan Details</strong></td>
			
			<td align="center"><strong>Price</strong></td>
			<td align="center"><strong>Amount</strong></td>
        </tr>
        
		<tr>
			<td align="center">1</td>
			<td colspan="2"><p align="center"> '. $getlastId->plan_name.'</p></td>
			
            
			<td align="center">₹ '. $planprice.'</td>
            <td align="center">₹ '. $planprice.'</td>
           
		</tr>';
		
		
		if($lastId->state = 27) {
   
    $emailContent .= '<tr>
        <td colspan="6" align="right"><p>SGST: 9%</p><p>CGST : 9%</p></td>
        <td align="center" ><strong>₹ '.$gstAmount.'</strong></td>
    </tr>';
} else {
   
    $emailContent .= '<tr>
        <td colspan="6" align="right"><p>IGST : 18%</p></td>
        <td align="center" ><strong>₹ '.$gstAmount.'</strong></td>
    </tr>';
}
		

	$emailContent .= '	<tr>
			<td colspan="6" align="right"><p>Amount with GST</p></td>
			<td align="center" ><strong>₹ '. $planAmount.'</strong></td>
		</tr>
		<tr>
			<td colspan="6" ><p>Amount in words:-&nbsp;&nbsp; '. convertToIndianCurrency($planAmount).'</p></td>
			<td >
		
			<p align="center" style="margin-left:8.45pt;">Readypaper</p>
			</td>
        </tr>
        
	
        
	</tbody>
</table>

    </body>
    </html>';
            
     $config['protocol']    = 'smtp';
     $config['smtp_host']    = 'mail.readypaper.in';
     $config['smtp_port']    = '26';
     $config['smtp_timeout'] = '60';
 
     $config['smtp_user']    = 'info@readypaper.in';    //Important
     $config['smtp_pass']    = 'Paika@12#3';  //Important
 
     $config['charset']    = 'utf-8';
     $config['newline']    = "\r\n";
     $config['crlf'] = "\r\n";
     $config['mailtype'] = 'html'; // or html
     $config['validation'] = TRUE; // bool whether to validate email or not 
      
 
     $ci->email->initialize($config);
     $ci->email->set_mailtype("html");
     $ci->email->from($from);
     $ci->email->to($to);
     $ci->email->subject($subject);
     $ci->email->message($emailContent);
     
 
    if($ci->email->send()){ 
        return redirect('teacher_create_pepar'); 
       
    }
    

}


 
 function convertToIndianCurrency($number) {
    $no = round($number);
    $decimal = round($number - ($no = floor($number)), 2) * 100;    
    $digits_length = strlen($no);    
    $i = 0;
    $str = array();
    $words = array(
        0 => '',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen',
        20 => 'Twenty',
        30 => 'Thirty',
        40 => 'Forty',
        50 => 'Fifty',
        60 => 'Sixty',
        70 => 'Seventy',
        80 => 'Eighty',
        90 => 'Ninety');
    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;            
            $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural;
        } else {
            $str [] = null;
        }  
    }
    
    $Rupees = implode(' ', array_reverse($str));
    $paise = ($decimal) ? "And Paise " . ($words[$decimal - $decimal%10]) ." " .($words[$decimal%10])  : '';
    return ($Rupees ? 'Rupees ' . $Rupees : '') . $paise . " Only";
}
 




function question_type_Group($questin_type_id){
    $ci = &get_instance();
    $ci->load->database();
    $sql = "SELECT question_type_name,full_name FROM  tbl_question_type WHERE id = $questin_type_id group by id"; 
    $query = $ci->db->query($sql);
    return  $query->row();
}



function checkActive_TeacherPlan($id,$empId){
    $ci = &get_instance();
    $ci->load->database();
    $sql = "SELECT plan_id FROM tbl_order WHERE plan_id = $id and teacher_id = $empId and code='PAYMENT_SUCCESS' ORDER BY id DESC"; 
    $query = $ci->db->query($sql);
    $rowOrder = $query->num_rows();
    return $rowOrder;
   
}

function getPlan_Active_Subject($plan_name,$teacher_id){
    	$ci=&get_instance();
	    $ci->load->database();
    	$sql_desc = "select *  from tbl_plan WHERE heading='$plan_name'";
    	$query_desc = $ci->db->query($sql_desc)->result();
        return $query_desc;
}

function totalpepar_create($id){
    	$ci=&get_instance();
	    $ci->load->database();
    	$sql_desc = "select count(teacher_id) as tech_sub  from tbl_create_pepar WHERE teacher_id=$id";
    	$query_desc = $ci->db->query($sql_desc)->row();
    	
    	$sqlOrder = "select created_at,plan_pepar_qty  from tbl_order WHERE teacher_id=$id order by id desc";
    	$query = $ci->db->query($sqlOrder)->row();
    
    	
        echo  $query_desc->tech_sub.' / '.$query->plan_pepar_qty.' <br> Order Date:- '.date('d M Y',strtotime($query->created_at));
}


function question_typeName($id){
    	$ci=&get_instance();
	    $ci->load->database();
    	$sql_desc = "select *  from tbl_question_type WHERE id=$id";
    	$query_desc = $ci->db->query($sql_desc)->row();
        echo  $query_desc->question_type_name;
}

function mark_question($id){
	$ci=&get_instance();
	$ci->load->database();
	$sql_desc = "select *  from tbl_question_type WHERE id=$id";
	$query_desc = $ci->db->query($sql_desc)->row();?>
	<span class="item"><?= $query_desc->question_type_name; ?></span>
     <span class="item">Suggested For <?=  $query_desc->full_name;?> Marks  </span>
	
<?php }


function question_mark($id){
	$ci=&get_instance();
	$ci->load->database();
	$sql_desc = "select *  from tbl_question_type WHERE id=$id";
	$query_desc = $ci->db->query($sql_desc)->row();
	echo $query_desc->full_name;
	
 }




function suggested_questions($capter_id,$class_sub_id){
    	$ci=&get_instance();
	    $ci->load->database();
    	$sql_desc = "select *  from tbl_question WHERE chapter=$capter_id and class_sub_id = $class_sub_id limit 20";
    	$query_desc = $ci->db->query($sql_desc)->result();
        return $query_desc;
}

function checkSchool($id){
    $ci = &get_instance();
    $ci->load->database(); 
    $sql = "SELECT count(created_by) as cteacher FROM tbl_school_log WHERE created_by = $id "; 
    $query = $ci->db->query($sql)->row();
    return $query->cteacher;
}






function counteditSchool($id){
	$ci=&get_instance();
	$ci->load->database(); 
	$sql = "select * from tbl_school where id=$id"; 
	$query = $ci->db->query($sql);
	$countRow = $query->row();
   return $countRow->count_school_edit;
}

function subject_list_teacher($name){
	$ci=&get_instance();
	$ci->load->database(); 
	$sql = "select * from tbl_plan where status='Y' and heading='$name'"; 
	$query = $ci->db->query($sql);
	$resultLeft = $query->result();
   return $resultLeft;
}

function subject_QTY_teacher($order_id){
	$ci=&get_instance();
	$ci->load->database(); 
    $sql = "select count(plan_id) as tpepar_qty from tbl_create_pepar where  order_id=$order_id"; //status='Y' and
	$query = $ci->db->query($sql);
	$row = $query->row();
    return $row->tpepar_qty;
}

                                                  

function leftsAds(){
	$ci=&get_instance();
	$ci->load->database(); 
	$sql = "select * from tbl_teacher_ad  where status='Y' order by id desc limit 10"; 
	$query = $ci->db->query($sql);
	$resultLeft = $query->result();
   return $resultLeft;
}

function rightAds(){
	$ci=&get_instance();
	$ci->load->database(); 
	$sql = "select * from tbl_teacher_ad  where status='Y' order by id asc limit 10"; 
	$query = $ci->db->query($sql);
	$rightAds = $query->result();
   return $rightAds;
}


function boardName($board_id){
	$ci=&get_instance();
	$ci->load->database();  	
	$query = $ci->db->query("select * from tbl_board_type where id=$board_id");
	$result = $query->row();
	echo $result->board_type_name;
}



function countChapterQuestion($classid,$subid,$boardid){
	$ci=&get_instance();
	$ci->load->database(); 

 $sql = "select id from tbl_class_subject  where board_id=$boardid and class_id= $classid and subject_id=$subid"; 
   $query = $ci->db->query($sql);
   $rightAds = $query->row();
   //echo $rightAds->id;
   if(@$rightAds->id){
   $sqlChapter = "select * from tbl_chapter  where clas_sub_id=$rightAds->id"; 
   $queryCapter = $ci->db->query($sqlChapter);
   $result = $queryCapter->result();
   return $result;
   }
}

function capter_question_exists($id,$pepar_id,$created_by){
	$ci=&get_instance();
	$ci->load->database(); 

   $sql = "select * from tbl_capter_question  where capter_id=$id and pepar_id= $pepar_id and created_by=$created_by"; 
   $query = $ci->db->query($sql);
   $question = $query->row();
   return $question;
}


function questioncount($id){
	$ci=&get_instance();
	$ci->load->database(); 

    $sql = "select count(question_name) as qname from tbl_question  where chapter=$id"; 
	$query = $ci->db->query($sql);
    $rightAds = $query->row();
   echo $rightAds->qname ;
}
	

function customerName($id){
	$ci=&get_instance();
	$ci->load->database(); 

    $sql = "select firstName,mobile_no,email from user  where id=$id"; 
	$query = $ci->db->query($sql);
    return $rightAds = $query->row();
}

function adminAPI(){
	$ci=&get_instance();
	$ci->load->database(); 
    $sql = "select editor_api from user  where id=1"; 
	$query = $ci->db->query($sql);
    echo $query->editor_api;
}
  
  
 // w0an9ahnqwyr1r8hl0okkmcw8plofgik4npkyhf4sich4865



function navegration_menu(){
	$ci=&get_instance();
	$ci->load->database(); 
	$sql = "select * from tbl_menu_content where menu_id=12 and status='Y'"; 
	$query = $ci->db->query($sql);
	$res = $query->result();?>

   <?php foreach($res as $val){?>
    <li><a href="<?= base_url().'product/'.preg_replace('/\s+/', '-', str_replace('%', ' ',@$val->heading));?>"><?= ucwords($val->heading) ?></a></li>
    
	<?php }}
	
	
	

function facebookhome(){
	$ci=&get_instance();
	  $ci->load->database(); 
	  $sql = "select * from user  where status='Y' and role='admin'"; 
	  $query = $ci->db->query($sql);
	  $row = $query->row();?>
		<li class="ps-header__item"><a href="<?= $row->fb?>" target="_blank">Facebook</a></li>
		<li class="ps-header__item"><a href="<?= $row->intra?>" target="_blank">Instagram</a></li>
		<li class="ps-header__item"><a href="<?= $row->tw?>" target="_blank">YouTube</a></li>
		
	<?php }
function footer_address(){
	$ci=&get_instance();
	  $ci->load->database(); 
	  $sql = "select * from user  where status='Y' and role='admin'"; 
	  $query = $ci->db->query($sql);
	  $row = $query->row();?>
	   <li class="d-flex align-items-start mb-2">
                                            <span class="f-icon mr-20 mt-1"><i class="fas fa-map-marker-alt"></i></span> 
                                            <?= $row->address?>
                                        </li>
                                        <li class="d-flex align-items-start mb-2">
                                            <span class="f-icon mr-20"><i class="fa fa-phone"></i></span>
                                            +91-<?= $row->mobile_no?>
                                        </li>
                                        <li class="d-flex align-items-start mb-2">
                                            <span class="f-icon mr-20"><i class="far fa-envelope"></i></span>
                                            <?= $row->email?>
                                        </li>
                                        
                                         <li class="d-flex align-items-start mb-2">
                                            <span class="f-icon mr-20"><i class="far fa-envelope"></i></span>
                                            feedbackreadypaper@gmail.com
                                        </li>
	  
	<?php } 

function mobile(){
	$ci=&get_instance();
	  $ci->load->database(); 
	  $sql = "select mobile_no from user  where status='Y' and role='admin'"; 
	  $query = $ci->db->query($sql);
	  $row = $query->row();?>
	
		  <a class="theme-color f-700" href="tell:+91 <?= $row->mobile_no?>">+91 <?= $row->mobile_no?></a> 
	<?php } 



function logo(){
	$ci=&get_instance();
	  $ci->load->database(); 
	  $sql = "select * from user  where status='Y' and role='admin'"; 
	  $query = $ci->db->query($sql);
	  $row = $query->row();?>
	   <a href="<?= base_url()?>"> <img class="d-block paika-width" src="<?= base_url() ?>upload/<?= $row->logo?>" alt="<?= $row->firstName?>"> </a>     
	<?php }
	
	function address(){
	  $ci=&get_instance();
		$ci->load->database(); 
		$sql = "select * from user  where status='Y' and role='admin'"; 
		$query = $ci->db->query($sql);
		$row = $query->row();
		echo $row->address;
	   }
	
  

	function social_media(){
		$ci=&get_instance();
		  $ci->load->database(); 
		  $sql = "select * from user  where status='Y' and role='admin'"; 
		  $query = $ci->db->query($sql);
		  $row = $query->row();
		?>
		 <li><a class="ps-social__link facebook" href="<?= $row->fb?>"><i class="fa fa-facebook"> </i><span class="ps-tooltip">Facebook</span></a></li>
		<li><a class="ps-social__link instagram" href="<?= $row->intra?>"><i class="fa fa-instagram"></i><span class="ps-tooltip">Instagram</span></a></li>
		<li><a class="ps-social__link youtube" href="<?= $row->tw?>"><i class="fa fa-youtube-play"></i><span class="ps-tooltip">Youtube</span></a></li>
		<li><a class="ps-social__link linkedin" href="<?= $row->linkend?>"><i class="fa fa-linkedin"></i><span class="ps-tooltip">Linkedin</span></a></li>
	   <?php }
	  
	  
	  function policy(){
		  $ci=&get_instance();
		  $ci->load->database(); 
		  $sql = "select * from tbl_menu where status='Y' order by id desc limit 1,3 "; 
		  $query = $ci->db->query($sql);
		  $res = $query->result();
		  foreach($res as $val){?>
		 <li><a href="<?= base_url().'policy/'.preg_replace('/\s+/', '-', str_replace('%', ' ',@$val->menu_name));?>" class="position-relative d-inline-block mb-3"><?= $val->menu_name?></a>
                                            </li> 
		 <?php } }
	  
	  

function getTeacher_Class_assign($claid,$teacher_id){
	$ci=&get_instance();
	$ci->load->database(); 
	$query = $ci->db->query("select * from tbl_class_teacher where  teacher_id=$teacher_id and class_id = $claid");

	$result = $query->result();
 $count = count($result);
	return $count;
}


function class_subName($id){
	$ci=&get_instance();
	$ci->load->database();  	
	$query = $ci->db->query("select * from tbl_class_subject where id=$id");
	$result = $query->row();
	echo @className($result->class_id) .'  '. @subjectName($result->subject_id);
}
function checkSubjectId($subid,$classid){
	$ci=&get_instance();
	$ci->load->database();  	
	$query = $ci->db->query("select * from tbl_class_subject where subject_id=$subid and class_id=$classid");
	$result = $query->result();
	$count = count($result);
	return $count;
}

function getTeacherClass($claid,$teacher_id){
	$ci=&get_instance();
	$ci->load->database(); 
	$query = $ci->db->query("select * from tbl_teacher_subject where  teacher_id=$teacher_id and class_id = $claid");
	$result = $query->result();
    $count = count($result);
	return $count;
}

function currectName($id){
	$ci=&get_instance();
	$ci->load->database(); 
	$query = $ci->db->query("select * from tbl_correct_answer where id=$id")->row();
	echo @$query->correct_answer;
}

function chapterName($id){
	$ci=&get_instance();
	$ci->load->database(); 
	$query = $ci->db->query("select * from tbl_chapter where id=$id")->row();
	echo $query->chapter_name;
}

function menu($id){
	$ci=&get_instance();
	$ci->load->database(); 
	$sql = "select * from tbl_menu  where id=$id"; 
	$query = $ci->db->query($sql);
	$row = $query->row();
    echo $row->menu_name;
}


function checkSubjectAssign($subject_id,$teacher_id){
	$ci=&get_instance();
	$ci->load->database(); 
	
    $query ="select * from tbl_employee_subject where  employee_id=$teacher_id  and subject_id = $subject_id";
	$query = $ci->db->query($query);
	$result = $query->result();
    $count = count($result);
	return $count;
}

function getTeacherSubject($subject_id,$teacher_id){
	$ci=&get_instance();
	$ci->load->database(); 
	$classid = $_GET['class'];
	$query ="select * from tbl_teacher_subject where class_id = $classid and teacher_id=$teacher_id  and subject_id = $subject_id";
	$query = $ci->db->query($query);
	$result = $query->result();
    $count = count($result);
	return $count;
}

function teacherName($teacher_id){
	$ci=&get_instance();
	$ci->load->database();  	
	$query = $ci->db->query("select * from user where id=$teacher_id");
	$result = $query->row();
	echo $result->firstName;
}
function className($class_id){
	$ci=&get_instance();
	$ci->load->database();  	
	$query = $ci->db->query("select * from tbl_class where id=$class_id");
	$result = $query->row();
	echo $result->class_name;
}

function subjectName($subject_id){
	$ci=&get_instance();
	$ci->load->database();  	
	$query = $ci->db->query("select * from tbl_subject where id=$subject_id");
	$result = $query->row();
	echo $result->subject_name;
}


function groupExmName($exam_id){
	$ci=&get_instance();
	$ci->load->database();  	
	$query = $ci->db->query("select * from tbl_group_exam where id=$exam_id");
	$result = $query->row();
	echo $result->group_exam_name;
}


function countQuestion($empid,$dates,$day){
    	$ci=&get_instance();
	    $ci->load->database();
    	$sql_desc = "select count(question_name) as qname  from tbl_question WHERE created_by=$empid and date(created_at) = '$dates-$day'";
    	$query_desc = $ci->db->query($sql_desc)->row();
        return $query_desc->qname;
}

    	
    	
function attendance($j){
    	$ci=&get_instance();
	    $ci->load->database();
	    $dates = $_GET['date'];
    	$sql_desc = "select *  from user_log WHERE created_by=$_GET[depid] and date(created_at) = '$dates-$j'";
    	$query_desc = $ci->db->query($sql_desc)->row_array();
    	
    	if($query_desc > 1){?>
    	    <button type="button" style="width: 17px;height: 27px;" class="bg-success"> 
                <span  title="Day present" onclick="getIpaddress('<?= $dates?>',<?= $j?>,<?= $_GET['depid']?>)"> P </span> </button>

    	<?php }else{?>
    	   <button type="button" style="width: 17px;height: 27px;" class="bg-default"> 
                <span  title="No Punch"> P </span> </button>

    	<?php } }
